<?php
namespace es\ucm\fdi\aw;

class FormEditorBuscaPelisReto extends Formulario
{
    
    private $id_reto;

    public function __construct($id_reto) {
        $this->id_reto = $id_reto;
        $d='retoSingVist.php?retoid='.$id_reto.'&busca=1';
        parent::__construct('FormEditorBuscarPelisReto', ['enctype' => 'multipart/form-data','urlRedireccion' => $d]);//por ahora queda mas claro asi
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo'], $this->errores, 'span', array('class' => 'error'));

        $html=<<<EOS
        $htmlErroresGlobales
        <fieldset>
        <legend>Añadir pelis al reto</legend>
        <div>
            <label for="titulo">Buscar Pelicula:</label>
            <input id="titulo" type="text" name="titulo" />
            {$erroresCampos['titulo']}
        </div>
        <div>
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
        $listaPelis1 = array();

        if ( empty($titulo) ) {
            $this->errores['titulo'] = 'No puede estar vacia la busqueda.';
        }
        
        if (count($this->errores) === 0) {
            $listaPelis1=Pelicula::buscar($titulo);

            foreach($listaPelis1 as $pelis){
                if(!PelisReto::PelisEnReto($pelis->getId(),$this->id_reto)){
                    $_SESSION['array'][]=$pelis;
                }
            }

        }   
     }
}