<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Noticias';
$claseArticle = 'FormEditNoticia';

$id_noticia = isset($_GET['idnoticia']) ? htmlspecialchars(trim(strip_tags($_GET["idnoticia"]))) : 0;


$formN = new path\FormEditorEditNoticia($id_noticia);
$htmlFormEditNoticia = $formN->gestiona();


$contenidoPrincipal = '';
if (!esEditor()){//Funcion de archivo includes/helpers/autorizacion.php
	$contenidoPrincipal .= <<< EOS
	<h1>Acceso denegado!</h1>
	<p>No tienes permisos suficientes para editar el contenido de la web.</p>
	EOS;
}else{
	$sidebar = "si";
	$contenidoPrincipal .= <<< EOS
	<div class = "edicion-panel">
	<h1>Consola de Edición de Contenido</h1>
	<p>Aquí estarían todos los controles de edición del contenido</p>
	$htmlFormEditNoticia
	</div>
	EOS;
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>