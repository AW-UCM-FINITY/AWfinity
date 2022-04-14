<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorEditEpisodio extends Formulario
{
    private $id_serie;
    private $temporada;

    public function __construct($id_serie, $temporada) {
        $this->id_serie = $id_serie;
        $this->temporada = $temporada;
        parent::__construct('FormEditorEditEpisodio', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'serieVista.php?id_serie='.$this->id_serie]);
        


    }
    
    protected function generaCamposFormulario(&$datos)
    {

        //creamos
        $titulo = $datos['titulo'] ?? '';
        $duracion = $datos['duracion'] ?? '';
        $sinopsis = $datos['sinopsis'] ?? '';
        $uploadfile = $datos['uploadfile'] ?? '';
        
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'duracion', 'sinopsis', 'uploadfile'], $this->errores, 'span', array('class' => 'error'));


        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos añadir un nuevo episodio</legend>
            <div>
                <label for="titulo">Titulo del episodio:</label>
                <input id="titulo" type="text" name="titulo" value="$titulo" />
                {$erroresCampos['titulo']}
            </div>
            <input type="hidden" name ="id_serie" value="$this->id_serie" />
            <input type="hidden" name ="temporada" value="$this->temporada" />
            <div>
                <label for="duracion">Duracion (min):</label>
                <input id="duracion" type="number" name="duracion" value="$duracion" />
                {$erroresCampos['duracion']}
            </div>
            <div>
                <label for="sinopsis">Sinopsis:</label>
                <textarea rows= 5 cols= 50 name="sinopsis" value="" required>$sinopsis</textarea>
                {$erroresCampos['sinopsis']}
            </div>

            <div>
                <label for="video">Fichero de video:</label>
                <input type="file" name="uploadfile"/>
                {$erroresCampos['uploadfile']}
            </div>
             
            <div>
                <button type="submit" name="crear">Añadir</button>
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

        $duracion = trim($datos['duracion'] ?? '');
        $duracion = filter_var($duracion, FILTER_SANITIZE_NUMBER_INT);
        if ( ! $duracion || $duracion < 1 ) {
            $this->errores['duracion'] = 'La duracion de la pelicula tiene que ser mayor que 0 minutos.';
        }
        
        $sinopsis = trim($datos['sinopsis'] ?? '');
       

        //video
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];  
        $folder = RUTA_IMGS."/episodios/".$filename;
        //$folder_video = RUTA_IMGS_EPI."/video/videogenerico.mp4";


        
        if (count($this->errores) === 0) {
            if($filename != NULL){
                // Now let's move the uploaded image into the folder: image
                if (move_uploaded_file($tempname, $folder)){
                    $episodio = Episodio::buscaEpisodio($titulo, $this->id_serie);
            
                    if ($episodio) {
                        $this->errores[] = "El episodio ya existe";
                    } else {
                        $episodio = Episodio::crea($this->id_serie, $titulo, $duracion, $this->temporada, $sinopsis, $folder);                
                    }
                }
                else{
                    $this->errores['uploadfile'] =  "Failed to upload image";
                }

            }


        }   
     return null;      
    }     //cierro procesa form
}  //cierro class


?>
