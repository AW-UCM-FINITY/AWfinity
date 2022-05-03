<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Editar Usuarios';
$claseArticle = 'editUser';

$nombreusuario = isset($_GET['nombreusuario']) ? htmlspecialchars(trim(strip_tags($_GET["nombreusuario"]))) : 0;

// se aprovecha esta vista para que cuando es administrador y quiere cambiar rol de otro usuario
if(esAdmin() && $_GET['nombreusuario'] !== $_SESSION['nombreUsuario']){
    $formC = new path\FormAdminCambiarRol($nombreusuario);
    $htmlFormAdminCambiarRol = $formC->gestiona();
    
    $contenidoPrincipal = '';
    
    $contenidoPrincipal .= <<< EOS
    <div class = "edicion-panel">
    <h1>Consola de Edición de Rol de Usuario</h1>
    $htmlFormAdminCambiarRol
    </div>
    EOS;
}
else{
// si el usuario no es administrador y quiere cambiar datos de perfil 
$formC = new path\FormEditorEditUsuario($nombreusuario);
$FormEditorEditUsuario = $formC->gestiona();

$contenidoPrincipal = '';

$contenidoPrincipal .= <<< EOS
<div class = "edicion-panel">
<h1>Consola de Edición de Usuario</h1>
$FormEditorEditUsuario
</div>
EOS;
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>