<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Películas';
$claseArticle = 'editPeli';

$formC = new path\FormEditorCreaPeli();
$htmlFormCreaPeli = $formC->gestiona();

$formP = new path\FormEditorElimPeli();
$htmlFormElimPeli = $formP->gestiona();


$contenidoPrincipal = '';
if (! isset($_SESSION['esEditor']) || !$_SESSION['esEditor']){
	$contenidoPrincipal .= <<< EOS
	<h1>Acceso denegado!</h1>
	<p>No tienes permisos suficientes para editar el contenido de la web.</p>
	EOS;
}else{
	$sidebar = "si";
	$contenidoPrincipal .= <<< EOS
	<h1>Consola de Edición de Contenido</h1>
	<p>Aquí estarían todos los controles de edición del contenido</p>
	$htmlFormElimPeli
	$htmlFormCreaPeli
	EOS;
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>