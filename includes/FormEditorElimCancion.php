<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimCancion extends Formulario
{
    private $id_cancion;
    //parametro id_pelicula
    public function __construct($id_cancion, $id_bso) {
        parent::__construct('FormEditorElimCancion', ['urlRedireccion' => 'contenidoBSO.php']);//contenidoBSO.php
        $this->id_cancion = $id_cancion;
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
            <input type="hidden" name ="eliminarCancion" value="$this->id_cancion" />
            <button type="submit" name="eliminar">Eliminar</button>
        </div>
           
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) 
    {
        $borrar = path\Cancion::eliminarCancion($this->id_cancion); //realmente le esta pasando el id
        $decrementaBSO = path\BSO::disminuyeNumCanciones($this->id_bso);
    }
}

