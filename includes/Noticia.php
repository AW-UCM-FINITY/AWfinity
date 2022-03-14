<?php
namespace es\ucm\fdi\aw;

class Noticia{

    private $idNoticia;
    private $titulo;
    private $subtitulo;
    private $imagenNombre;
    private $contenido; //Enum de generos
    private $fechaPublicacion;
    private $autor;
    private $categoria;//(noticia, noticia-evento,noticia-estreno)
    private $etiquetas; //de momento no se pone
   


 //Constructor
 private function __construct( $titulo, $subtitulo, $imagenNombre, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas) {

    $this->titutlo=$titulo;
    $this->subtitulo=$subtitulo;
    $this->imagenNombre=$imagenNombre;
    $this->contenido=$contenido;
    $this->fechaPublicacion=$fechaPublicacion;
    $this->autor=$autor;
    $this->categoria=$categoria;
    $this->etiquetas=$etiquetas;
  
}
public function getIdNoticia(){
    return $this->idNoticia;
}



public function getTitulo(){
    return $this->titulo;
}



public function getSubtitulo(){
    return $this->subtitulo;
}



public function getImagenNombre(){
    return $this->imagenNombre;
}


public function getContenido(){
    return $this->contenido;
}



public function getFechaPublicacion(){
    return $this->fechaPublicacion;
}



public function getAutor(){
    return $this->autor;
}



public function getCategoria(){
    return $this->categoria;
}



public function getEtiquetas(){
    return $this->etiquetas;
}




//Obtener lista de generos de las películas de la BD
public static function getCategoriaNoticia(){
    $conn = Aplicacion::getInstance()->getConexionBd();
    $rs = $conn->query("SHOW COLUMNS FROM noticias WHERE Field = 'categoria'" );
    $type = $rs->fetch_row();
    preg_match('/^enum\((.*)\)$/', $type[1], $matches); 

    foreach( explode(',', $matches[1]) as $value ) { 
        $enum[] = trim( $value, "'" ); 
    } 
    return $enum;
}




public static function crea($titulo, $subtitulo, $imagenNombre, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas ){
  
    $noticia = self::buscaNoticia($titulo);
    if ($noticia) {
        return false;
    }
    $noticia = new \Noticia( $titulo, $subtitulo, $imagenNombre,$contenido, $fechaPublicacion, $autor,$categoria,$etiquetas);

    return self::inserta($noticia);
}

 
 private static function inserta($noticia){
    $result = false;
    $conn = Aplicacion::getInstance()->getConexionBd();
    $query = sprintf("INSERT INTO noticias (titulo, subtitulo, imagenNombre, contenido, fechaPublicacion, autor,categoria,etiquetas) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
  
        , $conn->real_escape_string($noticia->titulo)
        , $conn->real_escape_string($noticia->subtitulo)
        , $conn->real_escape_string($noticia->imagenNombre)
        , $conn->real_escape_string($noticia->contenido)
        , $conn->real_escape_string($noticia->fechaPublicacion)
        , $conn->real_escape_string($noticia->autor)
        , $conn->real_escape_string($noticia->categoria)
        , $conn->real_escape_string($noticia->etiquetas)
       
    );

    if ($conn->query($query)) {
        $noticia->idNoticia = $conn->insert_id;//obtiene el id de la bd automaticamente
        $result = true;
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}

public static function buscaNoticiaID($idNoticia)
{
    $conn = Aplicacion::getInstance()->getConexionBd();
    $query = sprintf("SELECT * FROM noticias WHERE noticias.idNoticia='%s'", $conn->real_escape_string($idNoticia));
    $rs = $conn->query($query);
    $result = false;
  
    if ($rs) {
        $fila = $rs->fetch_assoc();
        if ($fila) {
            $result = new \Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas']);
        }
        $rs->free();
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}

public static function buscaNoticia($titulo)
{
    $conn = Aplicacion::getInstance()->getConexionBd();
    $query = sprintf("SELECT * FROM noticias WHERE noticias.titulo='%s'", $conn->real_escape_string($titulo));
    $rs = $conn->query($query);
    $result = false;
  
    if ($rs) {
        $fila = $rs->fetch_assoc();
        if ($fila) {
            $result = new \Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas']);
        }
        $rs->free();
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}


public static function getNoticias(){
    
    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql = "SELECT * FROM noticias";
    $consulta = $conn->query($sql);

    $arrayNoticias = array();

    if($consulta->num_rows > 0){
        while ($fila = mysqli_fetch_assoc($consulta)) {
            $arrayNoticias[]=$fila;
        }
        $consulta->free();
    }
    return $arrayNoticias;
}

public static function ordenarPorFecha($orden){ //1 orden mayor a menor, 2 orden contrario
  


    $arrayPeliculas = self::getNoticias();
    if($orden==1){
    
        $resul=usort($arrayPeliculas,array('es\ucm\fdi\aw\Noticia', 'date_compare1'));
    }else{
        $resul=usort($arrayPeliculas,array('es\ucm\fdi\aw\Noticia','date_compare2'));
    }
   if ($resul==false){
    error_log("Error de ordenacion de noticias");
   }
    return $arrayPeliculas;   
}
//geeksforgeeks.com
public static function date_compare1($element1, $element2) {
    $datetime1 = strtotime($element1['fechaPublicacion']);
    $datetime2 = strtotime($element2['fechaPublicacion']);
    return $datetime1 - $datetime2;
} 
public static  function  date_compare2($element1, $element2) {
    $datetime1 = strtotime($element1['fechaPublicacion']);
    $datetime2 = strtotime($element2['fechaPublicacion']);
    return $datetime2 - $datetime1;
}


public static function eliminarNoticia($idNoticia){

    $conn = Aplicacion::getInstance()->getConexionBd();	
    
    $query = sprintf("DELETE FROM noticia WHERE idNoticia = $idNoticia");
    $rs = $conn->query($query);
    $check =false;

    if($rs){
        $check =true;
    }
    
    return $check;        
}


/** Actualiza la peliicula existente en BD guarda() -> actualiza() */
 private static function actualiza($noticia){
    $result = false;
    $conn = Aplicacion::getInstance()->getConexionBd();
    $query=sprintf("UPDATE noticias SET noticias.titulo = '%s', noticias.subtitulo='%s', noticias.imagenNombre='%s',
     noticias.contenido='%s', noticias.fechaPublicacion='%s', noticias.autor='%s', noticias.categoria='%s', noticias.etiquetas='%s'
        WHERE noticias.idNoticia = %d"
        , $conn->real_escape_string($noticia->titulo)
        , $conn->real_escape_string($noticia->subtitulo)
        , $conn->real_escape_string($noticia->imagenNombre)
        , $conn->real_escape_string($noticia->contenido)
        , $conn->real_escape_string($noticia->FechaPublicacion)
        , $conn->real_escape_string($noticia->autor)
        , $conn->real_escape_string($noticia->categoria)
        , $conn->real_escape_string($noticia->etiquetas)
        , $noticia->idNoticia
    );
    if ( $conn->query($query) ) {
        $result = true;
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}














}



?>