<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Nueva Banda Sonora';
$claseArticle = 'creaBSO';


$formC = new path\FormEditorEditBSO(NULL);
$htmlFormCreaBSO = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<div class = "edicion-panel">
<h1>Consola de Creación de Bandas Sonoras</h1>
$htmlFormCreaBSO
</div>
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>