<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw as path;


$tituloPagina = 'Login';

$form = new path\FormularioLogin();
$htmlFormLogin = $form->gestiona();
$claseArticle = 'Login';

$contenidoPrincipal = <<<EOS
	<h1>Acceso al sistema</h1>
	{$htmlFormLogin['Contenido']}
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>

	