<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Página Inicial';
$contenidoPrincipal = "";
$claseArticle = 'index';

// $contenidoPrincipal .= <<< EOS
// <section class ="bloque-area">	
// 	<h1> AWfinity </h1>	
// 	<h2> Página principal </h2>
// 	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
// </section>
// EOS;

$contenidoPrincipal .= "<div class='vistaPrincipal'> ";

$contenidoPrincipal .= "<div class='contenedorPrincipal'> ";

$contenidoPrincipal .= "<div class='tituloPrincipal'> ";
$contenidoPrincipal .= "<h3>Interestellar</h3>";
$contenidoPrincipal .= "</div> "; //cierre div tituloPrincipal

$contenidoPrincipal .= "<div class='descripcionPrincipal'> ";
$contenidoPrincipal .= "<p>
Narra las aventuras de un grupo de exploradores que hacen uso de un agujero de gusano recientemente descubierto para superar las limitaciones de los viajes espaciales tripulados y vencer las inmensas distancias que tiene un viaje interestelar.
</p>";
$contenidoPrincipal .= "</div> "; //cierre div descripcionPrincipal

$contenidoPrincipal .= "<div class='botonInfo'>";
$contenidoPrincipal .= "<div role='button' class='boton'>Más información</div>";
$contenidoPrincipal .= "</div> "; //cierre div botonInfo

$contenidoPrincipal .= "</div> "; //cierre div contenedorPrincipal
$contenidoPrincipal .= "</div> "; //cierre div vistaPrincipal


$contenidoPrincipal .= "<div class='peliculas-recomendadas'>";

$contenidoPrincipal .= "<div class='contenedor-titulo-controles'>";
$contenidoPrincipal .= "<h3>Películas Recomendadas</h3>";
$contenidoPrincipal .= "<div class='indicadores'></div>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-titulo-controles

$contenidoPrincipal .= "<div class='contenedor-principal'>";
$contenidoPrincipal .= "<button role='button' id='flecha-izquierda' class='flecha-izquierda'><i class='fas fa-angle-left'></i></button>";

$contenidoPrincipal .= "<div class='contenedor-carousel'>";
$contenidoPrincipal .= "<div class='carousel'>";
$arrayPeliculas = path\Pelicula::getPeliculas();
foreach ($arrayPeliculas as $key => $peli) {
	$ruta = $peli->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$id_pelicula = $peli->getId();
	$contenidoPrincipal .= "<div class='pelicula'>";
	$contenidoPrincipal .= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img alt='imgPeli' src=$ruta></a>";
	$contenidoPrincipal .= "</div> "; //cierre div pelicula
}

$contenidoPrincipal .= "</div> "; //cierre div carousel
$contenidoPrincipal .= "</div> "; //cierre div contenedor-carousel

$contenidoPrincipal .= "<button role='button' id='flecha-derecha' class='flecha-derecha'><i class='fas fa-angle-right'></i></button>;";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-principal

$contenidoPrincipal .= "</div> "; //cierre div peliculas-recomendadas


$contenidoPrincipal .= "<script src='https://kit.fontawesome.com/2c36e9b7b1.js' crossorigin='anonymous'></script>";
$contenidoPrincipal .= "<script src='js/main.js'></script>";


require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>
