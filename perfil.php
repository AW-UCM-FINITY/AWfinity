<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Ranking TOP usuarios';
$claseArticle = 'Ranking';

$contenidoPrincipal = '';


if(isset($_SESSION['nombreUsuario']) && estaLogado()){

    $us=Usuario::buscaUsuario($_SESSION['nombreUsuario']);


$contenidoPrincipal .= <<<EOS
<div class="header2">
<h2>Usuario</h2>
</div>
                               
<div class="contened">
<div class="wrapper">
    <table>
        <thead>
            <tr>
                <th>Atributo</th>
                <th>Valor</th>
                         
                                            
            </tr>
        </thead>
        <tbody> 

            <tr>
            <td class="nombre">Nombre usuario</td>
            <td class="points">{$_SESSION['nombreUsuario']}</td>
                                
            </tr>
            <tr>
            <td class="nombre">Nombre</td>
            <td class="points">{$us->getNombre()}</td>
                                
            </tr>
            <tr>
            <td class="nombre">Apellidos</td>
            <td class="points">{$us->getApellido()}</td>
                                
            </tr>
            <tr>
            <td class="nombre">Puntos</td>
            <td class="points">{$us->getPuntos()}</td>
                                
            </tr>
EOS;

$rol='';
if(esEditor()){
$rol="Editor";
}else{
if(esAdmin()){
    $rol="Administrador";
}else{
    $rol="Usuario";
}
}
$contenidoPrincipal .= <<<EOS

<tr>
<td class="nombre">Rol</td>
<td class="points">{$rol}</td>
                    
</tr>
        </tbody>
	</table>
</div>
</div>
      
EOS;


  
   
  
}else{
   
$contenidoPrincipal .= <<<EOS
<h2> No hay nada que mostrar</h2>
EOS;
}


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>