<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimPeli extends Formulario
{
    public function __construct() {
        parent::__construct('FormEditorElimPeli', ['urlRedireccion' => 'editor.php']);//por ahora queda mas claro asi
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        $peli = path\Pelicula::getPeliculas();
        $selectPeli = "<select class='peli_titulo' name=titulo>" ;
        ///"<option value="" selected disabled hidden>Choose here</option>";
        foreach ($peli as $key => $value) {
            $selectPeli.="<option value=$key> $value </option> ";

        }
        $selectPeli.="</select>";

       // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
            <fieldset> 
            <legend>Eliminar una Pelicula</legend>
                <div>
                    $selectPeli 
                </div>
                <div>
                    <button type="submit" name="eliminar">Eliminar</button>
                </div>
            </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) //le llega el selectPeli
    {
        $titulo = trim($datos['titulo'] ?? '');
        $borrar = path\Pelicula::eliminarPelicula($titulo);
        

       $vuelta = 'edit.php';

       return $vuelta;
    }
}

