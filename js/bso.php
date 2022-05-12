$contenidoPrincipal .= "<div class='peliculas-recomendadas'>";
$contenidoPrincipal .= "<div class='contenedor-titulo-controles'>";
$contenidoPrincipal .= "<h3>Bandas Sonoras Recomendadas</h3>";
$contenidoPrincipal .= "<div class='indicadores-blog'></div>";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-titulo-controles

$contenidoPrincipal .= "<div class='contenedor-principal'>";
$contenidoPrincipal .= "<button role='button' id='flecha-izquierda-blog' class='flecha-izquierda-blog'><i class='fas icon-circle-left'></i></button>";

$contenidoPrincipal .= "<div class='contenedor-carousel-blog'>";
$contenidoPrincipal .= "<div class='carousel'>";
$arrayBlog = path\Blog::getBlog();
foreach ($arrayBlog as $key => $blog) {
	$ruta = $blog->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$id_blog = $blog->getId();
	$contenidoPrincipal .= "<div class='blog'>";
	$contenidoPrincipal .= "<a href=\"".RUTA_APP."/blogVista.php?id_blog=$id_blog\"><img alt='imgBlog' src=$ruta></a>";
	$contenidoPrincipal .= "</div> "; //cierre div pelicula
}
$contenidoPrincipal .= "</div> "; //cierre div carousel
$contenidoPrincipal .= "</div> "; //cierre div contenedor-carousel

$contenidoPrincipal .= "<button role='button' id='flecha-derecha-blog' class='flecha-derecha-blog'><i class='fas icon-circle-right''></i></button>;";
$contenidoPrincipal .= "</div> "; //cierre div contenedor-principal

$contenidoPrincipal .= "</div> "; //cierre div peliculas-recomendadas
