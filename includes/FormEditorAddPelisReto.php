<?php
namespace es\ucm\fdi\aw;

class FormEditorAddPelisReto extends Formulario
{
    
    private $lista;
    private $id_Reto;
    private $pelis_marcados = array();

    public function __construct($id_Reto) {
        $this->lista = $_SESSION['array'] ?? '';
        $this->id_Reto = $id_Reto;
        parent::__construct('FormEditorAddPelisReto', ['enctype' => 'multipart/form-data','urlRedireccion' => 'retoSingVist.php?retoid='.$id_Reto]);//por ahora queda mas claro asi
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        $html= "<fieldset> <legend>Añadir pelis al reto</legend>";
        
        if(!empty($this->lista)){
        foreach($this->lista as $pelis){
            $id_pelis = $pelis->getId();
            $titulo_pelis = $pelis->getTitulo();
            $html.=<<<EOS
            <div class= "checkbox">
            <input type="checkbox" name="pelis_marcados[]" value=$id_pelis> $titulo_pelis
            </div>
            <div>
            EOS;
        }
        }
        else{
            $html.=<<<EOS
            <div>
            <p><strong>NO HAY COINCIDENCIA PARA TU BUSQUEDA :( </strong></p>
            <p> (comprueba la lista de pelis añadidas) </p>
            </div>
            <div>
        EOS;
        }
        if(!empty($this->lista)){
            $html.=<<<EOS
            <button type="submit" name="anadir"> Añadir </button>
            EOS;
        }
        
        $html.=<<<EOS
            <button type="submit" name="volver"> Volver </button>
        </div>
        </fieldset>
        EOS;

      
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if(isset($datos['anadir'])){

            $peli_seleccionado = $datos['pelis_marcados'];
            foreach($peli_seleccionado as $pelis){
                PelisReto::anadirPeliAReto($pelis,$this->id_Reto);
            }
        }
    }
}