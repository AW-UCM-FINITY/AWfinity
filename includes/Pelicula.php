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
    private function __construct($titulo, $director, $duracion, $genero, $sinopsis, $ruta_imagen, $id_pelicula = NULL) {
        
        $this->titulo = $titulo;
        $this->director = $director;
        $this->duracion = $duracion;
        $this->genero = $genero;
        $this->sinopsis = $sinopsis;
        $this->ruta_imagen = $ruta_imagen;
        $this->id_pelicula = $id_pelicula;
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

    /**Funciones set */
    public function setId($id) {
        $this->id_pelicula= $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDirector($director){
        $this->director = $director;
    }

    public function setDuracion($duracion){
        $this->duracion = $duracion;
    }
    
    public function setGenero($genero) {
        $this->genero = $genero;
    }
    
    public function setSinopsis($sinopsis) {
        $this->sinopsis = $sinopsis;
    }

    public function setRutaImagen($ruta_imagen) {
        $this->ruta_imagen = $ruta_imagen;
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

    /** Crea un nueva peli con los datos introducidos por parámetro*/
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
        $query = sprintf("INSERT INTO peliculas (titulo, director, duracion, genero, sinopsis, ruta_imagen) VALUES ('%s', '%s', '%d', '%s', '%s', '%s')"
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
        $query = sprintf("SELECT * FROM peliculas P WHERE P.id_pelicula='%d'", $conn->real_escape_string($id_pelicula));
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_pelicula']);
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
                $result = new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_pelicula']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    // devuelve una lista de peliculas que coincida con %titulo% -> es un buscador de peliculas.
    static public function buscar($busqueda){ 

        $sql = "SELECT * FROM peliculas P  WHERE P.titulo LIKE \"%$busqueda%\" ";
        
       
        $conn =  Aplicacion::getInstance()->getConexionBd();
        $consulta = $conn->query($sql);
        $arrayPelis=array();
 
        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayPelis[]= new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_pelicula']);
                
            }
            $consulta->free();
        }
 
        return $arrayPelis;
    }

    //$genero cambiar a $opcion
    public static function ordenarPor($genero){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM peliculas P WHERE P.genero='%s'", $conn->real_escape_string($genero));
        $consulta = $conn->query($sql);

        $arrayPeliculas = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayPeliculas[] = new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_pelicula']);
            }
            $consulta->free();
        }
        return $arrayPeliculas;   
    }

    public static function eliminarPelicula($id_pelicula){

        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();	
        $peli = Pelicula::buscapeliID($id_pelicula);
        $ruta =$peli->getRutaImagen();

        $query = sprintf("DELETE FROM peliculas WHERE id_pelicula = $id_pelicula");
		
        $rs = $conn->query($query);
        $check =false;
		if($rs){
			$check =true;
            //borro la imagen fisica de la carpeta 
            unlink($ruta);  
            
		}
		return $check;        
    }


    /** Actualiza la peliicula existente en BD guarda() -> actualiza() */
    public static function actualiza($peli){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        // $id_pelicula=$peli->getId();
        $query=sprintf("UPDATE peliculas P SET P.titulo='%s', P.director='%s', P.duracion='%d', P.genero='%s', P.sinopsis='%s', P.ruta_imagen='%s' 
            WHERE P.id_pelicula = '%d'"
            , $conn->real_escape_string($peli->getTitulo())
            , $conn->real_escape_string($peli->getDirector())
            , $conn->real_escape_string($peli->getDuracion())
            , $conn->real_escape_string($peli->getGenero())
            , $conn->real_escape_string($peli->getSinopsis())
            , $conn->real_escape_string($peli->getRutaImagen())
            , $conn->real_escape_string($peli->getId())
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $peli;
    }

    public static function getPeliculas(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM peliculas");
        $consulta = $conn->query($sql);

        $arrayPeliculas = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayPeliculas[] = new Pelicula($fila['titulo'], $fila['director'], $fila['duracion'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_pelicula']);
            }
            $consulta->free();
        }
        return $arrayPeliculas; 

    }
}

?>