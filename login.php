<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw as path;


$tituloPagina = 'Login';

$form = new path\FormularioLogin();
$htmlFormLogin = $form->gestiona();


$contenidoPrincipal = <<<EOS
	<h1>Acceso al sistema</h1>
	$htmlFormLogin
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>

	