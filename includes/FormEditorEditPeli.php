<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorEditPeli extends Formulario
{
    private $id_pelicula;

    public function __construct($id_pelicula) {

        $this->id_pelicula = $id_pelicula;
        
        if(isset($this->id_pelicula)){ //si existe el id -> actualizamos
            
            parent::__construct('FormEditorEditPeli', ['enctype' => 'multipart/form-data','urlRedireccion' => 'peliVista.php?id_pelicula='.$this->id_pelicula]);  
        }
        else{   //sino -> creamos
            parent::__construct('FormEditorEditPeli', ['enctype' => 'multipart/form-data','urlRedireccion' => 'contenidoPelis.php']);
        }


    }
    
    protected function generaCamposFormulario(&$datos)
    {

        if(isset($this->id_pelicula)){ //si existe el id -> actualizamos
            //buscamos la pelicula para obtener atributos
            $peli= path\Pelicula::buscapeliID($this->id_pelicula);

            $titulo = $peli->getTitulo() ?? '';
            $director = $peli->getDirector() ?? '';
            $duracion = $peli->getDuracion() ?? '';
            $genero = $peli->getGenero() ?? '';
            $sinopsis = $peli->getSinopsis() ?? '';
            //$ruta_imagen = $peli->getRutaImagen() ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';       
           
        }else{  //creamos
            $titulo = $datos['titulo'] ?? '';
            $director = $datos['director'] ?? '';
            $duracion = $datos['duracion'] ?? '';
            $genero = $datos['genero'] ?? '';
            $sinopsis = $datos['sinopsis'] ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';
            //$ruta_imagen = NULL;

        }

        //Generos
        $peli = path\Pelicula::getGenerosPeli();
        $selectPeli = "<select class='peli_genero' name='genero'>" ;
        foreach ($peli as $key => $value) {
            $selectPeli.="<option> $value </option> ";

        }
        $selectPeli.="</select>";

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'director', 'duracion', 'genero', 'sinopsis','uploadfile'], $this->errores, 'span', array('class' => 'error'));

        if(isset($this->id_pelicula)){
            $funcionalidad = "modificación";
            $textoBoton = "Modificar";
        } 
        else{
            $funcionalidad = "creación";
            $textoBoton = "Crear";
        }

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro la $funcionalidad de Película</legend>
            <div>
                <label for="titulo">Titulo de la pelicula:</label>
                <input id="titulo" type="text" name="titulo" value="$titulo" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="director">Director:</label>
                <input id="director" type="text" name="director" value="$director" />
                {$erroresCampos['director']}
            </div>
            <div>
                <label for="duracion">Duracion (min):</label>
                <input id="duracion" type="number" name="duracion" value="$duracion" />
                {$erroresCampos['duracion']}
            </div>
            <div>
                <label for="genero">Genero:</label>
                $selectPeli 
            </div>
            <div>
                <label for="sinopsis">Sinopsis:</label>
                <textarea rows= 5 cols= 50 name="sinopsis" value="" required>$sinopsis</textarea>
                {$erroresCampos['sinopsis']}
            </div>
            <div>
                <label for="imagen">Fichero de imagen:</label>
                <input type="file" name="uploadfile"/>
                {$erroresCampos['uploadfile']}
            </div>
            <div>
                <button type="submit" name="modificar">$textoBoton</button>
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
            $this->errores['titulo'] = 'El nombre de la pelicula tiene que tener una longitud de al menos 5 caracteres.';
        }

        $director = trim($datos['director'] ?? '');
        $director = filter_var($director, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $director || mb_strlen($director) < 5) {
            $this->errores['nombre'] = 'El nombre del director tiene que tener una longitud de al menos 5 caracteres.';
        }

        $duracion = trim($datos['duracion'] ?? '');
        $duracion = filter_var($duracion, FILTER_SANITIZE_NUMBER_INT);
        if ( ! $duracion || $duracion < 1 ) {
            $this->errores['duracion'] = 'La duracion de la pelicula tiene que ser mayor que 0 minutos.';
        }
        
        $genero = trim($datos['genero'] ?? '');
        // if ( empty( $genero)) {
        //     $this->errores['genero'] = 'El genero no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        // }

        $sinopsis = trim($datos['sinopsis'] ?? '');
        //$sinopsis = filter_var($sinopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //
        if ( empty( $sinopsis)) {
            $this->errores['sinopsis'] = 'El sinopsi no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        }

        //Imagen
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];    
        
        $folder = RUTA_IMGS."/pelis/".$filename;

        if (count($this->errores) === 0) {
            // Now let's move the uploaded image into the folder: image
            if (move_uploaded_file($tempname, $folder)){
                
                if(isset($this->id_pelicula)){//existe la pelicula
                    $peli = path\Pelicula::actualiza($this->$id_pelicula, $titulo, $director, $duracion, $genero, $sinopsis, $folder);
                }
                else{//no existe la peli
                    $peli = path\Pelicula::crea($titulo, $director, $duracion, $genero, $sinopsis, $folder);                
                }
            }else{
                $this->errores['uploadfile'] =  "Failed to upload image";
            }    
        }   
           
    }     //cierro procesa form
}  //class
//<div>
// <label for="imagen">Fichero de imagen:</label>
// <img class="imgEdit" src="{$ruta_imagen}" alt="Portada">
// <input type="file" name="uploadfile" value="$ruta_imagen" />
// {$erroresCampos['uploadfile']}
// </div>

?>
