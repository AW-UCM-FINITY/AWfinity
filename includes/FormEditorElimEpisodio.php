<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimEpisodio extends Formulario
{
    private $id_episodio;
    private $id_serie;
    public function __construct($id_episodio, $id_serie) {
        $this->id_serie = $id_serie;
        parent::__construct('FormEditorElimEpisodio', ['urlRedireccion' => 'serieVista.php?id_serie='.$this->id_serie]);
        $this->id_episodio = $id_episodio;
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
