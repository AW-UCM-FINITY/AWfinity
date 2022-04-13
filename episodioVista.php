<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$id_episodio = isset($_GET['id_episodio']) ? htmlspecialchars(tr
(strip_tags($_GET["id_episodio"]))) : 0;

 
$episodio = path\Episodio::buscaEpisodioId($id_episodio);
$titulo = $episodio->getTitulo();

$formP = new path\FormEditorElimEpisodio($id_episodio);
$htmlFormElimEpisodio = $formP->gestiona();


$duracion = $episodio->getDuracion();
$id_serie = $episodio->getId_serie();
$titulo = $episodio->getTitulo();
$temporada= $episodio->getTemporada();
$sinopsis= $episodio->getSinopsis();
$ruta_video = $episodio->getRutaVideo();
$cadena_video = substr($ruta_video,2);

$tituloPagina = 'Episodio';
$claseArticle = 'vistaEpisodio';
$contenidoPrincipal = "";

$contenidoPrincipal .= "<div class='peli-card' id ='peli-card'>";

$contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";

$contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Temporada:  </strong>$temporada</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Duracion:  </strong>$duracion  minutos</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Video: </strong>
<video width='400' controls>
  <source src='$cadena_video' type='video/mp4'>
  Your browser does not support the video tag.
</video></div>";

$contenidoPrincipal .= "</div>"; //fin div = peli-datos-card

$contenidoPrincipal .= "</div>"; //fin div = peli-card


if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true && $_SESSION['esEditor']==true){
  
    $contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";
    $contenidoPrincipal .="$htmlFormElimEpisodio";
    $contenidoPrincipal .= "</div>"; //fin div = peli-editar

}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>