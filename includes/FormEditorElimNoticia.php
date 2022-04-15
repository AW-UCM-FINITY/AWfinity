<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimNoticia extends path\Formulario
{

    private $idNoticia;
    
    public function __construct($idNoticiaa) {
        parent::__construct('FormEditorElimNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' => 'blog.php']);//por ahora queda mas claro asi
        $this->idNoticia=$idNoticiaa;
    }
    

    protected function generaCamposFormulario(&$datos){
        $html=<<<EOS
        <div>
            <input type="hidden" name="eliminarNoticia" value="$this->idNoticia" />
            <button type="submit" name="Eliminar">Eliminar</button>
        </div>
        EOS;
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        /*$this->errores = [];
        $idnot = trim($datos['idNoticia'] ?? '');
        $idnot = filter_var($idnot, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $idnot) {
            $this->errores['titulo'] = 'El nombre de la noticia tiene que tener una longitud de al menos 5 caracteres.';
        }*/
       
                
        $borrarNoticia = path\Noticia::eliminarNoticia($this->idNoticia);

          
     }
}