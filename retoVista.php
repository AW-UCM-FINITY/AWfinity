<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Reto';
$claseArticle = 'RetoAll';
$valr =isset($_GET['search']) ? htmlspecialchars(trim(strip_tags($_GET["search"]))) : 0;

$contenidoPrincipal = '';

$contenidoPrincipal .=<<<EOS
          <div class="header2">
            <h2>Retos</h2>
EOS;

// cuando es editor muestra el boton para crear blog
if(esEditor()){
  $contenidoPrincipal.=<<<EOS

    <div class='butonGeneral'> <a href='creaReto.php'> Crear </a> </div>
EOS;
}

$contenidoPrincipal.=<<<EOS
          </div>
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
  $retos=Reto::getRetos();
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
                    $contenidoPrincipal.= "<div class=\"aceptadoReto\"><p>Completa tu reto</p></div>";
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

EOS;
require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>