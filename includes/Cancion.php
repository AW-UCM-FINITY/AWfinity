<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de las peliculas.
 */

class Cancion
{
    private $id_cancion;
    private $id_bso;
    private $nombre_cancion;
    private $ruta_audio;

    //Constructor
    private function __construct($id_bso, $nombre_cancion, $ruta_audio, $id_cancion = NULL) {
    
        $this->id_cancion = $id_cancion;
        $this->id_bso = $id_bso;
        $this->nombre_cancion = $nombre_cancion;
        $this->ruta_audio = $ruta_audio;
    }
    //Getter
    public function getId() {
        return $this->id_cancion;
    }

    public function getIdBSO(){
        return $this->id_bso;
    }
   
    public function getNombreCancion() {
        return $this->nombre_cancion;
    }

    public function getRutaAudio(){
       return $this->ruta_audio;
    }
    
    //Setter
    public function setId($id_cancion) {
        $this->id_cancion = $id_cancion;
    }

    public function setIdBSO($id_bso){
        $this->id_bso = $id_bso;
    }
   
    public function setNombreCancion($nombre_cancion) {
        $this->nombre_cancion = $nombre_cancion;
    }

    public function setRutaAudio($ruta_audio){
        $this->ruta_audio = $ruta_audio;
    }

    

    
    /** Crea un nuevo cancion con los datos introducidos por parámetro*/
    public static function crea($id_bso, $nombre_cancion, $ruta_audio){
        $ok = false;
        $cancion = self::buscaCancion($nombre_cancion, $id_bso);
        if ($cancion) {
            return false;
        }
        $cancion = new Cancion($id_bso, $nombre_cancion, $ruta_audio);
        return self::inserta($cancion);
    }

    /** Inserta nuevo cancion en BD guarda() -> inserta() */
    private static function inserta($cancion){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO canciones (id_bso, nombre_cancion, ruta_audio) VALUES ('%d', '%s', '%s')"
            , $conn->real_escape_string($cancion->id_bso)
            , $conn->real_escape_string($cancion->nombre_cancion)
            , $conn->real_escape_string($cancion->ruta_audio)
        );
    
        if ($conn->query($query)) {
            $cancion->id_cancion = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaCancion($nombre_cancion, $id_bso)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones E WHERE E.nombre_cancion='%s' AND E.id_bso = '%d'"
        , $conn->real_escape_string($nombre_cancion)
        , $conn->real_escape_string($id_bso)
        );
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Cancion($fila['id_bso'], $fila['nombre_cancion'], $fila['ruta_audio'], $fila['id_cancion']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaCancionId($id_cancion)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM canciones E WHERE E.id_cancion = '%d'"
        , $conn->real_escape_string($id_cancion)
        );

        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Cancion($fila['id_bso'], $fila['nombre_cancion'], $fila['ruta_audio'], $fila['id_cancion']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getCanciones($id_bso){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM canciones E WHERE E.id_bso='%d'"
        , $conn->real_escape_string($id_bso)
        );
        $consulta = $conn->query($sql);

        $arrayCanciones = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayCanciones[] = new Cancion($fila['id_bso'], $fila['nombre_cancion'], $fila['ruta_audio'], $fila['id_cancion']);
            }
            $consulta->free();
        }
        return $arrayCanciones;   
    }

     public static function eliminarCancion($id_cancion){

        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();
        $cancion = Cancion::buscaCancionId($id_cancion);
        $ruta_audio = $cancion->getRutaAudio();

        $query = sprintf("DELETE FROM canciones WHERE id_cancion = $id_cancion");
		
        $rs = $conn->query($query);
        $check = false;
        if($rs){
            $check = true;
            unlink($ruta_audio); //No lo ponemos porque solo metemos un audio
        }
        return $check;             
    }


    public static function eliminarTodos($id_bso){
        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();	

        $query = sprintf("DELETE FROM canciones WHERE id_bso = $id_bso");
		
        $rs = $conn->query($query);
        $check =false;
		if($rs){
			$check =true; 
		}
		return $check;        
    }
//id_bso, nombre_cancion, ruta_audio
    public static function actualiza($cancion){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $id_cancion=$cancion->getId();
        $query=sprintf("UPDATE canciones C SET C.id_bso='%d' ,C.nombre_cancion='%s', C.ruta_audio='%s' 
            WHERE C.id_cancion = $id_cancion"
            , $conn->real_escape_string($cancion->getIdBSO())
            , $conn->real_escape_string($cancion->getNombreCancion())
            , $conn->real_escape_string($cancion->getRutaAudio())
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $cancion;
    }

}