<?php
namespace es\ucm\fdi\aw;

class FormEditorAddPelisReto extends Formulario
{
    
    private $lista;
    private $id_Reto;
    private $pelis_marcados = array();

    public function __construct($lista, $id_Reto) {
        $this->lista = $lista;
        $this->id_Reto = $id_Reto;
        parent::__construct('FormEditorAddPelisReto', ['enctype' => 'multipart/form-data','urlRedireccion' => 'retoVista.php']);//por ahora queda mas claro asi
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        $html= "";
        
        foreach($this->lista as $pelis){
            $id_pelis = $pelis->getId();
            $titulo_pelis = $pelis->getTitulo();
            $html.=<<<EOS
            <div>
            <input type="checkbox" name="pelis_marcados[]" value=$id_pelis> $titulo_pelis
            </div>
            EOS;
        }
        $html.=<<<EOS
        <div>
            <button type="submit" name="registro"> Añadir </button>
        </div>
        EOS;

        $html.=<<<EOS
        <div>
            <button type="submit" name="registro"> Añadir </button>
        </div>
        EOS;
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        /*$peli_seleccionado = $datos['pelis_marcados'];
        foreach($peli_seleccionado as $pelis){
            
        }*/
        PelisReto::anadirPeliAReto(24,1);
        return null;
    }
}