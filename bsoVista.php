<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';

use es\ucm\fdi\aw as path;

/**
 * ESTA FUNCIONALIDAD ESTÁ EN PROCESO
 *  
 *  No funciona la playlist (no nos pasa de canción)
 * 
 */


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
$contenidoPrincipal .= "<div class='arriba'>";
if(esEditor()){
    $contenidoPrincipal .="<div class='botonCreaBSO'> <div class ='butonGeneral'> <a href='creaCancion.php?id_bso=$id_bso'> Añadir Canción</a> </div></div>";
}
$contenidoPrincipal .= "<div class='audio'>";
$contenidoPrincipal.= "
<audio id='player' src='img/canciones/generico.mp3' controls>
  Parece que el navegador no soporta el audio
</audio>";
$contenidoPrincipal .= "</div>";//cierra div audio
$contenidoPrincipal .= "</div>";//cierra div arriba

$contenidoPrincipal .= "<div class='ListaCanciones'>";
$contenidoPrincipal.= "<ul id='playlist'>";


// $contenidoPrincipal.= " <li class='current-song'><a href='https://upload.wikimedia.org/wikipedia/commons/9/9b/Queryen_-_DEMO_-_002_%281995%29_-_011_-_Flying_To_Tunis_%2830sec%29.ogg'>Canción 1</a></li>";
// $contenidoPrincipal.= " <li><a href='https://upload.wikimedia.org/wikipedia/en/7/79/Micromoog_Demo.ogg'>Canción 2</a></li>";
// $contenidoPrincipal.= " <li><a href='https://ccrma.stanford.edu/~jos/mp3/gtr-nylon22.mp3'>Canción 3</a></li>";


if($numCanciones > 0){
  $arrayNombreCanciones;
  $arrayRutaCanciones;
  foreach ($playList as $key => $cancion) {
      $arrayNombreCanciones[] = $cancion->getNombreCancion();
      $arrayRutaCanciones[] = $cancion->getRutaAudio();
  }
  $contenidoPrincipal.= "<li class='current-song'><a href='$arrayRutaCanciones[0]'> $arrayNombreCanciones[0] </a></li>";
  for($i = 1; $i < $numCanciones; $i++) {
      $contenidoPrincipal.= "<li><a href='$arrayRutaCanciones[$i]'> $arrayNombreCanciones[$i] </a></li>";
  }

  // foreach ($playList as $key => $cancion) {
  //     $nombre_cancion = $cancion->getNombreCancion();
  //     $ruta_audio = $cancion->getRutaAudio();
  //     $contenidoPrincipal.= "<li><a href='$ruta_audio'> $nombre_cancion </a></li>";
  // }
  $contenidoPrincipal .= "</ul>";

  $contenidoPrincipal .= "</div>"; //cierra div ListaCanciones
  $contenidoPrincipal .= "</div>"; //cierra div canciones

  $contenidoPrincipal .= "<script type='text/javascript' src='js/playlist.js'> </script>";
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>