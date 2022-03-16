<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorElimNoticia extends path\Formulario
{

    private $idNoticia='';
    
    public function __construct($idNoticiaa) {
        parent::__construct('FormEditorElimNoticia', ['enctype' => 'multipart/form-data','urlRedireccion' => 'blog.php']);//por ahora queda mas claro asi
        $this->idNoticia=$idNoticiaa;
    }
    

    protected function generaCamposFormulario(&$datos){
        $html=<<<EOS
        <form id= action="./blog.php" method="POST">
        <input type="hidden" name="idNoticia" value="$idNoticia">
       
        <div>
        <button type="submit" name="BorrarNoticia">Borrar</button>
        </div>
        </form>
        EOS;
        
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $idnot = trim($datos['idNoticia'] ?? '');
        $idnot = filter_var($idnot, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $idnot) {
            $this->errores['titulo'] = 'El nombre de la noticia tiene que tener una longitud de al menos 5 caracteres.';
        }
       
                
                $noticiass = path\Noticia::eliminaNoticia($idnot);
                if($noticiass){
                    $this->errores['eliminaNoticia'] =  "Noticia borrada correctamente";
                }else{
                    $this->errores['eliminaNoticia'] = "Noticia no borrada correctamente";
                }
                
          
     }
}