<?php
namespace es\ucm\fdi\aw;

class FormAdminElimConsulta extends Formulario
{

    private $consulta;
    
    public function __construct($consulta) {
        parent::__construct('FormAdminElimConsulta', ['enctype' => 'multipart/form-data','urlRedireccion' => 'vistaAdminGestionConsulta.php']);//por ahora queda mas claro asi
        $this->consulta=$consulta;
    }
    

    protected function generaCamposFormulario(&$datos){

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        
        $html=<<<EOS
        <div>
            <input type="hidden" name="eliminarConsulta" value="{$this->consulta}" />
            <button type="submit" name="Eliminar">Eliminar</button>
        </div>

        $htmlErroresGlobales
        EOS;
        
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        Contacto::elimConsultas($datos['eliminarConsulta']);
              
     }
}