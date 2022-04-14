<?php
namespace es\ucm\fdi\aw;

class FormEditorElimReto extends Formulario
{

    private $id_Reto;
    
    public function __construct($id_Reto) {
        parent::__construct('FormEditorElimReto', ['enctype' => 'multipart/form-data','urlRedireccion' => 'retoVista.php']);//por ahora queda mas claro asi
        $this->id_Reto=$id_Reto;
    }
    

    protected function generaCamposFormulario(&$datos){
        $html=<<<EOS
        <div>
            <input type="hidden" name="eliminarReto" value="$this->id_Reto" />
            <button type="submit" name="Eliminar">Eliminar</button>
        </div>
        EOS;
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $borrarReto = Reto::elimina($this->id_Reto);
        return null;
              
     }
}