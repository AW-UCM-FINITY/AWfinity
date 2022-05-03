<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorEditBSO extends Formulario
{
    private $id_bso;

    public function __construct($id_bso) {

        $this->id_bso = $id_bso;
       
        if(isset($this->id_bso)){ //si existe el id -> actualizamos
            
            parent::__construct('FormEditorEditBSO'.$id_bso, ['enctype' => 'multipart/form-data','urlRedireccion' => 'bsoVista.php?id_bso='.$this->id_bso]);  
        }
        else{   //sino -> creamos
            parent::__construct('FormEditorEditBSO', ['enctype' => 'multipart/form-data','urlRedireccion' => 'contenidoBSO.php']);
        }


    }
    
    protected function generaCamposFormulario(&$datos)
    {

        if(isset($this->id_bso)){ //si existe el id -> actualizamos
            //buscamos la pelicula para obtener atributos
            $bso= path\BSO::buscaBSOID($this->id_bso);            
            $titulo = $bso->getTitulo() ?? '';
            $compositor = $bso->getCompositor() ?? '';
            $genero = $bso->getGenero() ?? '';
            $sinopsis = $bso->getSinopsis() ?? '';
            $uploadfile = $bso->getRutaImagen() ?? '';

           
        }else{  //creamos
            $titulo = $datos['titulo'] ?? '';
            $compositor = $datos['compositor'] ?? '';
            $genero = $datos['genero'] ?? '';
            $sinopsis = $datos['sinopsis'] ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';
            //$ruta_imagen = NULL;

        }

        //Generos
        $bso = path\BSO::getGenerosBSO();
        $selectBSO = "<select class='peli_genero' name='genero'>" ;
        foreach ($bso as $key => $value) {
            if($value == $genero){
                $selectBSO.="<option selected> $value </option> ";
            }
            else{
                $selectBSO.="<option> $value </option> ";
            }
        }
        $selectBSO.="</select>";

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'compositor', 'numCanciones', 'genero', 'sinopsis','uploadfile', 'opcion', 'id_opcion'], $this->errores, 'span', array('class' => 'error'));

        if(isset($this->id_bso)){
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
            <legend>Datos para el registro la $funcionalidad de Bandas Sonoras</legend>
            <div>
                <label for="titulo">Titulo de la banda sonora:</label>
                <input id="titulo" type="text" name="titulo" value="$titulo" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="compositor">Compositor:</label>
                <input id="compositor" type="text" name="compositor" value="$compositor" />
                {$erroresCampos['compositor']}
            </div>
            <div>
                <label for="genero">Genero:</label>
                $selectBSO 
            </div>
            <div>
                <label for="sinopsis">Sinopsis:</label>
                <textarea rows= 5 cols= 50 name="sinopsis"  required>$sinopsis</textarea>
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
            $this->errores['titulo'] = 'El nombre de la banda sonora tiene que tener una longitud de al menos 5 caracteres.';
        }
        
        $compositor = trim($datos['compositor'] ?? '');
        $compositor = filter_var($compositor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $compositor || mb_strlen($compositor) < 5) {
            $this->errores['compositor'] = 'El nombre del compositor tiene que tener una longitud de al menos 5 caracteres.';
        }
        
        $genero = trim($datos['genero'] ?? '');
        // if ( empty( $genero)) {
        //     $this->errores['genero'] = 'El genero no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        // }

        $sinopsis = trim($datos['sinopsis'] ?? '');
        //$sinopsis = filter_var($sinopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //
        if ( empty( $sinopsis)) {
            $this->errores['sinopsis'] = 'La sinopsis no puede estar vacía';//para empezar lo dejamos asi, mas tarde en otra tabla
        }

        //Imagen
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];    

        $folder = RUTA_IMGS."/bso/".$filename;

        if (count($this->errores) === 0) {
            if($filename != NULL){
                // Now let's move the uploaded image into the folder: image
                if (move_uploaded_file($tempname, $folder)){
                    if(isset($this->id_bso)){//existe la pelicula
                        $bso= path\BSO::buscaBSOID($this->id_bso);
                        $bso->setTitulo($titulo);
                        $bso->setCompositor($compositor);
                        $bso->setGenero($genero);
                        $bso->setSinopsis($sinopsis);
                        $bso->setRutaImagen($folder);
                        $bso = path\BSO::actualiza($bso);
                    }
                    else{//no existe la peli
                        $bso = path\BSO::crea($titulo, $compositor, 0, $genero, $sinopsis, $folder);                
                    }
                }else{
                    $this->errores['uploadfile'] =  "Failed to upload image";
                }    
            }
            else{
                if(isset($this->id_bso)){//existe la pelicula
                    $bso= path\BSO::buscaBSOID($this->id_bso);
                    $bso->setTitulo($titulo);
                    $bso->setCompositor($compositor);
                    $bso->setGenero($genero);
                    $bso->setSinopsis($sinopsis);
                    $bso = path\BSO::actualiza($bso);
                }
                else{
                    $this->errores['uploadfile'] =  "Failed to upload image";
                }
            }
        }    
    }     //cierro procesa form
}  //class

?>
