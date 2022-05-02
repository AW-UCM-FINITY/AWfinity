<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar BSO';
$claseArticle = 'editBSO';

$id_bso = isset($_GET['id_bso']) ? htmlspecialchars(trim(strip_tags($_GET["id_bso"]))) : 0;


$formC = new path\FormEditorEditBSO($id_bso);
$htmlFormEditBSO = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<h1>Consola de Edición de BSO</h1>
$htmlFormEditBSO
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>