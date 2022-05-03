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

$tituloPagina = 'Banda Sonora';
$claseArticle = 'vistaBSO';
$contenidoPrincipal = "";

if(estaLogado()){
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
    <audio id='player' src='' controls>
      Parece que el navegador no soporta el audio
    </audio>";
  $contenidoPrincipal .= "</div>";//cierra div audio
  $contenidoPrincipal .= "</div>";//cierra div arriba
  
  $contenidoPrincipal .= "<div class='ListaCanciones'>";
  $contenidoPrincipal.= "<ul id='playlist'>";
  
  
  if($numCanciones > 0){
    $arrayNombreCanciones;
    $arrayRutaCanciones;
    $arrayIdCanciones;
    foreach ($playList as $key => $cancion) {
        $arrayNombreCanciones[] = $cancion->getNombreCancion();
        $arrayRutaCanciones[] = $cancion->getRutaAudio();
        $arrayIdCanciones[]= $cancion->getId();
        $arrayFormulario[] = new path\FormEditorElimCancion($cancion->getId(), $id_bso);//funciona regulinchi
    }
    $contenidoPrincipal.= "<li class='current-song'><a href='$arrayRutaCanciones[0]'> $arrayNombreCanciones[0] </a></li>";
    
    if(esEditor()){
      $formP = new path\FormEditorElimCancion($arrayIdCanciones[0], $id_bso);
      $htmlFormElimCancion = $formP->gestiona();
      $contenidoPrincipal.= "<div class ='generalBoton'> $htmlFormElimCancion </div>";
    }
    for($i = 1; $i < $numCanciones; $i++) {
      $contenidoPrincipal.= "<li><a href='$arrayRutaCanciones[$i]'> $arrayNombreCanciones[$i] </a></li>";  
      if(esEditor()){
        // $formP = new path\FormEditorElimCancion($arrayIdCanciones[$i], $id_bso);
        $htmlFormElimCancion = $arrayFormulario[$i]->gestiona();
        $contenidoPrincipal.= "<div class ='generalBoton'> $htmlFormElimCancion </div>";
      }
    }
  
    // foreach ($playList as $key => $cancion) {
    //     $nombre_cancion = $cancion->getNombreCancion();
    //     $ruta_audio = $cancion->getRutaAudio();
    //     $contenidoPrincipal.= "<li><a href='$ruta_audio'> $nombre_cancion </a></li>";
    // }
    $contenidoPrincipal .= "</ul>";
  
    $contenidoPrincipal .= "</div>"; //cierra div ListaCanciones
    $contenidoPrincipal .= "</div>"; //cierra div canciones
  
    $contenidoPrincipal .= "<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'></script>";
    $contenidoPrincipal .= "<script type='text/javascript' src='js/playlist.js'> </script>";
  }
}
else{ //No es un usuario registrado -> no puede acceder a las vistas de pelis/series/bso/blog/etc

  $contenidoPrincipal .= "<div class='avisoLog'>";
  $contenidoPrincipal .= "<h1> Usuario no registrado </h1>";
  $contenidoPrincipal .= "<h3> Debes iniciar sesión para ver el contenido. </h3>";
  $contenidoPrincipal .=" <div class='butonGeneral'><a href='login.php'> Login </a> </div>";
  $contenidoPrincipal .= "</div>"; //fin div = avisoLog

}



require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>