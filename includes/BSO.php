<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de las BSO.
 */

class BSO
{
    private $id_bso;
    private $titulo;
    private $compositor;
    private $numCanciones;
    private $genero; //Enum de generos
    private $sinopsis;
    private $ruta_imagen;


    //Constructor
    private function __construct($titulo, $compositor, $numCanciones, $genero, $sinopsis, $ruta_imagen, $id_bso = NULL) {
        
        $this->titulo = $titulo;
        $this->compositor = $compositor;
        $this->numCanciones = $numCanciones;
        $this->genero = $genero;
        $this->sinopsis = $sinopsis;
        $this->ruta_imagen = $ruta_imagen;
        $this->id_bso = $id_bso;
    }

     /**Funciones get */
     public function getId() {
        return $this->id_bso;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getCompositor(){
        return $this->compositor;
    }

    public function getNumCanciones(){
        return $this->numCanciones;
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
        $this->id_bso= $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setCompositor($compositor){
        $this->compositor = $compositor;
    }

    public function setNumCanciones($numCanciones){
        $this->numCanciones = $numCanciones;
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


    public static function getGenerosBSO(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $rs = $conn->query("SHOW COLUMNS FROM bso WHERE Field = 'genero'" );//cambio al tuntun
        $type = $rs->fetch_row();
        preg_match('/^enum\((.*)\)$/', $type[1], $matches); 

        foreach( explode(',', $matches[1]) as $value ) { 
            $enum[] = trim( $value, "'" ); 
        } 
        return $enum;
    }

    public static function crea($titulo, $compositor, $numCanciones, $genero, $sinopsis, $ruta_imagen){
        $ok = false;
        $BSO = self::buscaBSO($titulo);//buscaBSO
        if ($BSO) {
            return false;
        }
        $BSO = new BSO($titulo, $compositor, $numCanciones, $genero, $sinopsis, $ruta_imagen);
        return self::inserta($BSO);
    }

    private static function inserta($BSO){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO bso (titulo, compositor, numCanciones, genero, sinopsis, ruta_imagen) VALUES ('%s', '%s', '%d', '%s', '%s', '%s')"
            , $conn->real_escape_string($BSO->titulo)
            , $conn->real_escape_string($BSO->compositor)
            , $conn->real_escape_string($BSO->numCanciones)
            , $conn->real_escape_string($BSO->genero)
            , $conn->real_escape_string($BSO->sinopsis)
            , $conn->real_escape_string($BSO->ruta_imagen)
        );
    
        if ($conn->query($query)) {
            $BSO->id_bso = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaBSOID($id_bso)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM bso B WHERE B.id_bso='%d'", $conn->real_escape_string($id_bso));
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new BSO($fila['titulo'], $fila['compositor'], $fila['numCanciones'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_bso']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaBSO($titulo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM bso B WHERE B.titulo='%s'", $conn->real_escape_string($titulo));
        $rs = $conn->query($query);
        $result = false;
      
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new BSO($fila['titulo'], $fila['compositor'], $fila['numCanciones'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_bso']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function ordenarPor($genero){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM bso B WHERE B.genero='%s'", $conn->real_escape_string($genero));
        $consulta = $conn->query($sql);

        $arrayBSOs = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayBSOs[] = new BSO($fila['titulo'], $fila['compositor'], $fila['numCanciones'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_bso']);
            }
            $consulta->free();
        }
        return $arrayBSOs;   
    }


    public static function eliminarBSO($id_bso){

        //borro de la bd
        $conn = Aplicacion::getInstance()->getConexionBd();	
        $BSO = BSO::buscaBSOID($id_bso);
        $ruta =$BSO->getRutaImagen();

        $query = sprintf("DELETE FROM bso WHERE id_bso = $id_bso");
		
        $rs = $conn->query($query);
        $check =false;
		if($rs){
			$check = Cancion::eliminarTodos($id_bso);
            unlink($ruta);  

		}
		return $check; 
    }


    public static function actualiza($BSO){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        // $id_bso=$BSO->getId();
        $query=sprintf("UPDATE bso S SET S.titulo='%s', S.compositor='%s', S.numCanciones='%d', S.genero='%s', S.sinopsis='%s', S.ruta_imagen='%s' 
            WHERE S.id_bso = '%d'"
            , $conn->real_escape_string($BSO->getTitulo())
            , $conn->real_escape_string($BSO->getCompositor())
            , $conn->real_escape_string($BSO->getnumCanciones())
            , $conn->real_escape_string($BSO->getGenero())
            , $conn->real_escape_string($BSO->getSinopsis())
            , $conn->real_escape_string($BSO->getRutaImagen())
            , $conn->real_escape_string($BSO->getId())
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $BSO;
    }

    public static function disminuyeNumCanciones($id_bso){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $BSO = BSO::buscaBSOID($id_bso);
        $numCanciones = $BSO->getNumCanciones();
        $total = $numCanciones - 1;
        $query=sprintf("UPDATE bso S SET S.numCanciones='%d' WHERE S.id_bso = $id_bso"
            , $conn->real_escape_string($total)
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function actualizaNumCanciones($id_bso){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $BSO = BSO::buscaBSOID($id_bso);
        $numCanciones = $BSO->getNumCanciones();
        $total = 1 + $numCanciones;
        $query=sprintf("UPDATE bso S SET S.numCanciones='%d' WHERE S.id_bso = $id_bso"
            , $conn->real_escape_string($total)
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    public static function getBSO(){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM bso");
        $consulta = $conn->query($sql);

        $arrayBSOs = array();

        if($consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $arrayBSOs[] = new BSO($fila['titulo'], $fila['compositor'], $fila['numCanciones'], $fila['genero'], $fila['sinopsis'], $fila['ruta_imagen'], $fila['id_bso']);
            }
            $consulta->free();
        }
        return $arrayBSOs; 

    }
}

?>