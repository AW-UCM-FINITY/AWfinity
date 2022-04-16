<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$id_bso = isset($_GET['id_bso']) ? htmlspecialchars(trim(strip_tags($_GET["id_bso"]))) : 0;

 
$bso= path\BSO::buscaBSOID($id_bso);
$titulo = $bso->getTitulo();

$formP = new path\FormEditorElimBSO($id_bso);
$htmlFormElimBSO = $formP->gestiona();

$formP = new path\FormEditorCreaCancion($id_bso);
$htmlFormCrearCancion = $formP->gestiona();


$compositor = $bso->getCompositor();
$numCanciones = $bso->getNumCanciones();
$genero = $bso->getGenero();
$sinopsis= $bso->getSinopsis();
$ruta = $bso->getRutaImagen();
$cadena = substr($ruta,2);

$playList = path\Cancion::getCanciones($id_bso);
//$default_song = $playList[0]->getRutaAudio();

$tituloPagina = 'Banda Sonora';
$claseArticle = 'vistaBSO';
$contenidoPrincipal = "";

$contenidoPrincipal .= "<div class='peli-card' id ='peli-card'>";

$contenidoPrincipal .= "<div class='derecha'>";
$contenidoPrincipal .= "<div class='peli-foto-card' id ='peli-foto'> <img alt='imgPeli' src=$cadena /> </div>";

if(esEditor()){
  
  $contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";

  $contenidoPrincipal .="<div class ='generalBoton'> $htmlFormElimBSO </div>";
  $contenidoPrincipal .=" <div class='butonGeneral'><a href='editBSO.php?id_bso=$id_bso'> Editar </a> </div>";
  $contenidoPrincipal .= "</div>"; //fin div = peli-editar

}
$contenidoPrincipal .= "</div>"; //cierra div derecha

$contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";

$contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Compositor:  </strong>$compositor</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Número de Canciones:  </strong>$numCanciones  canciones</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Genero:  </strong>$genero</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";

$contenidoPrincipal .= "</div>"; //fin div = peli-datos-card
$contenidoPrincipal .= "</div>"; //fin div = peli-card

$contenidoPrincipal .= "<div class='canciones'>";
if(esEditor()){
    $contenidoPrincipal .="<div class ='butonGeneral'> <a href='creaCancion.php?id_bso=$id_bso'> Añadir Canción</a> </div>";
}
$contenidoPrincipal .= "<div class='playlist'>";
$contenidoPrincipal.= "
    <audio id ='audio' preload='auto' tabindex='0' controls >
        <source src='img/canciones/generico.mp3'>
    </audio>";
$contenidoPrincipal.= "<ul id='playlist'>";
foreach ($playList as $key => $cancion) {
$nombre_cancion = $cancion->getNombreCancion();
$ruta_audio = $cancion->getRutaAudio();
$contenidoPrincipal.= "<li class='active'><a href='$ruta_audio'> $nombre_cancion </a></li>";
}


$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

$contenidoPrincipal .= "<script type='text/javascript' src='/js/playlist.js'></script>";

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>