<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'gestionConsulta';

$contenidoPrincipal = '';

//-----------------------------------PAGINACION--------------------------------

$enlaceSiguiente ="";
$enlaceAnterior = "";
$pagTotal = "";
$numPorPagina = 6; //Define los grupos por página que haya


if(isset($_GET['numPagina'])){ 
  $contact = Contacto::getNumContactos();

  $numPagina = $_GET['numPagina'];
  // mostrar el boton siguiente cuando hay más retos
  if($contact > $numPorPagina * ($numPagina +1)){ 
      $numPagina++;
      $ruta= "vistaAdminGestionConsulta.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=$ruta> > </a></div>";
      $numPagina--;
  }
  // si no es la primera pagina mostrar la pagina anterior
  if($numPagina >0){
      $numPagina--;
      $ruta= "vistaAdminGestionConsulta.php?numPagina=".$numPagina;
      $enlaceAnterior = "<div class='butonGeneral'><a href=$ruta> < </a></div>";
      $numPagina++;
  }
}
else{
  $contact = Contacto::getNumContactos();
  $numPagina = 0;
   // mostrar el boton siguiente cuando hay más retos
  if($contact > $numPorPagina){ 
      $numPagina++; 
      $ruta= "vistaAdminGestionConsulta.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=$ruta> > </a></div>";
      $numPagina--;
  }
}

$numPagTotal = intval($contact/$numPorPagina);
if(($contact%$numPorPagina)!==0){
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
                                    <h1>Consultas</h1>
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
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Motivo</th>
                                            <th>Consulta</th>
                                            <th>Fecha</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
EOS;

$contactos= Contacto::getTodosContactos($numPagina, $numPorPagina);

        $cont=0;
        foreach($contactos as $us){
                $contenidoPrincipal .=<<<EOS
                <tr>
                <td class="nombre">{$us->getNombre()}</td>
                <td class="correo">{$us->getEmail()}</td>
                <td class="motivo">{$us->getMotivo()}</td>
                <td class="consulta">{$us->getConsulta()}</td>
                <td class="fecha">{$us->getFecha()}</td>
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

$contenidoPrincipal.= "<div class=\"buttonPanel\">";
$contenidoPrincipal.= $enlaceAnterior;
$contenidoPrincipal.= $pagTotal;
$contenidoPrincipal.= $enlaceSiguiente;
$contenidoPrincipal.= "</div>";



require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>