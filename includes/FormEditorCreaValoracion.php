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
            <textarea id="valoracion" name="valoracion" rows="8" cols="165"></textarea>
            {$erroresCampos['valoracion']}
    
            <button class="submit" type="submit" name="registro">Añadir</button>
            </fieldset>
            <script>
            tinyMCE.init({
                selector : '#valoracion',
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image',
                theme : 'silver',
                theme_advanced_buttons3_add : 'fullpage'

                });
            </script>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        
        $valoracion = $datos['valoracion'] ?? '';
              
            require_once __DIR__.'/htmlpurifier-4.13.0/library/HTMLPurifier.auto.php';

            $dirty_html = $valoracion ?? '';
            $config = \HTMLPurifier_Config::createDefault();

            // Habilitar la opción de embeber vídeos de YouTube
            $config->set('HTML.SafeIframe', true);
            $config->set('URI.SafeIframeRegexp', '%^http(s)?://www.youtube.com/embed/%');
            // https://github.com/intelliants/subrion/commit/ddc3fe7a12832ec754bbde2ac20b7a8ad3442071
            // Set some HTML5 properties
            $config->set('HTML.DefinitionID', 'html5-video'); // unqiue id
            $config->set('HTML.DefinitionRev', 1);
            if ($def = $config->maybeGetRawHTMLDefinition()) {
                $def->addElement('video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                    'width' => 'Length',
                    'height' => 'Length',
                    'poster' => 'URI',
                    'preload' => 'Enum#auto,metadata,none',
                    'controls' => 'Bool',
                ]);
                $def->addElement('source', 'Block', 'Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                ]);
            }


            $purifier = new \HTMLPurifier($config);
            $valoracion = $purifier->purify($dirty_html);
        
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