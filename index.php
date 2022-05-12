<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Página Inicial';
$contenidoPrincipal = "";
$claseArticle = 'index';

$contenidoPrincipal .= "<div class='vistaPrincipal'> ";
$contenidoPrincipal .= "<div class='contenedorPrincipal'> ";
$contenidoPrincipal .= "<div class='tituloPrincipal'> ";
$contenidoPrincipal .= "<h3><span>AW</span>finity</h3>";
$contenidoPrincipal .= "</div> "; //cierre div tituloPrincipal
$contenidoPrincipal .= "<div class='descripcionPrincipal'> ";
$contenidoPrincipal .= "<p>
AWfinity es un espacio para disfrutar de todas tus películas, series y bandas sonoras favoritas. 
Puedes compartir con nosotros noticias del mundo cinematográfico y apuntarte a increíbles retos.
No esperes más, regístrate y comienza la aventura.
</p>";
$contenidoPrincipal .= "</div> "; //cierre div descripcionPrincipal
$contenidoPrincipal .= "<div class='botonInfo'>";
$contenidoPrincipal .= "<div class='boton'><a href=\"".RUTA_APP."/contacto.php\" ><i class='fas icon-info'></i>Más información</a></div>";
$contenidoPrincipal .= "</div> "; //cierre div botonInfo
$contenidoPrincipal .= "</div> "; //cierre div contenedorPrincipal
$contenidoPrincipal .= "</div> "; //cierre div vistaPrincipal

/**------------------PELICULAS RECOMENDADAS-------------------------------------------- */
$contenidoPrincipal .= "<div class='peliculas-recomendadas'>";
$contenidoPrincipal .= "<div class='contenedor-titulo-controles'>";
$contenidoPrincipal .= "<h3>Películas Recomendadas</h3>";
$contenidoPrincipal .= "<div class='indicadores'></div>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-titulo-controles

$contenidoPrincipal .= "<div class='contenedor-principal'>";
$contenidoPrincipal .= "<button role='button' id='flecha-izquierda' class='flecha-izquierda'><i class='fas icon-circle-left'></i></button>";

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

$contenidoPrincipal .= "<button role='button' id='flecha-derecha' class='flecha-derecha'><i class='fas icon-circle-right'></i></button>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-principal

$contenidoPrincipal .= "</div> "; //cierre div peliculas-recomendadas


/**--------------SERIES RECOMENDADAS--------------------------------------------- */
$contenidoPrincipal .= "<div class='series-recomendadas'>";
$contenidoPrincipal .= "<div class='contenedor-titulo-controles-serie'>";
$contenidoPrincipal .= "<h3>Series Recomendadas</h3>";
$contenidoPrincipal .= "<div class='indicadores-serie'></div>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-titulo-controles

$contenidoPrincipal .= "<div class='contenedor-principal-serie'>";
$contenidoPrincipal .= "<button role='button' id='flecha-izquierda-serie' class='flecha-izquierda-serie'><i class='fas icon-circle-left'></i></button>";

$contenidoPrincipal .= "<div class='contenedor-carousel-serie'>";
$contenidoPrincipal .= "<div class='carousel-serie'>";
$arraySeries = path\Serie::getSeries();
foreach ($arraySeries as $key => $serie) {
	$ruta = $serie->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$id_serie = $serie->getId();
	$contenidoPrincipal .= "<div class='serie'>";
	$contenidoPrincipal .= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$ruta></a>";
	$contenidoPrincipal .= "</div> "; //cierre div serie
}
$contenidoPrincipal .= "</div> "; //cierre div carousel
$contenidoPrincipal .= "</div> "; //cierre div contenedor-carousel-serie

$contenidoPrincipal .= "<button role='button' id='flecha-derecha-serie' class='flecha-derecha-serie'><i class='fas icon-circle-right'></i></button>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-principal

$contenidoPrincipal .= "</div> "; //cierre div peliculas-recomendadas

