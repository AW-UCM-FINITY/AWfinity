<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorCreaNoticia extends path\Formulario
{
    public function __construct() {
        parent::__construct('FormEditorCreaNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' => 'creaNoticia.php']);//por ahora queda mas claro asi
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $titulo = $datos['titulo'] ?? '';
        $subtitulo = $datos['subtitulo'] ?? '';
        $contenido = $datos['contenido'] ?? '';
        $fecha = $datos['fecha'] ?? '';
        $autor = $datos['autor'] ?? '';
        $categoria = $datos['categoria'] ?? '';
        $uploadfile = $datos['uploadfile'] ?? '';
        $etiquetas = $datos['etiquetas']?? '';
        //Categoria
        $noticia = Noticia::getCategoriaNoticia();
        $selectNoticia = "<select class='noticia_categoria' name=categoria>" ;
        foreach ($noticia as $key => $value) {
            $selectNoticia.="<option value=$key> $value </option> ";

        }
        $selectNoticia.="</select>";


        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'subtitulo', 'contenido', 'fecha', 'autor','categoria', 'uploadfile'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro de nueva Noticia</legend>
            <div>
                <label for="titulo">Titulo de la noticia:</label>
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
                <label for="fecha">Fecha (dd/mm/aa):</label>
                <input id="fecha" type="text" name="fecha" value="{$fecha}" />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="categoria">Categoria:</label>
                
                $selectNoticia 
                
                
            </div>
            <div>
                <label for="contenido">Contenido:</label>
                <textarea rows= 5 cols= 50 name="contenido" value="" required> {$contenido}</textarea>
                {$erroresCampos['contenido']}
            </div>
            <div>
                <label for="imagen">Fichero de imagen:</label>
                <input type="file" name="uploadfile" value="" />
                {$erroresCampos['uploadfile']}
            </div>
            <div>
                <button type="submit" name="registro">Crear</button>
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
    
       $fechaPublicacion = filter_var($fechaPublicacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $fechaPublicacion  /*|| $fecha < */ ) {
            $this->errores['fecha'] = 'La fecha de publicacion tiene que ser mayor que 0 minutos.';
        }
        
        $categoria = trim($datos['categoria'] ?? '');
        // if ( empty( $genero)) {
        //     $this->errores['genero'] = 'El genero no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        // }

        $contenido = trim($datos['contenido'] ?? '');
        //$sinopsis = filter_var($sinopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //
        if ( empty( $contenido)) {
            $this->errores['contenido'] = 'El contenido no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        }
        $etiquetas='';
        $etiquetas=trim($datos['etiquetas'] ?? '');
        //Imagen
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];    
        
        
        $folder = RUTA_IMGS."/".$filename;
        //print($folder);
        //print($tempname);
        if (count($this->errores) === 0) {
            // Now let's move the uploaded image into the folder: image
            if (move_uploaded_file($tempname, $folder)){
                
                
                $noticiass = path\Noticia::crea($titulo, $subtitulo, $filename, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas);
                if($noticiass){
                    $this->errores['uploadfile'] =  "Image uploaded successfully";
                }else{
                    $this->errores['uploadfile'] = "Error no se ha metido la noticia";
                }
                
            }else{
                $this->errores['uploadfile'] =  "Failed to upload image";
            }
        }
    }
}