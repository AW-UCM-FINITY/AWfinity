<?php
namespace es\ucm\fdi\aw;

class FormEditorElimUsuario extends Formulario
{

    private $usuario;
    
    public function __construct($usuario) {
        parent::__construct('FormEditorElimUsuario', ['enctype' => 'multipart/form-data','urlRedireccion' => 'vistaAdminGestionUser.php']);//por ahora queda mas claro asi
        $this->usuario=$usuario;
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        //solo el administrador tiene permiso para borrar usuarios con rol editor y normal (no otros admistradores)
        if(esAdmin() && $this->usuario->getRol()!=="admin"){

        $html=<<<EOS
        <div>
            <input type="hidden" name="eliminarUsuario" value="{$this->usuario->getId()}" />
            <button type="submit" name="Eliminar">Eliminar</button>
        </div>
        EOS;
        }
        else{
            $html = <<<EOF
            $htmlErroresGlobales
            EOF;
        }
        return $html;
        }

    protected function procesaFormulario(&$datos)
    {
        Usuario::borrar($datos['eliminarUsuario']);
              
     }
}