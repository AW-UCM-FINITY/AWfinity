<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$id_pelicula = isset($_GET['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_GET["id_pelicula"]))) : 0;
//$id_pelicula = isset($_POST['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_POST["id_pelicula"]))) : $id_pelicula;

// $id_pelicula = $_GET['id_pelicula'];
//$id_pelicula = $_GET['id_pelicula'];
// print("este es el id");
 
$pelicula = path\Pelicula::buscaPeliID($id_pelicula);
$titulo = $pelicula->getTitulo();

$formP = new path\FormEditorElimPeli($id_pelicula);
$htmlFormElimPeli = $formP->gestiona();


$formP = new path\FormEditorEditPeli($id_pelicula);
$htmlFormEditPeli = $formP->gestiona();


// $formP = new path\FormEditorEditarPeli($titulo);
// $htmlFormEditarPeli = $formP->gestiona();

$duracion = $pelicula->getDuracion();
$director = $pelicula->getDirector();
$genero = $pelicula->getGenero();
$sinopsis= $pelicula->getSinopsis();
$ruta = $pelicula->getRutaImagen();
$cadena = substr($ruta,2);


$tituloPagina = 'Película';
$claseArticle = 'vistaPeli';
$contenidoPrincipal = "";

$contenidoPrincipal .= "<div class='peli-card' id ='peli-card'>";

$contenidoPrincipal .= "<div class='peli-foto-card' id ='peli-foto'> <img src=$cadena /> </div>";

$contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";

$contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Director:  </strong>$director</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Duracion:  </strong>$duracion  minutos</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Genero:  </strong>$genero</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";

$contenidoPrincipal .= "</div>"; //fin div = peli-datos-card

$contenidoPrincipal .= "</div>"; //fin div = peli-card


if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true){
  /*Lo que teniamos anteriormente */
    /*$contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";

    $contenidoPrincipal .=" <div class='editar-buton'> $htmlFormElimPeli </div>";
    $contenidoPrincipal .=" <div class='editar-buton'><a href='editPeli.php?id_pelicula=$id_pelicula'> Editar </a> </div>";
    $contenidoPrincipal .= "</div>"; //fin div = peli-editar

*/
    $contenidoPrincipal .=" <div class='editar-buton'> $htmlFormElimPeli </div>";
    $contenidoPrincipal.=<<<EOS
    <form action="./editPeli.php?id_pelicula=$id_pelicula" method="POST">
    <div>
    <button type="submit" name="editPeli">Editar</button>
    </div>
    </form>
  
  EOS;
  }

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>