<?php
namespace es\ucm\fdi\aw;

class FormEditorBuscaPelisReto extends Formulario
{
    
    public function __construct() {
        parent::__construct('FormEditorBuscarPelisReto', ['enctype' => 'multipart/form-data','urlRedireccion' => 'reto.php']);//por ahora queda mas claro asi
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo'], $this->errores, 'span', array('class' => 'error'));

        $html=<<<EOS

        <fieldset>
        <legend>Añadir pelis al reto</legend>
        <div>
            <label for="buscarPelis">Buscar Pelicula:</label>
            <input id="titulo" type="text" name="titulo" />
            <button type="submit" name="buscar">Buscar</button>
        </div>
        </fieldset>
        EOS;
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $titulo = trim($datos['titulo'] ?? '');
        $titulo = filter_var($titulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ( empty($titulo) ) {
            $this->errores['titulo'] = 'No puede estar vacia la busqueda.';
        }
        
        if (count($this->errores) === 0) {
            return Pelicula::buscar($titulo);
        }
        return null;        
     }
}