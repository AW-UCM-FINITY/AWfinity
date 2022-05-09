<?php
namespace es\ucm\fdi\aw;


class FormCambiaApariencia extends Formulario
{

  

    public function __construct() {
        parent::__construct('FormCambiaApariencia', ['urlRedireccion' => 'vistaAdminApariencia.php']);//por ahora queda mas claro asi
      
    }
    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        //input type hidden
       // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div>
        EOF;
        if(Apariencia::getAspecto()->getCss()==="default.css"){
            $html = <<<EOF
           
            <button name="botoncolor1" class ="temaAzul" type="submit" > Naranja </button>
            </div>
            EOF;
        }else{
            $html = <<<EOF
            
           
            <button name="botoncolor2" class ="temaRosa" type="submit" > Granate </button>
            </div>
            EOF;
        }
        
       
           
       
        return $html;
    }

    protected function procesaFormulario(&$datos) 
    {
    
       if(isset($datos['botoncolor1']) ){
        $b=Apariencia::setAspecto("azul.css");
       }
    
        if(isset($datos['botoncolor2']) ){
           $b= Apariencia::setAspecto("default.css");
        }
       
      
        
    }



}


?>