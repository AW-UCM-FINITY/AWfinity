<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$id_episodio = isset($_GET['id_episodio']) ? htmlspecialchars(trim(strip_tags($_GET["id_episodio"]))) : 0;

 
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


$contenidoPrincipal .= "<div class='derecha'>";
$contenidoPrincipal .= "<div class='peli-foto-card' id ='peli-foto'>
  <video controls>
  <source src='$cadena_video' type='video/mp4'>
  Your browser does not support the video tag.
  </video> 
</div>";

if(esEditor()){
  
  $contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";
  $contenidoPrincipal .="$htmlFormElimEpisodio";
  $contenidoPrincipal .= "</div>"; //fin div = peli-editar

}
$contenidoPrincipal .= "</div>"; //cierra div derecha

$contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";

$contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Temporada:  </strong>$temporada</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Duracion:  </strong>$duracion  minutos</div>";
$contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";

$contenidoPrincipal .= "</div>"; //fin div = peli-datos-card

$contenidoPrincipal .= "</div>"; //fin div = peli-card

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>