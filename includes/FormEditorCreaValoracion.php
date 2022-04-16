<?php
namespace es\ucm\fdi\aw;


class FormEditorCreaValoracion extends Formulario
{
   
    private $id_noticia;
    private $id_user;
    public function __construct($id_noticia,$id_user) {
        $this->id_noticia=$id_noticia;
        $this->id_user=$id_user;
        parent::__construct('formCrearValoracion', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'blogVista.php?tituloid='.$this->id_noticia]);
       
       
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $puntuacion=1;
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['puntuacion', 'valoracion'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
            $htmlErroresGlobales
            <fieldset><legend>¡ Deja tu comentario !</legend>
            <p> Puntuacion (1-5): </p> 
            <input id="puntuacion" type="range" name="puntuacion" value="$puntuacion" min="1" max="5" oninput="puntuacionout.value = puntuacion.value"/>
            <output name="puntuacionout" id="puntuacionout">$puntuacion</output>
            {$erroresCampos['puntuacion']}
            
            <p> Comentario:</p> 
            <textarea name="valoracion" rows="8" cols="200"></textarea>
            {$erroresCampos['valoracion']}
    
            <button class="submit" type="submit" name="registro">Añadir</button>
            </fieldset>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $valoracion = $datos['valoracion'] ?? '';
        $puntuacion = $datos['puntuacion'] ?? '';
      
                
        if ( empty($valoracion) ) {
            $this->errores['valoracion'] = "La valoración no puede estar vacía";
        }
        if($puntuacion < 0){
            $this->errores['puntuacion'] = "La puntuacion no puede ser negativa";
        }
        if(!isset($_SESSION['login'])){
            $this->errores[] = "Tienes que estar registrado para crear una valoración";
        }

        if (count( $this->errores) === 0) {
            $re=Valoracion::crearComentario($this->id_noticia, $this->id_user, $valoracion, $puntuacion);
            if(!$re){
                $this->errores[] = "Errores en la creacion de comentarios";
            }


        }
        return $this->errores;
    }
}