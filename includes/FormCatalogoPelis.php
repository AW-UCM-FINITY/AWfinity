<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormCatalogoPelis extends Formulario
{

    public function __construct() {
        parent::__construct('FormCatalogoPelis', []);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $html = "";
        $genero = $datos['genero'] ?? '';
        $catalogo = $datos['catalogo'] ?? '';
        //Opciones posibles
        $arrayGeneros = path\Pelicula::getGenerosPeli(); //Obtenemos todos los generos disponibles
        $selectPeli = "<select class='peli_genero' name='genero'>" ;
        $selectPeli.="<option selected> Catálogo </option> ";
        foreach ($arrayGeneros as $key => $genero) {
            $selectPeli.="<option selected> $genero </option> ";
        }
        $selectPeli.="</select>";

        $html .= "$selectPeli";
        $html .= "<button type='submit' name='buscar'>Buscar</button>";
       
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // $result = array();
        $result = "";
        $genero = trim($datos['genero'] ?? '');

        $catalogo = trim($datos['catalogo'] ?? '');
        
        if($catalogo != NULL){

            $result .= "contenidoPelis.php?opcion=0";
            

        }else{
            $result .= "contenidoPelis.php?opcion=$genero";
          

        }
        
        return $result;    
    }     //cierro procesa form
}  //cierro class


?>
