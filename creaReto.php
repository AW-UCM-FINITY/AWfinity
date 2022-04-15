<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor
use es\ucm\fdi\aw as path;

$tituloPagina = 'Crear Reto';
$claseArticle = 'FormCreaReto';

$formN = new path\FormEditorEditReto(NULL);
$htmlFormCreaReto = $formN->gestiona();


$contenidoPrincipal = '';
if (!esEditor()){
	$contenidoPrincipal .= <<< EOS
	<h1>Acceso denegado!</h1>
	<p>No tienes permisos suficientes para editar el contenido de la web.</p>
	EOS;
}else{
	$sidebar = "si";
	$contenidoPrincipal .= <<< EOS
	<h1>Consola de Edición de Contenido</h1>
	<p>Aquí estarían todos los controles de edición del contenido</p>
	$htmlFormCreaReto
	EOS;
	
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>