<?php
namespace es\ucm\fdi\aw;

class FormEditorEditNoticia extends Formulario
{
    private $idNoticia;

    public function __construct($idNoticia) {
        // en funcion de si le esta pasando el id de la Noticia, va a ser crear o modificar
        $this->idNoticia = $idNoticia;
        
        if(isset($this->idNoticia)){    //si existe el id -> actualizamos
            $urll='blogVista.php?tituloid='.$this->idNoticia;
            parent::__construct('FormEditorEditNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' => $urll]);  //por ahora queda mas claro asi
        }
        else{   //sino -> creamos
            parent::__construct('FormEditorCreaNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' =>  'blog.php']);
        }
    }
    
    protected function generaCamposFormulario(&$datos)
    {
      
        if(isset($this->idNoticia) && empty($this->errores)){
            //modifica la noticia
            
            $noticia=Noticia::buscaNoticiaID($this->idNoticia);

            $titulo = $noticia->getTitulo() ?? '';
            $subtitulo = $noticia->getSubtitulo() ?? '';
            $contenido = $noticia->getContenido() ?? '';
            $fecha = date("Y-m-d");
            $autor = $noticia->getAutor() ?? '';
            $categoria = $noticia->getCategoria() ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';
            $etiquetas = $noticia->getEtiquetas() ?? '';
        }
        else{
            // crea la noticia
            $titulo = $datos['titulo'] ?? '';
            $subtitulo = $datos['subtitulo'] ?? '';
            $contenido = $datos['contenido'] ?? '';
            $fecha = date("Y-m-d");
            $autor = $datos['autor'] ?? '';
            $categoria = $datos['categoria'] ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';
            $etiquetas = $datos['etiquetas']?? ''; 
        }
        //Categoria
        $categorias = Noticia::getCategoriaNoticia();
        $selectNoticia = "<select class='noticia_categoria' name=categoria>" ;
        
        foreach ($categorias as $key => $value) {
            if($value == $categoria){
                $selectNoticia.="<option selected> $value </option> ";
            }
            else{
                $selectNoticia.="<option> $value </option> ";
            }
        }
       
        
        
            $selectNoticia.="</select>";

        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'subtitulo', 'contenido', 'fecha', 'autor','categoria', 'uploadfile'], $this->errores, 'span', array('class' => 'error'));

        if(isset($this->idNoticia)){
            $funcionalidad = "modificaci??n";
            $textoBoton = "modificar";
        } 
        else{
            $funcionalidad = "creaci??n";
            $textoBoton = "crear";
        } 

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para la {$funcionalidad} de Noticia</legend>
            <div>
                <label for="titulo">Titulo:</label>
                <input id="titulo" type="text" name="titulo" value="$titulo" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="subtitulo">Subtitulo:</label>
                <input id="subtitulo" type="text" name="subtitulo" value="$subtitulo" />
                {$erroresCampos['subtitulo']}
            </div>
            <div>
                <label for="autor">Autor:</label>
                <input id="autor" type="text" name="autor" value="$autor" />
                {$erroresCampos['autor']}
            </div>
            <div>
                <label for="fecha">Fecha (aa/mm/dd):</label>
                <input id="fecha" type="text" name="fecha" value="$fecha" readonly />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="categoria">Categoria:</label>
                
                $selectNoticia 
                
                
            </div>
            <div>
                <label for="contenido">Contenido:</label>
                <textarea rows=5 cols=50 id="contenido" name="contenido"  >{$contenido}</textarea>
                {$erroresCampos['contenido']}
                <script>
               
                 tinyMCE.init({
                    selector : '#contenido',
                    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image',
                    theme : 'silver',
                    theme_advanced_buttons3_add : 'fullpage'
                    });
                </script>
            </div>
            <div>
                <label for="imagen">Fichero de imagen:</label>
        EOF;
        
        if(isset($this->idNoticia)){
            $html.=<<<EOF
                <input type="file" name="uploadfile"  />
            EOF;
        }else{
            $html.=<<<EOF
                <input type="file" name="uploadfile"  required />
            EOF;
        }
        
        $html.=<<<EOF
            
            {$erroresCampos['uploadfile']}
            
            </div>
            <div>
                <button type="submit" name="registro">{$textoBoton}</button>
            </div>
            </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $titulo = trim($datos['titulo'] ?? '');
        $titulo = filter_var($titulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $titulo || mb_strlen($titulo) < 5) {
            $this->errores['titulo'] = 'El nombre de la noticia tiene que tener una longitud de al menos 5 caracteres.';
        }

        $subtitulo = trim($datos['subtitulo'] ?? '');
        $subtitulo = filter_var($subtitulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $subtitulo || mb_strlen($subtitulo)<5){
         
            $this->errores['subtitulo'] = 'El subtitulo tiene que tener una longitud de al menos 5 caracteres.';
        }

        $autor = trim($datos['autor'] ?? '');
        $autor = filter_var($autor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $autor || mb_strlen($autor)<5){
            $this->errores['autor'] = 'El autor tiene que tener una longitud de al menos 5 caracteres.';
        }

        $fechaPublicacion = trim($datos['fecha'] ?? '');
        
        //validacion fecha publicacion
        $hoy=date("Y-m-d");
        $fechaPublicacion = filter_var($fechaPublicacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $fechaPublicacion ||$fechaPublicacion<$hoy || $fechaPublicacion>$hoy ) {
            $this->errores['fecha'] = 'La fecha debe ser igual a la de hoy';
        }
        
        $categoria = trim($datos['categoria'] ?? '');
        // if ( empty( $genero)) {
        //     $this->errores['genero'] = 'El genero no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        // }

        $contenido = trim($datos['contenido'] ?? '');
        //$sinopsis = filter_var($sinopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //
        require_once __DIR__.'/htmlpurifier-4.13.0/library/HTMLPurifier.auto.php';

        $dirty_html = $contenido ?? '';
        $config = \HTMLPurifier_Config::createDefault();

        // Habilitar la opci??n de embeber v??deos de YouTube
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
        $contenido = $purifier->purify($dirty_html);
        //
        if ( empty( $contenido)) {
            $this->errores['contenido'] = 'El contenido no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        }
        $etiquetas='';
        $etiquetas=trim($datos['etiquetas'] ?? '');//aun no es requerido implementarlo
        //Imagen
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];    
        
        
        $folder = RUTA_IMGS."/".$filename;
        //print($folder);
        //print($tempname);
        if (count($this->errores) === 0) {
            // Now let's move the uploaded image into the folder: image
            if($filename==NULL){
                        if(isset($this->idNoticia)){
                            $noticiass = Noticia::actualiza($this->idNoticia, $titulo, $subtitulo, $filename, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas);
                        }else{
                            $this->errores['uploadfile'] =  "Imagen no seleccionada";
                        }
            }else{
                if (move_uploaded_file($tempname, $folder)){
                        if(isset($this->idNoticia)){
                            $noticiass = Noticia::actualiza($this->idNoticia, $titulo, $subtitulo, $filename, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas);
                        }else{
                            $noticiass = Noticia::crea($titulo, $subtitulo, $filename, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas,NULL);
                        
                        }
                }else{
                    $this->errores['uploadfile'] =  "Failed to uploadd image";
                }
            }
               

            } 
    }
}