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
	        	
	        	$arrayLibros[]= Pelicula::buscaPeliID($fila['id_pelicula']);
             }
	        $consulta->free();
    	}
        return $arrayLibros;
    }

    /* Contar las peliculas asociadas un reto o devuelve false si falla */
    static public function cuentasPelisPorReto($reto){

        $sql = "SELECT COUNT(*) FROM pelisreto WHERE id_Reto = $reto";
	
      
        $conn = Aplicacion::getInstance()->getConexionBd();

		$consulta = $conn->query($sql);
        $result=false;

       if($consulta->num_rows > 0){
	       if ($fila = mysqli_fetch_assoc($consulta)) {
	        	$result = $fila['COUNT'];
	        	
	        }
	        $consulta->free();
    	}
        return $result;
    }

    /*Añadir pelis al reto */ 
    static public function anadirPeliAReto($pelis, $reto){

        $pelii=$pelii=$conn->real_escape_string($pelis);
        $retoo=$pelii=$conn->real_escape_string($reto);
        $sql = "INSERT INTO pelisreto VALUES ('$pelii','$retoo')";
        
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($conn->query($sql) === TRUE){
            $resultado=true;
           
        }else{
            $resultado=false;
        }

        return $resultado;
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