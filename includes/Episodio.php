<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de las peliculas.
 */

class Episodio
{
    private $id_episodio;
    private $titulo;
    private $id_serie;
    private $duracion;
    private $temporada;
    private $ruta_video;
    private $sinopsis;

    //Constructor
    private function __construct($id_serie, $titulo, $duracion, $temporada,  $ruta_video, $sinopsis, $id_episodio = NULL) {
    
        $this->id_serie = $id_serie;
        $this->titulo = $titulo;
        $this->duracion = $duracion;
        $this->temporada = $temporada;
        $this->ruta_video = $ruta_video;
        $this->sinopsis = $sinopsis;
        $this->id_episodio = $id_episodio;
    }
    //Getter
    public function getId() {
        return $this->id_episodio;
    }

    public function getDuracion(){
        return $this->duracion;
    }
   
    public function getRutaVideo() {
        return $this->ruta_video;
    }

    public function getSinopsis() {
        return $this->sinopsis;
    }

    public function getTemporada(){
        return $this->temporada;
    }

    public function getId_serie() {
        return $this->id_serie;
    }
    public function getTitulo() {
        return $this->titulo;
    }


    //Setter
    public function setId($id_episodio) {
        $this->id_episodio = $id_episodio;
    }

    public function setDuracion($duracion){
        $this->duracion=$duracion;
    }
    
    public function setSinopsis($sinopsis) {
        $this->sinopsis=$sinopsis;
    }

    public function setId_serie($id_serie) {
        $this->id_serie=$id_serie;
    }
    public function setTitulo($titulo) {
        $this->titulo=$titulo;
    }
    public function setTemporada($temporada){
        $this->temporada=$temporada;
    }
    public function setRutaVideo($ruta_video){
        $this->ruta_video=$ruta_video;
    }
    
    /** Crea un nuevo episodio con los datos introducidos por parámetro*/
    public static function crea($id_serie, $titulo, $duracion, $temporada, $sinopsis, $ruta_video){
        $ok = false;
        $episodio = self::buscaEpisodio($titulo, $id_serie);
        if ($episodio) {
            return false;
        }
        $episodio = new Episodio($id_serie, $titulo, $duracion, $temporada, $ruta_video, $sinopsis);
        return self::inserta($episodio);
    }

    /** Inserta nuevo episodio en BD guarda() -> inserta() */
    private static function inserta($episodio){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO episodios (id_serie, titulo, duracion, temporada,  ruta_video, sinopsis) VALUES ('%d', '%s', '%d', '%d', '%s', '%s')"
            , $conn->real_escape_string($episodio->id_serie)
            , $conn->real_escape_string($episodio->titulo)
            , $conn->real_escape_string($episodio->duracion)
            , $conn->real_escape_string($episodio->temporada)
            , $conn->real_escape_string($episodio->ruta_video)
            , $conn->real_escape_string($episodio->sinopsis)


        );
    
        if ($conn->query($query)) {
            $episodio->id_episodio = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function actualiza($episodio){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $id_episodio=$episodio->getId();
        $query=sprintf("UPDATE episodios E SET E.id_serie='%d' ,E.titulo='%s', E.duracion='%d', E.temporada='%s', E.sinopsis='%s', E.ruta_video='%s' 
            WHERE E.id_episodio = $id_episodio"
            , $conn->real_escape_string($episodio->getId_serie())
            , $conn->real_escape_string($episodio->getTitulo())
            , $conn->real_escape_string($episodio->getDuracion())
            , $conn->real_escape_string($episodio->getTemporada())
            , $conn->real_escape_string($episodio->getSinopsis())
            , $conn->real_escape_string($episodio->getRutaVideo())
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $episodio;
    }

    public static function buscaEpisodio($titulo, $id_serie)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM episodios E WHERE E.titulo='%s' AND E.id_serie = '%d'"
        , $conn->real_escape_string($titulo)
        , $conn->real_escape_string($id_serie)
        );
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Episodio($fila['id_serie'], $fila['titulo'], $fila['duracion'], $fila['temporada'], $fila['ruta_video'], $fila['sinopsis'], $fila['id_episodio']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaEpisodioId($id_episodio)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM episodios E WHERE E.id_episodio = '%d'"
        , $conn->real_escape_string($id_episodio)
        );

        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Episodio($fila['id_serie'], $fila['titulo'], $fila['duracion'], $fila['temporada'],  $fila['ruta_video'], $fila['sinopsis'], $fila['id_episodio']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function listaEpisodios($id_serie, $temporada){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM episodios E WHERE E.id_serie='%s'AND E.temporada ='%d'"
        , $conn->real_escape_string($id_serie)
        , $conn->real_escape_string($temporada)
        );
        $consulta = $conn->query($sql);

        $arrayEpisodios = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayEpisodios[] = new Episodio($fila['id_serie'], $fila['titulo'], $fila['duracion'], $fila['temporada'],  $fila['ruta_video'], $fila['sinopsis'], $fila['id_episodio']);
            }
            $consulta->free();
        }
        return $arrayEpisodios;   
    }

    public static function eliminarEpisodio($id_episodio){

        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();
        $episodio = Episodio::buscaEpisodioId($id_episodio);
        $rutaV = $episodio->getRutaVideo();

        $query = sprintf("DELETE FROM episodios WHERE id_episodio = $id_episodio");
		
        $rs = $conn->query($query);
        $check =false;
		if($rs){
			$check =true;
            unlink($rutaV);
		}
		return $check;        
    }


    public static function eliminarTodos($id_serie){
        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();	

        $query = sprintf("DELETE FROM episodios WHERE id_serie = $id_serie");
		
        $rs = $conn->query($query);
        $check =false;
		if($rs){
			$check =true; 
		}
		return $check;        
    }

}