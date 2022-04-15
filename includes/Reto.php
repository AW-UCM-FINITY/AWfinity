<?php 
namespace es\ucm\fdi\aw;

class Reto{

    private $id_Reto;
    private $nombre;
    private $num_usuarios;
    private $num_completado;
    private $dificultad;
    private $descripcion;
    private $dias;
    private $puntos;

    const dificultadES = array("DIFICIL","MEDIO","FACIL");
    public function __construct($nombree, $num_usuarioss, $num_completado, $dificultad, $descripcion, $dias, $puntos, $id_Reto = NULL)
    {
        $this->id_Reto=$id_Reto;
        $this->nombre=$nombree;

        $this->num_usuarios=$num_usuarioss;
        $this->num_completado=$num_completado;
        $this->dificultad=$dificultad;
        $this->descripcion=$descripcion;
        $this->dias=$dias;
        $this->puntos=$puntos;
    }

    public function getIdReto(){
        return $this->id_Reto;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getNumMiembros(){
        return $this->num_usuarios;
    }
    
    public function getNumCompletado(){
        return $this->num_completado;
    }
    
    public function getDificultad(){
        return $this->dificultad;
    }
    
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getDias(){
        return $this->dias;
    }
    public function getPuntos(){
        return $this->puntos;
    }

    public static function getdificultades(){

        $arraydif=array();
        foreach (self::dificultadES as $key => $value) {
            $arraydif[]=$value;
        }
        return $arraydif;
    }

  


    public static function crea($nombre, $num_usuarios, $num_completado, $dificultad, $descripcion, $dias, $puntos){
  
        $reto = self::buscarNombre($nombre);
        if ($reto) {//AQUI SI DA FALSE SE METE el reto(PORQUE NO EXISTE DE ANTES)
            return false;
        }
        $reto = new Reto( $nombre, $num_usuarios, $num_completado, $dificultad, $descripcion, $dias, $puntos);
    
        return self::inserta($reto);
    }
    
     
     private static function inserta($reto){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO retos (nombre,num_usuarios, num_completado, dificultad, descripcion, dias, puntos) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
      
            , $conn->real_escape_string($reto->nombre)
            , $conn->real_escape_string($reto->num_usuarios)
            , $conn->real_escape_string($reto->num_completado)
            , $conn->real_escape_string($reto->dificultad)
            , $conn->real_escape_string($reto->descripcion)
            , $conn->real_escape_string($reto->dias)
            , $conn->real_escape_string($reto->puntos)
           
        );
    
        if ($conn->query($query)) {
            $reto->id_Reto = $conn->insert_id;//obtiene el id de la bd automaticamente
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    
    static public function buscarNombre($busqueda){ 
       
        $conn =  Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM retos R  WHERE R.nombre ='%s'", $conn->real_escape_string($busqueda));
        $consulta = $conn->query($sql);
        $reto=false;
 
        if($consulta && $consulta->num_rows > 0){
            while ($fila = mysqli_fetch_assoc($consulta)) {
                $reto= new Reto($fila['nombre'],$fila['num_usuarios'],$fila['num_completado'],$fila['dificultad'],$fila['descripcion'],$fila['dias'],$fila['puntos'],$fila['id_Reto']);
                
            }
            $consulta->free();
        }
 
        return $reto;
    }
    static public function buscar($busqueda){ 

       $conn =  Aplicacion::getInstance()->getConexionBd();

       $sql = "SELECT * FROM retos R  WHERE R.nombre LIKE \"%$busqueda%\" ";
       

       $consulta = $conn->query($sql);
       $arrayRetos=array();

       if($consulta->num_rows > 0){
           while ($fila = mysqli_fetch_assoc($consulta)) {
               $arrayRetos[]= new Reto($fila['nombre'],$fila['num_usuarios'],$fila['num_completado'],$fila['dificultad'],$fila['descripcion'],$fila['dias'],$fila['puntos'],$fila['id_Reto']);
               
           }
           $consulta->free();
       }

       return $arrayRetos;
   }
   
   static public function buscarPorId($id){ 

     

    $sql = "SELECT * FROM retos R  WHERE R.id_Reto= $id ";
    
   
    $conn =  Aplicacion::getInstance()->getConexionBd();
    $consulta = $conn->query($sql);
    $arrayRetos=false;

    if($consulta->num_rows > 0){
        while ($fila = mysqli_fetch_assoc($consulta)) {
            $arrayRetos= new Reto($fila['nombre'],$fila['num_usuarios'],$fila['num_completado'],$fila['dificultad'],$fila['descripcion'],$fila['dias'],$fila['puntos'],$fila['id_Reto']);
            
        }
        $consulta->free();
    }

    return $arrayRetos;
}



   public static function actualiza($nombre, $num_usuarios, $num_completado, $dificultad, $descripcion, $dias, $puntos, $id_Reto){
   
    $result = false;
    $conn = Aplicacion::getInstance()->getConexionBd();
   
    
    $query=sprintf("UPDATE retos R SET R.nombre='%s', R.num_usuarios='%s', R.num_completado='%s',
     R.dificultad='%s', R.descripcion='%s', R.dias='%s', R.puntos='%s'
        WHERE R.id_Reto = '%s'"
        ,$conn->real_escape_string($nombre)
        , $conn->real_escape_string($num_usuarios)
        , $conn->real_escape_string($num_completado)
        , $conn->real_escape_string($dificultad)
        , $conn->real_escape_string($descripcion)
        , $conn->real_escape_string($dias)
        , $conn->real_escape_string($puntos)
        , $conn->real_escape_string($id_Reto)
   
    );
    if ( $conn->query($query) ) {
        $result = true;
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    return $result;
}


static public function elimina($id_Reto){
		
    $conn = Aplicacion::getInstance()->getConexionBd();
    $check =true;

    $sql= "DELETE FROM retos WHERE id_Reto = $id_Reto";

    if($conn->query($sql) === TRUE){
        $check =true;
    }else{
        $check =false;
    }

    return $check;
}

public static function getRetos(){

    $sql = "SELECT * FROM retos";

    
    $conn = Aplicacion::getInstance()->getConexionBd();
    $consulta = $conn->query($sql);

    

    if($consulta->num_rows > 0){
        $arrayRetos = array();
        while ($fila = mysqli_fetch_assoc($consulta)) {

            $arrayRetos[]= new Reto($fila['nombre'],$fila['num_usuarios'],$fila['num_completado'],$fila['dificultad'],$fila['descripcion'],$fila['dias'],$fila['puntos'],$fila['id_Reto']);
              
        }
        $consulta->free();
    }else{
        $arrayRetos = false;
    }


    return $arrayRetos;
}

static public function ordenarPor($ordenar, $numero){ 

    $sql = "SELECT * FROM retos ORDER BY $ordenar DESC";

    $conn = Aplicacion::getInstance()->getConexionBd();
    $consulta = $conn->query($sql);
    $arrayRetos=array();

    if($consulta->num_rows > 0){
        while ($numero > 0 && $fila = mysqli_fetch_assoc($consulta)) {
            $arrayRetos[]= new Reto($fila['nombre'],$fila['num_usuarios'],$fila['num_completado'],$fila['dificultad'],$fila['descripcion'],$fila['dias'],$fila['puntos'],$fila['id_Reto']);
            $numero--;
        }
        $consulta->free();
    }

    return $arrayRetos;
}


public static function pagina($numPagina,$numPorPagina){

    $sql = "SELECT * FROM retos R";

    $sql .= ' ORDER BY R$num_usuarios DESC';

    if ($numPorPagina > 0) {
        $sql .= " LIMIT $numPorPagina";

        $offset = $numPagina  *$numPorPagina;
        if ($offset > 0) {
          $sql .= " OFFSET $offset";
        }
    }

    $conn = Aplicacion::getInstance()->getConexionBd();
    $consulta = $conn->query($sql);

    $arrayRetos = array();

    if($consulta->num_rows > 0){
        while ($fila = mysqli_fetch_assoc($consulta)) {

            $arrayRetos[]= new path\reto($fila['id_Reto']);

        }
        $consulta->free();
    }


    return $arrayRetos;
}

static public function incrementaNumUsuarios($id_Reto){

    $conn = Aplicacion::getInstance()->getConexionBd();
    $query="UPDATE retos SET num_usuarios = num_usuarios + 1 WHERE id_Reto = $id_Reto";

    if ( $conn->query($query) ) {
        if ( $conn->affected_rows != 1) {
            echo "No se ha podido actualizar el reto: " . $reto->nombre;
            exit();
        }
    } else {
        echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        exit();
    }
    

}

static public function decrementaNumUsuarios($id_Reto){

    $conn = Aplicacion::getInstance()->getConexionBd();
    $query="UPDATE retos SET num_usuarios = num_usuarios - 1 WHERE id_Reto = $id_Reto";

    if ( $conn->query($query) ) {
        if ( $conn->affected_rows != 1) {
            echo "No se ha podido actualizar el reto: " . $reto->nombre;
            exit();
        }
    } else {
        echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        exit();
    }
    

}

static public function incrementaNumCompletados($id_Reto){

    $conn = Aplicacion::getInstance()->getConexionBd();
    $query="UPDATE retos SET num_completado = num_completado + 1 WHERE id_Reto = $id_Reto";

    if ( $conn->query($query) ) {
        if ( $conn->affected_rows != 1) {
            echo "No se ha podido actualizar el reto: " . $reto->nombre;
            exit();
        }
    } else {
        echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        exit();
    }
    

}

public static function getNumRetos(){

    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql = "SELECT * FROM retos";

    $consulta = $conn->query($sql);

    $numRetos = 0;

    if($consulta->num_rows > 0){
        while ($fila = mysqli_fetch_assoc($consulta)) {
            $numRetos++;
        }
        $consulta->free();
    }
    return $numRetos;
}



}
