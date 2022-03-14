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


    //Constructor
    private function __construct($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen) {
        //$this->id_usuario= $id;
        $this->titulo = $titulo;
        $this->director = $director;
        $this->duracion = $duracion;
        $this->genero = $genero;
        $this->sinopsis = $sinopsis;
        $this->ruta_imagen = $ruta_imagen;
    }

     /**Funciones get */
     public function getId() {
        return $this->id_pelicula;
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

    public function getRutaImagen() {
        return $this->ruta_imagen;
    }


    //Obtener lista de generos de las películas de la BD
    public static function getGenerosPeli(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $rs = $conn->query("SHOW COLUMNS FROM peliculas WHERE Field = 'genero'" );
        $type = $rs->fetch_row();
        preg_match('/^enum\((.*)\)$/', $type[1], $matches); 

        foreach( explode(',', $matches[1]) as $value ) { 
            $enum[] = trim( $value, "'" ); 
        } 
        return $enum;
    }

    /** Crea un nuevo usuario con los datos introducidos por parámetro*/
    public static function crea($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen){
        $ok = false;
        $peli = self::buscaPelicula($titulo);
        if ($peli) {
            return false;
        }
        $peli = new Pelicula($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen);
        return self::inserta($peli);
    }

     /** Inserta nuevo usuario en BD guarda() -> inserta() */
     private static function inserta($peli){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO peliculas (titulo, director, duracion, genero, sinopsis, ruta_imagen) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')"
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

    public static function buscaPeliID($id_pelicula)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.id_pelicula='%s'", $conn->real_escape_string($id_pelicula));
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


    public static function getPeliculas(){
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM peliculas";
        $consulta = $conn->query($sql);

        $arrayPeliculas = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayPeliculas[$fila['id_pelicula']] = $fila['titulo'];
            }
            $consulta->free();
        }
        return $arrayPeliculas;
    }
    //$genero cambiar a $opcion
    public static function ordenarPor($genero){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM peliculas P WHERE P.genero='%s'", $conn->real_escape_string($genero));
        $consulta = $conn->query($sql);

        $arrayPeliculas = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayPeliculas[] = new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen']);
            }
            $consulta->free();
        }
        return $arrayPeliculas;   
    }


    

    public static function eliminarPelicula($id_pelicula){

        $conn = Aplicacion::getInstance()->getConexionBd();	
        
        $query = sprintf("DELETE FROM peliculas WHERE id_pelicula = $id_pelicula");
		$rs = $conn->query($query);
        $check =false;

		if($rs){
			$check =true;
		}
        
		return $check;        
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