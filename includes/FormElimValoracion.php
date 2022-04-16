<?php
namespace es\ucm\fdi\aw;


class FormElimValoracion extends Formulario
{
   
    private $valoracion;
    public function __construct($valoracion) {
        $this->valoracion=$valoracion;
        parent::__construct('FormElimValoracion', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'blogVista.php?tituloid='.$this->valoracion->getIdNoticia()]);
       
       
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        
        
        // Se generan los mensajes de error si existen.
        $user=Usuario::buscaPorId($this->valoracion->getIdUser());
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        if(($_SESSION['nombreUsuario']===$user->getNombreUsuario() ) || $_SESSION['esEditor']){
                
            $html = <<<EOF
            <input type="hidden" name="elimcoment" value="{$this->valoracion->getId_valoracion()}" />
            <button type="submit" name="elim">Eliminar comentario</button>
            $htmlErroresGlobales
            EOF;
        
        }else{
            $html = <<<EOF
            $htmlErroresGlobales
        EOF;
        }
       
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
       

                
                    $res = Valoracion::elimValoracion($datos['elimcoment']);
                    if(!$res){
                        $this->errores[] = "No se ha podido eliminar el comentario.";
                    }
          
        return $this->errores;
   }
}
?>