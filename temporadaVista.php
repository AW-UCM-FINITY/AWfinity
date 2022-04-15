<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$id_serie = isset($_GET['id_serie']) ? htmlspecialchars(trim(strip_tags($_GET["id_serie"]))) : 0;
$temporada = isset($_GET['temporada']) ? htmlspecialchars(trim(strip_tags($_GET["temporada"]))) : 0;

$serie = path\Serie::buscaSerieID($id_serie);
$titulo = $serie->getTitulo();


$tituloPagina = 'Serie - Temporada';
$claseArticle = 'vistaTemporada';
$contenidoPrincipal = "";


$contenidoPrincipal .= 
"<div class='tituloIndex'>
<h3>Todos los episodios de la <span>$temporada</span> temporada de la serie <span>$titulo</span></h3>";
    
if(esEditor()){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaEpisodio.php?id_serie=$id_serie&temporada=$temporada'> Añadir Episodio</a> </div>";
	
}
$contenidoPrincipal .= "</div>";


$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>Capítulos</h3> </div>";

// Lista los episodios
$arrayEpisodios = path\Episodio::listaEpisodios($id_serie, $temporada);

$contenidoPrincipal .= "<div class='listaCapitulos'>";
$contenidoPrincipal .= "<ol>";
foreach ($arrayEpisodios as $key => $episodio) {
    $tituloEp = $episodio->getTitulo();
    $duracionEp = $episodio->getDuracion();
    $id_episodio = $episodio->getId();
	$contenidoPrincipal .= "<li> <div class='butonGeneral'> <a href='episodioVista.php?id_episodio=$id_episodio'> $tituloEp </a> </div></li>";
}
$contenidoPrincipal .= "</ol>";
$contenidoPrincipal .= "</div>";



require __DIR__. '/includes/vistas/plantillas/plantilla.php';


?>