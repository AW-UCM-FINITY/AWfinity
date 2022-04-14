<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';

use es\ucm\fdi\aw as path;

$id_serie = isset($_GET['id_serie']) ? htmlspecialchars(trim(strip_tags($_GET["id_serie"]))) : 0;
//$id_serie = isset($_POST['id_serie']) ? htmlspecialchars(trim(strip_tags($_POST["id_serie"]))) : $id_serie;

// $id_serie = $_GET['id_serie'];
//$id_serie = $_GET['id_serie'];
// print("este es el id");
 
$serie = path\Serie::buscaSerieID($id_serie);
$titulo = $serie->getTitulo();

$formP = new path\FormEditorElimSerie($id_serie);
$htmlFormElimSerie = $formP->gestiona();


$productor = $serie->getProductor();
$genero = $serie->getGenero();
$numTemporadas = $serie->getNumTemporadas();
$sinopsis= $serie->getSinopsis();
$ruta = $serie->getRutaImagen();
$cadena = substr($ruta,2);


$tituloPagina = 'Serie';
$claseArticle = 'vistaSerie';
$contenidoPrincipal = "";

$contenidoPrincipal .= "<div class='peli-card' id ='peli-card'>";

$contenidoPrincipal .= "<div class='peli-foto-card' id ='peli-foto'> <img alt='imgPeli' src=$cadena /> </div>";

$contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";

$contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Productor:  </strong>$productor</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Temporadas:  </strong>$numTemporadas temporadas</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Genero:  </strong>$genero</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";
for($i = 1; $i <= $numTemporadas; $i++) {
    $contenidoPrincipal .=" <div class='butonGeneral'><a href='temporadaVista.php?id_serie=$id_serie&temporada=$i'> Temporada $i </a> </div>";
}

$contenidoPrincipal .= "</div>"; //fin div = peli-datos-card

$contenidoPrincipal .= "</div>"; //fin div = peli-card


if(esEditor()){
  
    $contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";

    $contenidoPrincipal .="{$htmlFormElimSerie['Contenido']}";
    $contenidoPrincipal .=" <div class='butonGeneral'><a href='editSerie.php?id_serie=$id_serie'> Editar </a> </div>";
    $contenidoPrincipal .= "</div>"; //fin div = peli-editar

  }

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>