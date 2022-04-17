<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorCreaCancion extends Formulario
{
    private $id_bso;

    public function __construct($id_bso) {
        $this->id_bso = $id_bso;
        parent::__construct('FormEditorEditEpisodio', ['enctype' => 'multipart/form-data', 'urlRedireccion' => 'contenidoBSO.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        //creamos
        $nombre = $datos['nombre'] ?? '';
        $uploadfile = $datos['uploadfile'] ?? '';
        
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'uploadfile'], $this->errores, 'span', array('class' => 'error'));


        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos añadir una nueva canción</legend>
            <div>
                <label for="nombre">Nombre de la canción:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="audio">Fichero de audio:</label>
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

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre de la cancion tiene que tener una longitud de al menos 5 caracteres.';
        }       

        //audio
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];  
        $folder = RUTA_IMGS."/canciones/".$filename;
        //$folder_video = RUTA_IMGS_EPI."/video/videogenerico.mp4";


        
        if (count($this->errores) === 0) {
            if($filename != NULL){
                // Now let's move the uploaded image into the folder: image
                if (move_uploaded_file($tempname, $folder)){
                    $cancion = Cancion::buscaCancion($nombre, $this->id_bso);
            
                    if ($episodio) {
                        $this->errores[] = "La canción ya existe";
                    } else {
                        $episodio = Cancion::crea($this->id_bso, $nombre, $folder);   
                        $actualiza = BSO::actualizaNumCanciones($id_bso); //para aumentar el numero de canciones q tiene la BSO             
                    }
                }
                else{
                    $this->errores['uploadfile'] =  "Failed to upload image";
                }
            }
        }       
    }     //cierro procesa form
}  //cierro class


?>
