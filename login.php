<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw as path;


$tituloPagina = 'Login';

$form = new path\FormularioLogin();
$htmlFormLogin = $form->gestiona();
$claseArticle = 'Login';

$contenidoPrincipal = "";

$contenidoPrincipal .= "<div class='login'>";
$contenidoPrincipal .= "<h1>Acceso al sistema</h1>";
$contenidoPrincipal .= "$htmlFormLogin";
$contenidoPrincipal .= "</div>";


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>

	