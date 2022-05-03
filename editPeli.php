<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Películas';
$claseArticle = 'editPeli';

$id_pelicula = isset($_GET['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_GET["id_pelicula"]))) : 0;


$formC = new path\FormEditorEditPeli($id_pelicula);
$htmlFormEditPeli = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<div class = "edicion-panel">
<h1>Consola de Edición de Peliculas</h1>
$htmlFormEditPeli
</div>
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>