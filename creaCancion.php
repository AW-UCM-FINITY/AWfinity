<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Nuevo Episodio';
$claseArticle = 'creaEpisodio';


$id_bso = isset($_GET['id_bso']) ? htmlspecialchars(trim(strip_tags($_GET["id_bso"]))) : 0;

$formC = new path\FormEditorCreaCancion($id_bso);
$htmlFormCreaCancion = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<div class = "edicion-panel">
<h1>Consola de Creacion de Canciones</h1>
$htmlFormCreaCancion
</div>
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>