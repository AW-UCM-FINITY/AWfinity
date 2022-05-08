<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Nueva Serie';
$claseArticle = 'creaSerie';

//$id_pelicula = isset($_GET['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_GET["id_pelicula"]))) : 0;


$formC = new path\FormEditorEditSerie(NULL);
$htmlFormCreaSerie = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<div class = "edicion-panel">
<h1>Consola de Creación de Series</h1>
$htmlFormCreaSerie
</div>
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>