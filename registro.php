<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw as path;


$tituloPagina = 'Registro';
$claseArticle = 'Registro';

$form = new path\FormularioRegistro();
$htmlFormRegistro = $form->gestiona();

$contenidoPrincipal = "";

$contenidoPrincipal .= "<div class='login'>";
$contenidoPrincipal .= "<h1>Registro de usuario</h1>";
$contenidoPrincipal .= "$htmlFormRegistro";
$contenidoPrincipal .= "</div>";


require __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>

