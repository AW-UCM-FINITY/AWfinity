<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Nueva Películas';
$claseArticle = 'creaPeli';

//$id_pelicula = isset($_GET['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_GET["id_pelicula"]))) : 0;


$formC = new path\FormEditorEditPeli(NULL);
$htmlFormCreaPeli = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<h1>Consola de Creación de Peliculas</h1>
$htmlFormCreaPeli
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>