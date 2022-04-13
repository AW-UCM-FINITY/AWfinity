<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimEpisodio extends Formulario
{
    private $id_episodio;
    //private $id_serie;
    public function __construct($id_episodio) {
        parent::__construct('FormEditorElimEpisodio', ['urlRedireccion' => 'contenidoSeries.php']);
        $this->id_episodio = $id_episodio;
        //$this->id_serie = $id_serie;
        //'serieVista.php?id_serie='.$this->id_serie
    }

    
    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

      
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div>
            <input type="hidden" name="eliminarEpi" value="$this->id_episodio" />
            <button type="submit" name="eliminar">Eliminar</button>
        </div>
           
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) 
    {
        $borrar = path\Episodio::eliminarEpisodio($this->id_episodio); 
        
    }
}
