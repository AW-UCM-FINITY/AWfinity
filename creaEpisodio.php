<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Nuevo Episodio';
$claseArticle = 'creaEpisodio';


$id_serie = isset($_GET['id_serie']) ? htmlspecialchars(trim(strip_tags($_GET["id_serie"]))) : 0;
$temporada = isset($_GET['temporada']) ? htmlspecialchars(trim(strip_tags($_GET["temporada"]))) : 0;

$formC = new path\FormEditorEditEpisodio($id_serie, $temporada);
$htmlFormCreaEpisodio = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<h1>Consola de Creacion de Episodios</h1>
$htmlFormCreaEpisodio
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>