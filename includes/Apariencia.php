<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de las peliculas.
 */

class Apariencia
{
    

   
    private $css;
    private function __construct($css) {
        $this->css=$css;
    }
    public function getCss() {
        return $this->css;
    }
  


    public static function getAspecto(){
            $result = false;
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = "SELECT * FROM apariencia";
              
            
            $rr=$conn->query($query);
            if($fila= mysqli_fetch_assoc($rr)) {
                $result  =new Apariencia($fila['aspecto']);
                $rr->free();
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return $result;
    }
    public static function setAspecto($css){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query =sprintf("UPDATE apariencia SET aspecto='%s'",$conn->real_escape_string($css));
          
        if ($conn->query($query)) {
            $result  =true;
            
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
}
    

}