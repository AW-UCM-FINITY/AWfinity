<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'gestionApariencia';

$contenidoPrincipal = '';

$rutaTemaDefault = RUTA_CSS."/default.css";
$rutaTemaAzul = RUTA_CSS."/azul.css";

$contenidoPrincipal .= <<<EOS
<div class="header2">
        <h2>Apariencia página</h2>
        </div>
        <div class="menublog">
          
        <a class="active" href="./vistaAdminGestionUser.php">Gestión Usuario</a>
        <a  href="./vistaAdminApariencia.php">Apariencia</a>
        </div>
        <div class="contened">
        <h1>Página sencilla para decorar con estilos</h1>
		
        <p>Tema</p>

		<button type="button" onclick="cambiarCSS('{$rutaTemaDefault}')">rosa</button>
		<button type="button" onclick="cambiarCSS('{$rutaTemaAzul}')">azul</button>
        </div>
                                
EOS;//<img src="img/temadefault.png"/>


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>