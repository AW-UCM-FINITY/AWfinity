<?php
namespace es\ucm\fdi\aw;

class Noticia{

    private $idNoticia;
    private $titulo;
    private $subtitulo;
    private $imagenNombre;
    private $contenido;
    private $fechaPublicacion;
    private $autor;
    private $categoria;//(noticia, noticia-evento,noticia-estreno)
    private $etiquetas; //de momento no se pone
   


 //Constructor
 private function __construct($titulo, $subtitulo, $imagenNombre, $contenidos, $fechaPublicacion, $autor,$categoria,$etiquetas,$idNoticia) {
    $this->idNoticia=$idNoticia;
    $this->titulo=$titulo;
    $this->subtitulo=$subtitulo;
    $this->imagenNombre=$imagenNombre;
    $this->contenido=$contenidos;
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
    $rs->free();
    return $enum;
}


//Obtener lista de titulos de las noticias de la BD
public static function getTituloNoticia(){
    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql = "SELECT titulo FROM noticias";
    $consulta = $conn->query($sql);

    $arrayNoticias = array();

    if($consulta->num_rows > 0){
        while ($fila = $consulta->fetch_assoc()) {
            $arrayNoticias[]=$fila['titulo'];
        }
        $consulta->free();
    }
    return $arrayNoticias;
}



public static function crea($titulo, $subtitulo, $imagenNombre, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas,$idNoticia ){
  
    $noticia = self::buscaNoticia($titulo);
    if ($noticia) {//AQUI SI DA FALSE SE METE LA NOTIICA(PORQUE NO EXISTE DE ANTES)
        return false;
    }
    $noticia = new Noticia( $titulo, $subtitulo, $imagenNombre,$contenido, $fechaPublicacion, $autor,$categoria,$etiquetas, $idNoticia);

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
            $result = new Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas'], $fila['idNoticia']);
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
            $result = new Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas'],$fila['idNoticia']);
        }
        $rs->free();
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}

public static function busca($busqueda)
{
    $conn = Aplicacion::getInstance()->getConexionBd();
    $query ="SELECT * FROM noticias WHERE noticias.titulo LIKE \"%$busqueda%\" OR noticias.contenido LIKE \"%$busqueda%\" ";
    $rs = $conn->query($query);
    $result = array();
  
    if ($rs) {
        while($fila = $rs->fetch_assoc()){
        
            $result[] = new Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas'],$fila['idNoticia']);
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
        while ($fila = $consulta->fetch_assoc()) {
            $arrayNoticias[]=new Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas'],$fila['idNoticia']);
      
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
    $datetime1 = strtotime($element1->fechaPublicacion);
    $datetime2 = strtotime($element2->fechaPublicacion);
    return $datetime1 - $datetime2;
} 
public static  function  date_compare2($element1, $element2) {
    $datetime1 = strtotime($element1->fechaPublicacion);
    $datetime2 = strtotime($element2->fechaPublicacion);
    return $datetime2 - $datetime1;
}


public static function eliminarNoticia($idNoticia){

    $conn = Aplicacion::getInstance()->getConexionBd();	
    $notic=self::buscaNoticiaID($idNoticia);
    $query = sprintf("DELETE FROM noticias WHERE noticias.idNoticia='%s'",$idNoticia);
    $rs = $conn->query($query);
    $check =false;
    
    if($rs){
        $check =true;
        unlink(RUTA_IMGS."/".$notic->getImagenNombre()); 
    }
    
    return $check;        
}


/** Actualiza la peliicula existente en BD guarda() -> actualiza() */
 public static function actualiza($idnoticia,$titulo, $subtitulo, $imagenNombre, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas){
    $result = false;
    $imagenNombree='';
    if($imagenNombre==NULL){
        $not=self::buscaNoticiaID($idnoticia);
        $imagenNombree=$not->imagenNombre;
    }else{
        $imagenNombree= $imagenNombre;
    }
    $conn = Aplicacion::getInstance()->getConexionBd();
   
    
    $query=sprintf("UPDATE noticias SET noticias.titulo='%s', noticias.subtitulo='%s', noticias.imagenNombre='%s',
     noticias.contenido='%s', noticias.fechaPublicacion='%s', noticias.autor='%s', noticias.categoria='%s', noticias.etiquetas='%s'
        WHERE noticias.idNoticia = '%s'"
        ,$conn->real_escape_string($titulo)
        , $conn->real_escape_string($subtitulo)
        , $conn->real_escape_string($imagenNombree)
        , $conn->real_escape_string($contenido)
        , $conn->real_escape_string($fechaPublicacion)
        , $conn->real_escape_string($autor)
        , $conn->real_escape_string($categoria)
        , $conn->real_escape_string($etiquetas)
        , $conn->real_escape_string($idnoticia)
    );
    if ( $conn->query($query) ) {
        $result = true;
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}

public static function getNumNoticias(){

    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql = "SELECT * FROM noticias";

    $consulta = $conn->query($sql);

    $numNoticias = 0;

    if($consulta->num_rows > 0){
        while ($fila = mysqli_fetch_assoc($consulta)) {
            $numNoticias++;
        }
        $consulta->free();
    }
    return $numNoticias;
}


public static function pagina($numPagina,$numPorPagina){

    $sql = "SELECT * FROM noticias N";


    if ($numPorPagina > 0) {
        $sql .= " LIMIT $numPorPagina";

        $offset = $numPagina  *$numPorPagina;
        if ($offset > 0) {
          $sql .= " OFFSET $offset";
        }
    }

    $conn = Aplicacion::getInstance()->getConexionBd();
    $consulta = $conn->query($sql);

    $arrayNoticias = array();

    if($consulta->num_rows > 0){
        while ($fila = mysqli_fetch_assoc($consulta)) {

            $arrayNoticias[]= new Noticia($fila['titulo'], $fila['subtitulo'], $fila['imagenNombre'],$fila['contenido'], $fila['fechaPublicacion'], $fila['autor'], $fila['categoria'],  $fila['etiquetas'],$fila['idNoticia']);
      
        }
        $consulta->free();
    }


    return $arrayNoticias;
}















}



?>