<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'gestionUser';

$contenidoPrincipal = '';



$contenidoPrincipal .= <<<EOS
<div class="header2">
                                <h2>Gestión usuarios</h2>
                                </div>
                                <div class="menublog">
          
                                <a class="active" href="./vistaAdminGestionUser.php">Gestión Usuario</a>
                                <a  href="./vistaAdminApariencia.php">Apariencia</a>
                                </div>
                                <div class="contened">
                                <div class="wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Rol</th>
                                            <th>Puntos</th>
                                            <th>Cambiar Rol</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
EOS;

$usuarios= Usuario::getTodosUsuarios();

        $cont=0;
        foreach($usuarios as $us){
                $contenidoPrincipal .=<<<EOS
                <tr>
                <td class="usuario">{$us->getNombreUsuario()}</td>
                <td class="nombre">{$us->getNombre()}</td>
                <td class="apellido">{$us->getApellido()}</td>
                <td class="rol">{$us->getRol()}</td>
                <td class="puntos">{$us->getPuntos()}</td>
                <td class="cambiar">
                EOS;

                $formU[$cont]= new FormEditorElimUsuario($us);
                $htmlFormEditorElimUsuario[$cont]= $formU[$cont]->gestiona();

                if(esAdmin() && $us->getRol()!=="admin"){

                $contenidoPrincipal .=<<<EOS
                    
                <div class='butonGeneral'> <a href='editUsuario.php?nombreusuario={$us->getNombreUsuario()}'> Cambiar </a> </div>
                    
                EOS;

                }

                $contenidoPrincipal .=<<<EOS
                </td>
                <td class="borrar">
                {$htmlFormEditorElimUsuario[$cont]}
                </td>
                </tr>
                EOS;
                $cont++;
        }	
                
$contenidoPrincipal.=<<<EOS
</tbody>
		</table>
		</div>
		</div>
      
EOS;


  
   
  
 


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>