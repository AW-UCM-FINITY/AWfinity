<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'gestionUser';

$contenidoPrincipal = '';

//-----------------------------------PAGINACION--------------------------------

$enlaceSiguiente ="";
$enlaceAnterior = "";
$pagTotal = "";
$numPorPagina = 6; //Define los grupos por página que haya


if(isset($_GET['numPagina'])){ 
  $user = Usuario::getNumUsuarios();

  $numPagina = $_GET['numPagina'];
  // mostrar el boton siguiente cuando hay más retos
  if($user > $numPorPagina * ($numPagina +1)){ 
      $numPagina++;
      $ruta= "vistaAdminGestionUser.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=$ruta> > </a></div>";
      $numPagina--;
  }
  // si no es la primera pagina mostrar la pagina anterior
  if($numPagina >0){
      $numPagina--;
      $ruta= "vistaAdminGestionUser.php?numPagina=".$numPagina;
      $enlaceAnterior = "<div class='butonGeneral'><a href=$ruta> < </a></div>";
      $numPagina++;
  }
}
else{
  $user = Usuario::getNumUsuarios();
  $numPagina = 0;
   // mostrar el boton siguiente cuando hay más retos
  if($user > $numPorPagina){ 
      $numPagina++; 
      $ruta= "vistaAdminGestionUser.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=$ruta> > </a></div>";
      $numPagina--;
  }
}

$numPagTotal = intval($user/$numPorPagina);
if(($user%$numPorPagina)!==0){
  $numPagTotal = $numPagTotal+1;
}
$numPaginaAux=$numPagina+1;
if($numPagTotal!==1){
  $pagTotal = "<p> $numPaginaAux / $numPagTotal</p>";
}


//-----------------------------------FIN PAGINACION--------------------------------


$contenidoPrincipal .= <<<EOS
                              <div class="encabezado encabezado-bg">
                              <div class="tituloIndex">
                                  <h1>Gestión de Usuario</h1>
                              </div>
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

$usuarios= Usuario::pagina($numPagina,$numPorPagina);

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

$contenidoPrincipal.= "<div class=\"buttonPanel\">";
$contenidoPrincipal.= $enlaceAnterior;
$contenidoPrincipal.= $pagTotal;
$contenidoPrincipal.= $enlaceSiguiente;
$contenidoPrincipal.= "</div>";


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>