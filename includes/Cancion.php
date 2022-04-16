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

    public static function buscaCancionId($id_bso)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM cancion E WHERE E.id_bso = '%d'"
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

    // public static function eliminarEpisodio($id_episodio){

    //     //borro de la bd
    //     $conn = Aplicacion::getInstance()->getConexionBd();
    //     $episodio = Episodio::buscaEpisodioId($id_episodio);
    //     $rutaV = $episodio->getRutaVideo();

    //     $query = sprintf("DELETE FROM episodios WHERE id_episodio = $id_episodio");
		
    //     $rs = $conn->query($query);
    //     $check =false;
	// 	if($rs){
	// 		$check =true;
    //         unlink($rutaV);
	// 	}
	// 	return $check;        
    // }


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

}