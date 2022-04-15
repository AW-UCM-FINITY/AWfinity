<?php
namespace es\ucm\fdi\aw;


class FormUserCompletaReto extends Formulario
{
    private $id_user;
    private $id_Reto;

    public function __construct($id_user, $id_Reto) {
        $this->id_user = $id_user;
        $this->id_Reto = $id_Reto;
        parent::__construct('FormUserCompletaReto', ['urlRedireccion' => 'retoSingVist.php?retoid='.$id_Reto]);
        
    }

    
    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

      
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div>
            <input type="hidden" name="CompletaReto" value="$this->id_Reto" />
            <button type="submit" name="Completa">Completar Reto</button>
        </div>
           
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) 
    {
        UsuarioReto::completaReto($this->id_user,$this->id_Reto); 
    }
}
