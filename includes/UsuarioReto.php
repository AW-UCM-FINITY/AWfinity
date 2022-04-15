<?php 
namespace es\ucm\fdi\aw;


class UsuarioReto{

    public function __construct(){

    }

    /* Busca los usuarios de un reto dado y te devuelve un array de usuarios */
    static public function getUsuariosPorReto($reto){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM usuarioreto WHERE id_Reto = $reto";
        
		$consulta = $conn->query($sql);
        $arrayUsuarios = array();


        
       if($consulta->num_rows > 0){
	        while ($fila = mysqli_fetch_assoc($consulta)) {	
	        	$arrayUsuarios[]= Usuarios::buscaPorId($fila['id_usuario']);
	        }
	        $consulta->free();
    	}
        return $arrayUsuarios;
    }

    /* Cuenta los users de un retooo */
    static public function cuentaUsuariosPorReto($reto){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT COUNT(*) as total FROM usuarioreto WHERE id_Reto = $reto";

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
    static public function retosCompletadosPorUser($id_user){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT COUNT(*) total FROM usuarioreto U WHERE U.id_usuario ='%s' AND U.completado='%s'",$conn->real_escape_string($id_user),1);

		$consulta = $conn->query($sql);
        $result=0;
        
        if($consulta){
        if($consulta->num_rows > 0){
	       if ($fila = mysqli_fetch_assoc($consulta)) {
	        	$result = $fila['total'];
	        	
	        }
	        $consulta->free();
    	}
    }
        return $result;
}
    /* Busca y devuelve un array de los retos en los que está unido un usuario */
    static public function misRetos($id){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM usuarioreto WHERE id_usuario = $id";

		$consulta = $conn->query($sql);
        $arrayRetos = array();

       if($consulta->num_rows > 0){
	        while ($fila = mysqli_fetch_assoc($consulta)) {
	        	
	        	$arrayRetos[]= Reto::buscarPorId($fila['id_Reto']);
             }
	        $consulta->free();
    	}

        return $arrayRetos;
    }
///
    static public function tiempoDeVidaReto($id, $reto){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM usuarioreto WHERE id_usuario = $id AND id_Reto = $reto";
	
		$consulta = $conn->query($sql);
        $result = false;

       if($consulta->num_rows > 0){
	        if($fila = mysqli_fetch_assoc($consulta)) {
	        	
	        	$reto= Reto::buscarPorId($fila['id_Reto']);
                $fechaActual = date("Y/m/d");
                $fechaUnirme = $fila['fecha'];
                $dias = $reto->getDias();
                $resta= self::diasFechas($fechaUnirme,$fechaActual);
                $diasRestantes = $dias - $resta;
                if ($diasRestantes>0){
                    $result =$diasRestantes;
                }
	        }
	        $consulta->free();
    	}

        return $result;
    }

    /*Crea una fila usuario reto */ 
    static public function joinReto($id, $reto){

        $date = date("Y/m/d");
    $idd=$conn->real_escape_string($id);
    $retoo=$conn->real_escape_string($reto);
        $sql = "INSERT INTO usuarioreto VALUES ('$idd','$retoo','$date','0')";

        
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($conn->query($sql) === TRUE){
            $check=true;
            Reto::incrementaNumMiembros($reto);//Actualiza num_miembros de la tabla retos
        }else{
            $check=false;
        }

        return $check;
    }
    
    
    static public function compruebaPerteneceReto($id, $reto){

        $sql = "SELECT * FROM usuarioreto WHERE id_usuario = $id AND id_Reto = $reto";

       
        $conn =  Aplicacion::getInstance()->getConexionBd();
        $consulta = $conn->query($sql);

        $check = false;
       if($consulta->num_rows > 0){
            $check=true;
            $consulta->free();
        }

        return $check;
    }

    static public function salirReto($id, $reto){

        $sql = "DELETE FROM usuarioreto WHERE id_usuario=$id AND id_Reto=$reto->getIdReto()";

       
        $conn =  Aplicacion::getInstance()->getConexionBd();
        if($conn->query($sql) === TRUE){
            $check=true;
            Reto::decrementaNumMiembros($reto->getIdReto());//Actualiza num_miembros de la tabla grupo
        }else{
            $check=false;
        }

        return $check;
    }
    private static function diasFechas($fechaIcicio,$fechaActual){
       
        $yearA = substr($fechaActual,0,4);
        $monthA = substr($fechaActual,5,2);
        $dayA = substr($fechaActual,8,2);
        
        $yearI = substr($fechaIcicio,0,4);
        $monthI = substr($fechaIcicio,5,2);
        $dayI = substr($fechaIcicio,8,2);

        $resultado= 0;
        $year=$yearA-$yearI;
        $mes=abs($monthA-$monthI);
        $dias=abs($dayA-$dayI);
        if($year>0){
           
           $resultado = $mes * 30 + $dias + ($year-1) *365;
        }else{
            if($mes>0){
                $resultado = $dias + ($mes -1) * 30;
            }else{
                $resultado = $dias;
            }

        }

        return $resultado;

    }
    //completa un reto
    static public function completaReto($id, $reto){

        $sql="UPDATE usuarioreto SET completado = '1' WHERE id_usuario = $id AND id_Reto=$reto->id_Reto";
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($conn->query($sql) === TRUE){
            $check=true;

        }else{
            $check=false;
        }

        return $check;
    }
    //comprueba si ya lo completaste
    static public function compruebaCompletado($reto, $id){
        $check=false;
        $sql="SELECT * FROM usuarioreto WHERE id_usuario = $id AND id_Reto = $reto";
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $consulta =$conn->query($sql);
        if($consulta->num_rows > 0){
            if($fila = mysqli_fetch_assoc($consulta)) {

                if($fila['completado']==1){
                    $check=true;
                }
                else{
                    $check=false;
                }

            }
            $consulta->free();
        }
        return $check;
    }
}


?>