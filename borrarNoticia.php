<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Borrar Noticia';
$claseArticle = 'borrarNoticia';




$contenidoPrincipal = '';
if (! isset($_SESSION['esEditor']) || !$_SESSION['esEditor']){
	$contenidoPrincipal .= <<< EOS
	<h1>Acceso denegado!</h1>
	<p>No tienes permisos suficientes para editar el contenido de la web.</p>
	EOS;
}else{
	$sidebar = "si";
    $resul = path\Noticia::eliminarNoticia($_GET['tituloid']);
    if($resul){
        $contenidoPrincipal .= <<<EOS
        <h1>Consola de Edición de Contenido</h1>
        <p>HAS BORRADO LA NOTICIA CORRECTAMENTE</p>
        
        EOS;
    }else{
        $contenidoPrincipal .= <<< EOS
	<h1>Consola de Edición de Contenido</h1>
	<p> NO HAS BORRADO LA NOTICIA CORRECTAMENTE</p>
	
	EOS;
    }
	
}

require __DIR__. '/includes/vistas/plantillas/plantillaEditor.php';
?>