/**---------------------BANDAS SONORAS RECOMENDADAS--------------------------------------------------------- */
$contenidoPrincipal .= "<div class='peliculas-recomendadas'>";
$contenidoPrincipal .= "<div class='contenedor-titulo-controles'>";
$contenidoPrincipal .= "<h3>Bandas Sonoras Recomendadas</h3>";
$contenidoPrincipal .= "<div class='indicadores-bso'></div>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-titulo-controles

$contenidoPrincipal .= "<div class='contenedor-principal'>";
$contenidoPrincipal .= "<button role='button' id='flecha-izquierda-bso' class='flecha-izquierda-bso'><i class='fas icon-circle-left'></i></button>";

$contenidoPrincipal .= "<div class='contenedor-carousel-bso'>";
$contenidoPrincipal .= "<div class='carousel'>";
$arrayBSO = path\BSO::getBSO();
foreach ($arrayBSO as $key => $bso) {
	$ruta = $bso->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$id_bso = $bso->getId();
	$contenidoPrincipal .= "<div class='bso'>";
	$contenidoPrincipal .= "<a href=\"".RUTA_APP."/bsoVista.php?id_bso=$id_bso\"><img alt='imgBSO' src=$ruta></a>";
	$contenidoPrincipal .= "</div> "; //cierre div pelicula
}
$contenidoPrincipal .= "</div> "; //cierre div carousel
$contenidoPrincipal .= "</div> "; //cierre div contenedor-carousel

$contenidoPrincipal .= "<button role='button' id='flecha-derecha-bso' class='flecha-derecha-bso'><i class='fas icon-circle-right'></i></button>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-principal

$contenidoPrincipal .= "</div> "; //cierre div peliculas-recomendadas

/**--------------------BLOG------------------------------------------------- */
$contenidoPrincipal .= "<div class='peliculas-recomendadas'>";
$contenidoPrincipal .= "<div class='contenedor-titulo-controles'>";
$contenidoPrincipal .= "<h3>Actualízate con nuestras noticias</h3>";
$contenidoPrincipal .= "<div class='indicadores-blog'></div>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-titulo-controles

$contenidoPrincipal .= "<div class='contenedor-principal'>";
$contenidoPrincipal .= "<button role='button' id='flecha-izquierda-blog' class='flecha-izquierda-blog'><i class='fas icon-circle-left'></i></button>";

$contenidoPrincipal .= "<div class='contenedor-carousel-blog'>";
$contenidoPrincipal .= "<div class='carousel'>";
$arrayNoticias = path\Noticia::getNoticias();
foreach ($arrayNoticias as $key => $noticia) {
	$imgNoticia = $noticia->getImagenNombre();
	$tituloNoticia = $noticia->getTitulo();
	$id_noticia = $noticia->getIdNoticia();
	$contenidoPrincipal .= "<div class='blog'>";
	$contenidoPrincipal .= "<a href=\"".RUTA_APP."/blogVista.php?tituloid=$id_noticia\"><img alt='imgBSO' src=img/$imgNoticia></a>";
	$contenidoPrincipal .= "<h5>$tituloNoticia </h5>";
	$contenidoPrincipal .= "</div> "; //cierre div pelicula
}
$contenidoPrincipal .= "</div> "; //cierre div carousel
$contenidoPrincipal .= "</div> "; //cierre div contenedor-carousel

$contenidoPrincipal .= "<button role='button' id='flecha-derecha-blog' class='flecha-derecha-blog'><i class='fas icon-circle-right'></i></button>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-principal

$contenidoPrincipal .= "</div> "; //cierre div peliculas-recomendadas

/*------------------RETOS---------------------------------- */
$contenidoPrincipal .= "<div class ='retos'> ";
$contenidoPrincipal .= "<h1>Apúntate a nuestros <a href=\"".RUTA_APP."/retoVista.php\"><span>Retos</span></a></h1>";
$contenidoPrincipal .= "<div></div>";
$contenidoPrincipal .= "</div> "; 

$contenidoPrincipal .= "<script src='js/main.js'></script>";
$contenidoPrincipal .= "<script src='js/mainSeries.js'></script>";
$contenidoPrincipal .= "<script src='js/mainBSO.js'></script>";
$contenidoPrincipal .= "<script src='js/mainBlog.js'></script>";

require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>
