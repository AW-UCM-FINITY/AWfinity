<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de las peliculas.
 */

class Pelicula
{
    private $id_pelicula;
    private $titulo;
    private $director;
    private $duracion;
    private $genero; //Enum de generos
    private $sinopsis;
    private $ruta_imagen;

    public const ACCION = "accion";
    public const ACCION = "anime";
    public const DRAMA = "drama";
    public const FICCION = "ficcion";
    public const TERROR = "terro";


    private const GENEROS = array(self::ACCION,self::ANIME, self::DRAMA, self::FICCION, self::TERROR); 

    //Constructor
    private function __construct($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen) {
        //$this->id_usuario= $id;
        $this->titulo = $titulo;
        $this->director = $director;
        $this->duracion = $duracion;
        $this->genero = $genero;
        $this->sinopsis = $sinopsis;
    }

     /**Funciones get */
     public function getId() {
        return $this->id_titulo;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDirector(){
        return $this->director;
    }

    public function getDuracion(){
        return $this->duracion;
    }
    
    public function getGenero() {
        return $this->genero;
    }
    
    public function getSinopsis() {
        return $this->sinopsis;
    }

    public function get_generoPeli(){
        $arrayRoles = array();
        foreach(self::GENEROS as $i => $genero){
            $arrayRoles[] = $genero;
        }
        return $arrayRoles;
    }

    /** Crea un nuevo usuario con los datos introducidos por parámetro*/
    public static function crea($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen){
        $ok = false;
        $peli = self::buscaPelicula($titulo);
        if ($peli) {
            return false;
        }
        $peli = new Pelicula($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen);
        
        return self::insertar($peli);
    }

     /** Inserta nuevo usuario en BD guarda() -> inserta() */
     private static function inserta($peli){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO peliculas (titulo, director, duracion, genero, sinopsis, ruta_imagen) VALUES ('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($peli->titulo)
            , $conn->real_escape_string($peli->director)
            , $conn->real_escape_string($peli->duracion)
            , $conn->real_escape_string($peli->genero)
            , $conn->real_escape_string($peli->sinopsis)
            , $conn->real_escape_string($peli->ruta_imagen)
        );
        if ($conn->query($query)) {
            $peli->id_pelicula = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPelicula($titulo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.titulo='%s'", $conn->real_escape_string($titulo));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //buscar por id¿?

   /* public static function guarda($peli){
        if ($peli->id_pelicula!== null) {
            return self::actualiza($peli);
        }
        return self::inserta($peli);
    }*/

    /** Actualiza la peliicula existente en BD guarda() -> actualiza() */
   /* private static function actualiza($peli){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE peliculas P SET P.titulo = '%s', P.director='%s', P.duracion='%s', P.genero='%s', P.sinopsis='%s', P.ruta_imagen='%s'' 
            WHERE P.id_pelicula = %d"
            , $conn->real_escape_string($peli->titulo)
            , $conn->real_escape_string($peli->director)
            , $conn->real_escape_string($peli->duracion)
            , $conn->real_escape_string($peli->genero)
            , $conn->real_escape_string($peli->sinopsis)
            , $conn->real_escape_string($peli->ruta_imagen)
            , $peli->id_pelicula
        );
        if ( $conn->query($query) ) {
          
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $peli;
    }*/
}

?>