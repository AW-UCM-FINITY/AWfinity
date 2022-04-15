<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Noticias';
$claseArticle = 'NoticiasAll';

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
          
          <a class="active" href="./retoVista.php">Retos</a>
          <a  href="./ranking.php">Ranking</a>
          <div class="barraBusca">
          <form action="/action_page.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit">Buscar</button>
          </form>
          </div>
          </div>
          <div class="columna">
            <div class="columnaIzq">
EOS;

$retos=Reto::getRetos();

if(!($retos==false)){
      foreach($retos as $ret){
        $contenidoPrincipal .=<<<EOS
                      
       
                           <div class="boxlay" onclick="location.href='./retoSingVist.php?retoid={$ret->getIdReto()}'">
                            
                            <h5>{$ret->getNombre()}</h5>
                         
                            <p>{$ret->getDescripcion()}</p>
                           
                            

                            
                        
          EOS;
          if(estaLogado()&& !esEditor() && !esAdmin()){
           
            if(UsuarioReto::compruebaCompletado($ret->getIdReto(), Usuario::buscaIDPorNombre($_SESSION['nombreUsuario']))){
              $contenidoPrincipal.= "<p>Completado</p>";
            }
            else{
              $contenidoPrincipal.= "<p>No Completado</p>";
            }
    
            
      }
      $contenidoPrincipal.= "</div>";
      }

  $contenidoPrincipal.=<<<EOS
                       </div>
                       
    EOS;
  
  
   
  
 

}
require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>