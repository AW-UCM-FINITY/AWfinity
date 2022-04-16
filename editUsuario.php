<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Usuarios';
$claseArticle = 'editUser';

$nombreusuario = isset($_GET['nombreusuario']) ? htmlspecialchars(trim(strip_tags($_GET["nombreusuario"]))) : 0;


$formC = new path\FormEditorEditUsuario($nombreusuario);
$FormEditorEditUsuario = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<h1>Consola de Edición de Usuario</h1>
$FormEditorEditUsuario
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>