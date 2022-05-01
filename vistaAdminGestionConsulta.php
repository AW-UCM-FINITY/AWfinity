<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'gestionConsulta';

$contenidoPrincipal = '';



$contenidoPrincipal .= <<<EOS
<div class="header2">
                                <h2>Gestión consultas</h2>
                                </div>
                                <div class="menublog">
          
                                <a class="active" href="./vistaAdminGestionUser.php">Usuarios</a>
                                <a  href="./vistaAdminGestionConsulta.php">Consultas</a>
                                <a  href="./vistaAdminApariencia.php">Apariencia</a>
                                
                                </div>
                                <div class="contened">
                                <div class="wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Motivo</th>
                                            <th>Consulta</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
EOS;

$contactos= Contacto::getTodosContactos();

        $cont=0;
        foreach($contactos as $us){
                $contenidoPrincipal .=<<<EOS
                <tr>
                <td class="nombre">{$us->getNombre()}</td>
                <td class="correo">{$us->getEmail()}</td>
                <td class="motivo">{$us->getMotivo()}</td>
                <td class="consulta">{$us->getConsulta()}</td>
                EOS;

                $formU[$cont]= new FormAdminElimConsulta($us->getIdConsulta());
                $htmlFormEditorElimUsuario[$cont]= $formU[$cont]->gestiona();


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