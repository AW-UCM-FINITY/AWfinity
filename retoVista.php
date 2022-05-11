<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Reto';
$claseArticle = 'RetoAll';
$valr =isset($_GET['search']) ? htmlspecialchars(trim(strip_tags($_GET["search"]))) : 0;

$contenidoPrincipal = '';

$contenidoPrincipal .= "<div class='encabezado encabezado-bg'> ";
$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1><span>Retos</span> ¿te apuntas? </h1>";
if(esEditor()){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaReto.php'> Nuevo Reto </a> </div>";
}
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg

// $contenidoPrincipal .=<<<EOS
//           <div class="header2">
//             <h2>Retos</h2>
// EOS;

// // cuando es editor muestra el boton para crear blog
// if(esEditor()){
//   $contenidoPrincipal.=<<<EOS

//     <div class='butonGeneral'> <a href='creaReto.php'> Crear </a> </div>
// EOS;
// }

//-----------------------------------PAGINACION--------------------------------

$enlaceSiguiente ="";
$enlaceAnterior = "";
$pagTotal = "";
$numPorPagina = 4; //Define los grupos por página que haya


if(isset($_GET['numPagina'])){ 
  $retos = Reto::getNumRetos();

  $numPagina = $_GET['numPagina'];
  // mostrar el boton siguiente cuando hay más retos
  if($retos > $numPorPagina * ($numPagina +1)){ 
      $numPagina++;
      $ruta= "retoVista.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=\"$ruta\"> > </a></div>";
      $numPagina--;
  }
  // si no es la primera pagina mostrar la pagina anterior
  if($numPagina >0){
      $numPagina--;
      $ruta= "retoVista.php?numPagina=".$numPagina;
      $enlaceAnterior = "<div class='butonGeneral'><a href=\"$ruta\"> < </a></div>";
      $numPagina++;
  }
}
else{
  $retos = Reto::getNumRetos();
  $numPagina = 0;
   // mostrar el boton siguiente cuando hay más retos
  if($retos > $numPorPagina){ 
      $numPagina++; 
      $ruta= "retoVista.php?numPagina=".$numPagina;
      $enlaceSiguiente = "<div class='butonGeneral'><a href=\"$ruta\"> > </a></div>";
      $numPagina--;
  }
}

$numPagTotal = intval($retos/$numPorPagina);
if(($retos%$numPorPagina)!==0){
  $numPagTotal = $numPagTotal+1;
}

$numPaginaAux=$numPagina+1;
if($numPagTotal!==1){
  $pagTotal = "<p> $numPaginaAux / $numPagTotal</p>";
}


//-----------------------------------FIN PAGINACION--------------------------------

$contenidoPrincipal.=<<<EOS
          <div class="menublog">
          
          <a class="active" href="retoVista.php">Retos</a>
          <a  href="./ranking.php">Ranking</a>
          <div class="barraBusca">
          <form action="retoVista.php" method="GET">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit">Buscar</button>
          </form>
          </div>
          </div>
          <div class="panelReto">
EOS;

if(isset($_GET['search'])){

  $retos=Reto::buscar($valr);
}else{
  $retos=Reto::pagina($numPagina, $numPorPagina);
}


if(!($retos==false)){
      foreach($retos as $ret){
        $contenidoPrincipal .=<<<EOS
                      
      <div class="boxlay" onclick="location.href='./retoSingVist.php?retoid={$ret->getIdReto()}'">
      <h3>{$ret->getNombre()}</h3>
      <p>{$ret->getDescripcion()}</p>
EOS;
      if($ret->getDificultad()==='FACIL'){
        $contenidoPrincipal.= "<img alt='' class=\"imagenNivel\" src=\"img/estrella1.png\">";
      }
      else if($ret->getDificultad()==='MEDIO'){
        $contenidoPrincipal.= "<img alt='' class=\"imagenNivel\" src=\"img/estrella1.png\"><img alt='' class=\"imagenNivel\" src=\"img/estrella1.png\">";
      }
      else{
        $contenidoPrincipal.= "<img alt='' class=\"imagenNivel\" src=\"img/estrella1.png\"><img alt='' class=\"imagenNivel\" src=\"img/estrella1.png\"><img alt='' class=\"imagenNivel\" src=\"img/estrella1.png\">";
      }
          if(estaLogado()&& !esEditor() && !esAdmin()){
           
                $idReto = $ret->getIdReto();
                $idUsuario = Usuario::buscaIDPorNombre($_SESSION['nombreUsuario']);
                if(UsuarioReto::compruebaCompletado($idReto, $idUsuario)){
                  $contenidoPrincipal.= "<div class=\"completadoReto\"><p class>¡ Completado !</p></div>";
                }
                else{
                  //$contenidoPrincipal.= "<p>No Completado</p>";
                  if(UsuarioReto::compruebaPerteneceReto($idUsuario,$idReto)){
                    $peliscompletado = PelisReto::contarPelisCompletadas($idUsuario,$idReto);
                    $pelistotales = count(PelisReto::getPelisporReto($idReto));
                    
                    $contenidoPrincipal.= "<div class=\"aceptadoReto\"><p>Completa tu reto </p>";
                    if($pelistotales!=0){
                    $contenidoPrincipal.= " <p>($peliscompletado / $pelistotales) </p>";
                    }
                    $contenidoPrincipal.= "</div>";
                    
                  }
                  else{
                    $contenidoPrincipal.= "<div class=\"unirseReto\"><p>Únete al reto</p></div>";
                  }
                }
    
            
          }
      $contenidoPrincipal.= "</div>";
      }


  
  
   
  
 

}else{
  $contenidoPrincipal.=<<<EOS
  <h2>         No hay retos que concuerden con su busqueda o no hay ningun reto registrado</h2>


EOS;
}
$contenidoPrincipal.=<<<EOS
</div>
<div class="buttonPanel">
EOS;


$contenidoPrincipal.= $enlaceAnterior;
$contenidoPrincipal.= $pagTotal;
$contenidoPrincipal.= $enlaceSiguiente;
$contenidoPrincipal.= "</div>";


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>