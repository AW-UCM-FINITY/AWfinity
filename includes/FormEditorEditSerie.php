<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorEditSerie extends Formulario
{

    private $id_serie;

    public function __construct($id_serie) {

        $this->id_serie = $id_serie;
       
        if(isset($this->id_serie)){ //si existe el id -> actualizamos
            
            parent::__construct('FormEditorEditSerie', ['enctype' => 'multipart/form-data','urlRedireccion' => 'serieVista.php?id_serie='.$this->id_serie]);  
        }
        else{   //sino -> creamos
            parent::__construct('FormEditorEditSerie', ['enctype' => 'multipart/form-data','urlRedireccion' => 'contenidoSeries.php']);
        }
    }

    protected function generaCamposFormulario(&$datos)
    {

        if(isset($this->id_serie)){ //si existe el id -> actualizamos
            //buscamos la serie para obtener atributos
            $serie= path\Serie::buscaSerieID($this->id_serie);
            
            $titulo = $serie->getTitulo() ?? '';
            $productor = $serie->getProductor() ?? '';
            $numTemporadas = $serie->getNumTemporadas() ?? '';
            $genero = $serie->getGenero() ?? '';
            $sinopsis = $serie->getSinopsis() ?? '';
            $uploadfile = $serie->getRutaImagen() ?? '';
           
        }else{  //creamos
            $titulo = $datos['titulo'] ?? '';
            $productor = $datos['productor'] ?? '';
            $numTemporadas = $datos['numTemporadas'] ?? '';
            $genero = $datos['genero'] ?? '';
            $sinopsis = $datos['sinopsis'] ?? '';
            $uploadfile = $datos['uploadfile'] ?? '';
            //$ruta_imagen = NULL;

        }
        
        //Generos
        $serie = path\Serie::getGenerosSerie();
        $selectSerie = "<select class='serie_genero' name='genero'>" ;
        foreach ($serie as $key => $value) {
            if($value == $genero){
                $selectSerie.="<option selected> $value </option> ";
            }
            else{
                $selectSerie.="<option> $value </option> ";
            }
        }
        $selectSerie.="</select>";

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'productor', 'numTemporadas', 'genero', 'sinopsis','uploadfile'], $this->errores, 'span', array('class' => 'error'));

        if(isset($this->id_serie)){
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
            <legend>Datos para el registro la $funcionalidad de Serie</legend>
            <div>
                <label for="titulo">Titulo de la serie:</label>
                <input id="titulo" type="text" name="titulo" value="$titulo" />
                {$erroresCampos['titulo']}
            </div>
            <div>
                <label for="productor">Productor:</label>
                <input id="productor" type="text" name="productor" value="$productor" />
                {$erroresCampos['productor']}
            </div>
            <div>
                <label for="numTemporadas">Temporada:</label>
                <input id="numTemporadas" type="number" name="numTemporadas" value="$numTemporadas" />
                {$erroresCampos['numTemporadas']}
            </div>
            <div>
                <label for="genero">Genero:</label>
                $selectSerie 
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
            $this->errores['titulo'] = 'El nombre de la Serie tiene que tener una longitud de al menos 5 caracteres.';
        }
        
        $productor = trim($datos['productor'] ?? '');
        $productor = filter_var($productor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $productor || mb_strlen($productor) < 5) {
            $this->errores['productor'] = 'El nombre del productor tiene que tener una longitud de al menos 5 caracteres.';
        }

        $numTemporadas = trim($datos['numTemporadas'] ?? '');
        $numTemporadas = filter_var($numTemporadas, FILTER_SANITIZE_NUMBER_INT);
        if ( ! $numTemporadas || $numTemporadas < 1 ) {
            $this->errores['numTemporadas'] = 'La numTemporadas de la Serie tiene que ser mayor que 0 minutos.';
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

        $folder = RUTA_IMGS."/series/".$filename;

        if (count($this->errores) === 0) {
            if($filename != NULL){
                // Now let's move the uploaded image into the folder: image
                if (move_uploaded_file($tempname, $folder)){
                    if(isset($this->id_serie)){//existe la serie
                        $serie= path\Serie::buscaserieID($this->id_serie);
                        $serie->setTitulo($titulo);
                        $serie->setProductor($productor);
                        $serie->setNumTemporadas($numTemporadas);
                        $serie->setGenero($genero);
                        $serie->setSinopsis($sinopsis);
                        $serie->setRutaImagen($folder);
                        $serie = path\Serie::actualiza($serie);
                    }
                    else{//no existe la serie
                        $serie = path\Serie::crea($titulo, $productor, $numTemporadas, $genero, $sinopsis, $folder);                
                    }
                }else{
                    $this->errores['uploadfile'] =  "Failed to upload image";
                }    
            }
            else{
                if(isset($this->id_serie)){//existe la serie
                    $serie= path\Serie::buscaserieID($this->id_serie);
                    $serie->setTitulo($titulo);
                    $serie->setProductor($productor);
                    $serie->setNumTemporadas($numTemporadas);
                    $serie->setGenero($genero);
                    $serie->setSinopsis($sinopsis);
                    $serie = path\Serie::actualiza($serie);
                }
                else{
                    $this->errores['uploadfile'] =  "Failed to upload image";
                }
            }
        }     
    }     //cierro procesa form


}

?>