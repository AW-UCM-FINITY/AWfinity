<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Ranking TOP usuarios';
$claseArticle = 'Ranking';

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
      $ruta= "ranking.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=\"$ruta\"> > </a></div>";
      $numPagina--;
  }
  // si no es la primera pagina mostrar la pagina anterior
  if($numPagina >0){
      $numPagina--;
      $ruta= "ranking.php?numPagina=".$numPagina;
      $enlaceAnterior = "<div class='butonGeneral'><a href=\"$ruta\"> < </a></div>";
      $numPagina++;
  }
}
else{
  $user = Usuario::getNumUsuarios();
  $numPagina = 0;
   // mostrar el boton siguiente cuando hay más retos
  if($user > $numPorPagina){ 
      $numPagina++; 
      $ruta= "ranking.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=\"$ruta\"> > </a></div>";
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
<h1>Ranking</h1>
</div>
</div>
<div class="menublog">

<a class="active" href="./retoVista.php">Retos</a>
<a  href="./ranking.php">Ranking</a>
</div>
<div class="contened">
<div class="wrapper">
<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Retos completados</th>
            <th>Puntos</th>
            
        </tr>
    </thead>
    <tbody> 
EOS;

$usuarios= Usuario::getUsuariosOrdenPuntos($numPagina,$numPorPagina);

        foreach($usuarios as $us){
                $contenidoPrincipal .=<<<EOS
                <tr>
                <td class="nombre">{$us->getNombre()}</td>
                        
                EOS;

                $retoscompl=UsuarioReto::retosCompletadosPorUser($us->getId());
                $contenidoPrincipal.=<<<EOS
                <td class="team">{$retoscompl}</td>
                <td class="points">{$us->getPuntos()}</td>
                                
                </tr>
                EOS;
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