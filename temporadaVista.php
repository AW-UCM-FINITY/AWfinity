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
$contenidoPrincipal .= "<div>
<h3>Todos los episodios de la <span>$temporada</span> temporada de la serie <span>$titulo</span></h3>
</div>";

// Boton para añadir episodio
if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true && $_SESSION['esEditor']==true){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaEpisodio.php?id_serie=$id_serie&temporada=$temporada'> Añadir Episodio</a> </div>";
	
}
//$contenidoPrincipal = "</div>";



// Lista los episodios
$arrayEpisodios = path\Episodio::listaEpisodios($id_serie, $temporada);

$contenidoPrincipal .= "<div>";
foreach ($arrayEpisodios as $key => $episodio) {
    $tituloEp = $episodio->getTitulo();
    $duracionEp = $episodio->getDuracion();
    $id_episodio = $episodio->getId();
	
	$contenidoPrincipal .= "<div> <a href='episodioVista.php?id_episodio=$id_episodio'> $tituloEp </a> ";
	
	
	$contenidoPrincipal .= "</div>";
	// if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true && $_SESSION['esEditor']==true){
	// 	$formP = new path\FormEditorElimEpisodio($id_episodio);
	// 	$htmlFormEliEpisodio = $formP->gestiona();
	// 	$contenidoPrincipal .= "$htmlFormEliEpisodio";
	// }
    
}
$contenidoPrincipal .= "</div>";



require __DIR__. '/includes/vistas/plantillas/plantilla.php';


?>