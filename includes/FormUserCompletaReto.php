<?php
namespace es\ucm\fdi\aw;


class FormUserCompletaReto extends Formulario
{
    private $id_user;
    private $id_Reto;

    public function __construct($id_user, $id_Reto, $id_pelis) {
        $this->id_user = $id_user;
        $this->id_Reto = $id_Reto;
        $this->id_pelis = $id_pelis;
        
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
        $pelisretoArray=PelisReto::getPelisporReto($this->id_Reto);
        $total=count($pelisretoArray);
       
        if( $total>0){
         
           
                PelisReto::completaPeliReto($this->id_user, $this->id_Reto, $this->id_pelis);
                $peliscompl= PelisReto::contarPelisCompletadas($this->id_user,$this->id_Reto);
               
                if($total==$peliscompl){
                    UsuarioReto::completaReto($this->id_user,$this->id_Reto); 
                }
            
        }else{
            $this->errores[] ="Error en la completacion del reto";
        }
       
    }
}
