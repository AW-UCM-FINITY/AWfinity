<?php
namespace es\ucm\fdi\aw;

class FormEditorEditNoticia extends Formulario
{
    private $idNoticia;

    public function __construct($idNoticia) {
        // en funcion de si le esta pasando el id de la Noticia, va a ser crear o modificar
        $this->idNoticia = $idNoticia;
        
        if(isset($this->idNoticia)){
            
            parent::__construct('FormEditorEditNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' => 'blogVista.php?tituloid='.$this->idNoticia]);  //por ahora queda mas claro asi
        }
        else{
            parent::__construct('FormEditorCreaNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' => 'blog.php']);
        }
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        if(isset($this->idNoticia)){
            //modifica la noticia
            $noticia=Noticia::buscaNoticiaID($this->idNoticia);

            $titulo = $noticia->getTitulo() ?? '';
            $subtitulo = $noticia->getSubtitulo() ?? '';
            $contenido = $noticia->getContenido() ?? '';
            $fecha = $noticia->getFechaPublicacion() ?? '';
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
            $fecha = $datos['fecha'] ?? '';
            $autor = $datos['autor'] ?? '';
            $categoria = $datos['categoria'] ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';
            $etiquetas = $datos['etiquetas']?? ''; 
        }
        //Categoria
        $categorias = Noticia::getCategoriaNoticia();
        $selectNoticia = "<select class='noticia_categoria' name=categoria>" ;
        foreach ($categorias as $key => $value) {
            $selectNoticia.="<option value=$key> $value </option> ";

        }
        $selectNoticia.="</select>";

        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'subtitulo', 'contenido', 'fecha', 'autor','categoria', 'uploadfile'], $this->errores, 'span', array('class' => 'error'));

        if(isset($this->idNoticia)){
            $funcionalidad = "modificación";
            $textoBoton = "modificar";
        } 
        else{
            $funcionalidad = "creación";
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
                <label for="fecha">Fecha (dd/mm/aa):</label>
                <input id="fecha" type="date" name="fecha" value="$fecha" required />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <label for="categoria">Categoria:</label>
                
                $selectNoticia 
                
                
            </div>
            <div>
                <label for="contenido">Contenido:</label>
                <textarea rows=5 cols=50 name="contenido" required>{$contenido}</textarea>
                {$erroresCampos['contenido']}
            </div>
            <div>
                <label for="imagen">Fichero de imagen:</label>
                <input type="file" name="uploadfile" value="" />
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
                
                if(isset($this->idNoticia)){
                    $noticiass = Noticia::actualiza($this->idNoticia, $titulo, $subtitulo, $filename, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas);
                }
                else{
                    $noticiass = Noticia::crea($titulo, $subtitulo, $filename, $contenido, $fechaPublicacion, $autor,$categoria,$etiquetas,NULL);
                }
              /*  if($noticiass){
                    $this->errores['uploadfile'] =  "Image uploaded successfully";
                }else{
                    $this->errores['uploadfile'] = "Error no se ha metido la noticia";
                }
                */
            }else{
                $this->errores['uploadfile'] =  "Failed to upload image";
            }
        }
    }
}