<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Series';
$claseArticle = 'editSerie';

$id_serie = isset($_GET['id_serie']) ? htmlspecialchars(trim(strip_tags($_GET["id_serie"]))) : 0;


$formC = new path\FormEditorEditSerie($id_serie);
$htmlFormEditSerie = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<h1>Consola de Edición de Series</h1>
$htmlFormEditSerie
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>