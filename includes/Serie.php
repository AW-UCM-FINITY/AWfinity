<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de las peliculas.
 */

class Serie
{
    private $id_serie;
    private $titulo;
    private $productor;
    private $numTemporadas;
    //private $duracion;//duracion media capitulos
    private $genero; //Enum de generos
    private $sinopsis;
    private $ruta_imagen;


    //Constructor
    private function __construct($titulo, $productor, $numTemporadas, $genero, $sinopsis, $ruta_imagen, $id_serie = NULL) {
        
        $this->titulo = $titulo;
        $this->productor = $productor;
        $this->numTemporadas = $numTemporadas;
        $this->genero = $genero;
        $this->sinopsis = $sinopsis;
        $this->ruta_imagen = $ruta_imagen;
        $this->id_serie = $id_serie;
    }

     /**Funciones get */
     public function getId() {
        return $this->id_serie;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getProductor(){
        return $this->productor;
    }

    public function getNumTemporadas(){
        return $this->numTemporadas;
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
        $this->id_serie= $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setProductor($productor){
        $this->productor = $productor;
    }

    public function setNumTemporadas($numTemporadas){
        $this->numTemporadas = $numTemporadas;
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


    public static function getGenerosSerie(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $rs = $conn->query("SHOW COLUMNS FROM series WHERE Field = 'genero'" );//cambio al tuntun
        $type = $rs->fetch_row();
        preg_match('/^enum\((.*)\)$/', $type[1], $matches); 

        foreach( explode(',', $matches[1]) as $value ) { 
            $enum[] = trim( $value, "'" ); 
        } 
        return $enum;
    }

    public static function crea($titulo, $productor, $numTemporadas, $genero, $sinopsis, $ruta_imagen){
        $ok = false;
        $serie = self::buscaSerie($titulo);//buscaSerie
        if ($serie) {
            return false;
        }
        $serie = new Serie($titulo, $productor, $numTemporadas, $genero, $sinopsis, $ruta_imagen);
        return self::inserta($serie);
    }

     private static function inserta($serie){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO series (titulo, productor, numTemporadas, genero, sinopsis, ruta_imagen) VALUES ('%s', '%s', '%d', '%s', '%s', '%s')"
            , $conn->real_escape_string($serie->titulo)
            , $conn->real_escape_string($serie->productor)
            , $conn->real_escape_string($serie->numTemporadas)
            , $conn->real_escape_string($serie->genero)
            , $conn->real_escape_string($serie->sinopsis)
            , $conn->real_escape_string($serie->ruta_imagen)
        );
    
        if ($conn->query($query)) {
            $serie->id_serie = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaSerieID($id_serie)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM series S WHERE S.id_serie='%d'", $conn->real_escape_string($id_serie));
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Serie($fila['titulo'], $fila['productor'], $fila['numTemporadas'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_serie']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaSerie($titulo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM series S WHERE S.titulo='%s'", $conn->real_escape_string($titulo));
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Serie($fila['titulo'], $fila['productor'], $fila['numTemporadas'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_serie']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function ordenarPor($genero){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM series S WHERE S.genero='%s'", $conn->real_escape_string($genero));
        $consulta = $conn->query($sql);

        $arraySeries = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arraySeries[] = new Serie($fila['titulo'], $fila['productor'], $fila['numTemporadas'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_serie']);
            }
            $consulta->free();
        }
        return $arraySeries;   
    }


    // public static function eliminarSerieTitulo($titulo){

    //     //borro de la bd
    //     print($titulo);
    //     $conn = Aplicacion::getInstance()->getConexionBd();	
    //     $query = sprintf("DELETE FROM series WHERE titulo = '%s'", $conn->real_escape_string($titulo));
	// 	print($titulo);
    //     $rs = $conn->query($query);
    //     $check =false;
	// 	if($rs){
	// 		$check =true;

	// 	}
	// 	return $check;        
    // }

    public static function eliminarSerie($id_serie){

        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();	
        $serie = Serie::buscaSerieID($id_serie);
        $ruta =$serie->getRutaImagen();

        $query = sprintf("DELETE FROM series WHERE id_serie = $id_serie");
		
        $rs = $conn->query($query);
        $check =false;
		if($rs){
			$check = Episodio::eliminarTodos($id_serie);
            unlink($ruta);  

		}
		return $check; 
    }


    public static function actualiza($serie){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $id_serie=$serie->getId();
        $query=sprintf("UPDATE series S SET S.titulo='%s', S.productor='%s', S.numTemporadas='%d', S.genero='%s', S.sinopsis='%s', S.ruta_imagen='%s' 
            WHERE S.id_serie = $id_serie"
            , $conn->real_escape_string($serie->getTitulo())
            , $conn->real_escape_string($serie->getProductor())
            , $conn->real_escape_string($serie->getNumTemporadas())
            , $conn->real_escape_string($serie->getGenero())
            , $conn->real_escape_string($serie->getSinopsis())
            , $conn->real_escape_string($serie->getRutaImagen())
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $serie;
    }
}

?>