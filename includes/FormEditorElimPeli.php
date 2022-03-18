<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimPeli extends Formulario
{
    private $id_pelicula;
    //parametro id_pelicula
    public function __construct($id_pelicula) {
        parent::__construct('FormEditorElimPeli', ['urlRedireccion' => 'contenidoPelis.php']);//por ahora queda mas claro asi
        $this->id_pelicula = $id_pelicula;
    }

    
    protected function generaCamposFormulario(&$datos)
    {

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        //input type hidden
       // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <div>
            <input type="hidden" name ="eliminarPeli" value="$this->id_pelicula" />
            <button type="submit" name="eliminar">Eliminar</button>
        </div>
           
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos) //le llega el selectPeli
    {
        // $titulo = trim($datos['titulo'] ?? '');
        // = trim($datos['id_pelicula'] ?? '');
        //no restamos porque con el . salimos de la carpeta include y con la / vamos a img/...etc
        //$ruta2 = substr($ruta,2); //restamos
        

        $borrar = path\Pelicula::eliminarPelicula($this->id_pelicula); //realmente le esta pasando el id
        

       //$vuelta = 'edit.php';

      // return $vuelta;
    }
}

