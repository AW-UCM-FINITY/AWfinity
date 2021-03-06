<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Episodio';
$claseArticle = 'editEpisodio';

$id_episodio = isset($_GET['id_episodio']) ? htmlspecialchars(trim(strip_tags($_GET["id_episodio"]))) : 0;
$id_serie = isset($_GET['id_serie']) ? htmlspecialchars(trim(strip_tags($_GET["id_serie"]))) : 0;
$temporada = isset($_GET['temporada']) ? htmlspecialchars(trim(strip_tags($_GET["temporada"]))) : 0;


$formC = new path\FormEditorEditEpisodio($id_serie, $temporada, $id_episodio);
$htmlFormEditEpisodio = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<div class = "edicion-panel">
<h1>Consola de Edición del episodio </h1>
$htmlFormEditEpisodio
</div>
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>