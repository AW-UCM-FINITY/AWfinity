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
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        
        $html = <<<EOF
            <button type="submit" name="elim">Eliminar comentario</button>
            $htmlErroresGlobales
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
       

        
           
           $user=Usuario::buscaPorId($this->valoracion->getIdUser());
            if(($_SESSION['nombreUsuario']!=$user->getNombreUsuario()  && !$_SESSION['esAdmin'])){
                
                    $this->errores[] = "No puedes eliminar un comentario si no tienes permisos";
                
            }
            if (count($this->errores) === 0) {

                
                    $res = Valoracion::elimValoracion($this->valoracion->getId_valoracion());
                    if(!$res){
                        $this->errores[] = "No se ha podido eliminar el comentario.";
                    }
            }else{
                $this->errores[] = "No se ha podido eliminar el comentario.";
            }
        
        return $this->errores;
   }
}
?>