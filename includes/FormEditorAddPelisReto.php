<?php
namespace es\ucm\fdi\aw;

class FormEditorAddPelisReto extends Formulario
{
    
    private $lista;
    private $id_Reto;
    private $pelis_marcados = array();

    public function __construct($id_Reto) {
        $this->lista = $_SESSION['array'];
        $this->id_Reto = $id_Reto;
        parent::__construct('FormEditorAddPelisReto', ['enctype' => 'multipart/form-data','urlRedireccion' => 'retoSingVist.php?retoid='.$id_Reto]);//por ahora queda mas claro asi
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        $html= "<fieldset>";
        
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
            <button type="submit" name="anadir"> Añadir </button>
            <button type="submit" name="cancelar"> Cancelar </button>
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
        
        return null;
    }
}