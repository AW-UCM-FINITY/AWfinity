<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'gestionApariencia';

$contenidoPrincipal = '';

$rutaTemaDefault = RUTA_CSS."/default.css";
$rutaTemaAzul = RUTA_CSS."/azul.css";
$formm= new FormCambiaApariencia();
$FormCambiaApariencia= $formm->gestiona();
$contenidoPrincipal .= <<<EOS
<div class="header2">
        <h2>Apariencia página</h2>
        </div>
        <div class="menublog">
          
        <a class="active" href="./vistaAdminGestionUser.php">Usuarios</a>
        <a  href="./vistaAdminGestionConsulta.php">Consultas</a>
        <a  href="./vistaAdminApariencia.php">Apariencia</a>
        </div>
        
        <div class="card">
        <h1>Cambio de tema</h1>
		
        
		{$FormCambiaApariencia}
        
        </div>
                                
EOS;


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>