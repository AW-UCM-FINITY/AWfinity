<?php 
namespace es\ucm\fdi\aw;

class PelisReto{

    public function __construct(){

    }

    /* Devolver un array de peliculas vinculado a un reto determinado */
    static public function getPelisporReto($reto){
	
        $conn =  Aplicacion::getInstance()->getConexionBd();

        $sql = "SELECT * FROM pelisreto WHERE id_Reto = $reto";
        
		$consulta = $conn->query($sql);
        $arrayLibros = array();

       if($consulta->num_rows > 0){
	        while ($fila = mysqli_fetch_assoc($consulta)) {
	        	
	        	$arrayLibros[]= Pelicula::buscaPeliID($fila['id_Pelicula']);
             }
	        $consulta->free();
    	}
        return $arrayLibros;
    }

    /* Contar las peliculas asociadas un reto o devuelve false si falla */
    static public function cuentasPelisPorReto($reto){

        $sql = "SELECT COUNT(*) as total FROM pelisreto WHERE id_Reto = $reto";
	
      
        $conn = Aplicacion::getInstance()->getConexionBd();

		$consulta = $conn->query($sql);
        $result=false;

       if($consulta->num_rows > 0){
	       if ($fila = mysqli_fetch_assoc($consulta)) {
	        	$result = $fila['total'];
	        	
	        }
	        $consulta->free();
    	}
        return $result;
    }

    /*Añadir pelis al reto */ 
    static public function anadirPeliAReto($pelis, $reto){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $pelii=$conn->real_escape_string($pelis);
        $retoo=$conn->real_escape_string($reto);
        $sql = "INSERT INTO pelisreto VALUES ('$pelii','$retoo')";
        
        if($conn->query($sql) === TRUE){
            $resultado=true;
           
        }else{
            $resultado=false;
        }

        return $resultado;
    }
     //completa un reto
     static public function completaPeliReto($id_user, $id_reto, $id_pelis){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $id_user=$conn->real_escape_string($id_user);
        $id_pelis=$conn->real_escape_string($id_pelis);
        $id_reto=$conn->real_escape_string($id_reto);
        $sql = "INSERT INTO peliscompletado VALUES ('$id_user','$id_reto','$id_pelis')";
        
        
        if($conn->query($sql) === TRUE){
            $check=true;
     
        }else{
            $check=false;
        }

        return $check;
    }
     //completa un reto
     static public function compruebaPelisComplet($id_user, $id_reto, $id_pelis){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $id_user=$conn->real_escape_string($id_user);
        $id_pelis=$conn->real_escape_string($id_pelis);
        $id_reto=$conn->real_escape_string($id_reto);
        $sql = "SELECT * FROM peliscompletado WHERE $id_user=id_usuario AND $id_reto=id_Reto AND $id_pelis=id_pelicula";
        
        
        
        $result=$conn->query($sql);
        if($result->num_rows > 0){

            $check=true;
     
        }else{
            $check=false;
        }

        return $check;
    }
     //completa un reto
     static public function contarPelisCompletadas($id_user, $id_reto){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $id_user=$conn->real_escape_string($id_user);
        $id_reto=$conn->real_escape_string($id_reto);
        $sql = "SELECT COUNT(*) as total FROM peliscompletado WHERE id_usuario=$id_user AND id_Reto=$id_reto ";
        $resul=$conn->query($sql);
        $total=false;
        if($resul->num_rows > 0){
            if ($fila = $resul->fetch_assoc()) {
                $total=$fila['total'];
            }
            $resul->free();
        }

        return $total;
    }
    //Comprobar si una pelis esta asociada a un reto
    static public function PelisEnReto($pelis, $reto){

        $sql = "SELECT * FROM pelisreto WHERE id_Pelicula = $pelis AND id_Reto = $reto";

      
        $conn = Aplicacion::getInstance()->getConexionBd();
        $consulta = $conn->query($sql);

        $resultado = false;
       if($consulta->num_rows > 0){
            $resultado=true;
            $consulta->free();
        }

        return $resultado;
    }

    static public function eliminarReto($pelis, $reto){

        $sql = "DELETE FROM pelisreto WHERE id_Pelicula=$pelis AND id_Reto=$reto";

        
        $conn =Aplicacion::getInstance()->getConexionBd();
        if($conn->query($sql) === TRUE){
            $resultado=true;
           
        }else{
            $resultado=false;
        }

        return $resultado;
    }
  

}


?>