<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Página Inicial';

$contenidoPrincipal = <<< EOS
<section class ="bloque-area">	
	<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
</section>
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>
