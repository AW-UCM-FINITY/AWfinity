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
        <div class="encabezado encabezado-bg">
        <div class="tituloIndex">
            <h1>Aparienca de la página</h1>
        </div>
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