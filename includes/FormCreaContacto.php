<?php
namespace es\ucm\fdi\aw;


class FormCreaContacto extends Formulario
{
    private $nombre;
    public function __construct($nombreUsuario) {
        $this->nombre=$nombreUsuario;
        parent::__construct('formCreaContacto', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'contacto.php']);
       
       
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'consulta', 'email'], $this->errores, 'span', array('class' => 'error'));

        if($this->nombre!=='NOREGISTRADO'){
            $campoNombre = "<input type=\"text\" name=\"nombre\" size=\"20\" value=\"$this->nombre\" readonly>";
        }
        else{
            $campoNombre = "<input type=\"text\" name=\"nombre\" size=\"20\" >";
        }

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
            $htmlErroresGlobales
            <fieldset>
            <legend>Contacto</legend>
            <p> Nombre: </p> 
            {$campoNombre}
            {$erroresCampos['nombre']}

            <p> Email:</p> 
            <input type="text" name="email" size="20">
            {$erroresCampos['email']}

            <div>
                <p>Motivo:</p>
                <input type="radio" name="motivo" value="evaluacion" checked/> Evaluación
                <input type="radio" name="motivo" value="sugerencias"/> Sugerencias
                <input type="radio" name="motivo" value="criticas"/> Críticas
            </div>

            <div>
            <textarea name="consulta" rows="10" cols="45" placeholder="Escriba aquí su consulta..."></textarea>
            {$erroresCampos['consulta']}
            </div>

            <p>Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio:</p>
            <div><input type="checkbox" name="aceptarcond" value="acepto" required='required' checked/> Acepto</div>

            <div><button type="submit" name="submit" value="Enviar">Enviar</button></div>
            </fieldset>
        EOF;
        return $html;
        
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($nombre) ) {
            $this->errores['nombre'] = "El nombre no puede estar vacío";
        }
    
        $email = $datos['email'] ?? '';
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ( empty($email) ) {
            $this->errores['email'] = "El correo no puede estar vacío";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->errores['email'] = "Introduzca un correo con formato valido";
        }

        $motivo = trim($datos['motivo'] ?? '');
        $motivo = filter_var($motivo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $consulta = trim($datos['consulta'] ?? '');
        $consulta = filter_var($consulta, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($consulta) ) {
            $this->errores['consulta'] = "La consulta no puede estar vacío";
        }
        

        if (count( $this->errores) === 0) {
            $re=Contacto::crearContacto($nombre, $email, $consulta, $motivo);
            if(!$re){
                $this->errores[] = "Errores en la creacion de consulta";
            }


        }
        return $this->errores;
    }
}