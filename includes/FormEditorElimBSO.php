<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimBSO extends Formulario
{

    private $id_bso;

    public function __construct($id_bso) {
        parent::__construct('FormEditorElimBSO', ['urlRedireccion' => 'contenidoBSO.php']);//por ahora queda mas claro asi
        $this->id_bso = $id_bso;
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
            <input type="hidden" name ="eliminarSerie" value="$this->id_bso" />
            <button type="submit" name="eliminar">Eliminar</button>
        </div>
           
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) //le llega el selectPeli
    {
        //Borra la serie y todos los episodio asociados
        $borrar = path\BSO::eliminarBSO($this->id_bso); //realmente le esta pasando el id
        
    }



}


?>