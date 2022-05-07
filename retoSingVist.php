<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Retos';
$claseArticle = 'Retos';// a finees de tener mismo diseño

$contenidoPrincipal = '';

if(estaLogado()){
  $contenidoPrincipal .=<<<EOS
            <div class="header2">
              <h2>Reto</h2>
            </div>
            <div class="menublog">
            
            <a class="active" href="./retoVista.php">Retos</a>
            <a  href="./ranking.php">Ranking</a>
            </div>
            <div class="columnaPelis">
          
  EOS;

  $id_reto =isset($_GET['retoid']) ? htmlspecialchars(trim(strip_tags($_GET["retoid"]))) : 0;


  $formP = new FormEditorElimReto($id_reto);
  $htmlFormElimReto = $formP->gestiona();



  $reto=Reto::buscarPorId($id_reto);
  if($reto){
  $suma=$reto->getNumMiembros();
  $numpelisreto=PelisReto::cuentasPelisPorReto($id_reto);
  $pelisretoArray=PelisReto::getPelisporReto($id_reto);
  $contenidoPrincipal .=<<<EOS
                        
                      
    <div class="cardRetoPelis">
      <h1>{$reto->getNombre()}</h1>
      
      <div></div>
      <h5> Descripción: {$reto->getDescripcion()}</h5>
      <h5> Duración: {$reto->getDias()} dias</h5>
      <h5> Dificultad: {$reto->getDificultad()} </h5>
      <h5> Puntos: {$reto->getPuntos()} </h5> 
      <h5> Participantes: {$suma} personas en este reto </h5>
      <h5> Han completado {$reto->getNumCompletado()} personas</h5>
  EOS;


  $contenidoPrincipal .="<div class='pelisIndex'>"; 
  $contenidoPrincipal .= "<div class='peliLista'>";
  $arrayPelis = $pelisretoArray;
  $contenidoPrincipal.="<div class=imgPelisRetoBlock>";
  foreach ($arrayPelis as $key => $value) {
    $id_pelicula = $value->getId();
    $ruta = $value->getRutaImagen();
    $cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
    $contenidoPrincipal.= "<div class=\"imgPelisReto\"> <a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula&idreto=$id_reto\"><img class=\"imgPelis\" alt='imgPeli' src=$cadena></a> </div>";
  }
  $contenidoPrincipal .= "</div></div>";
  $contenidoPrincipal .= "</div> <p> ESTE RETO TIENE ASOCIADO {$numpelisreto} PELICULAS </p>";

  // mostrar mensaje si no hay ningun pelis asociado al reto
  if($numpelisreto==0){
    $contenidoPrincipal .= "<div class=\"mensajeRojo\"><p> No se puede completar este reto hasta que el editor añade peliculas :( </p></div>";
  }

  $id_usuario = Usuario::buscaIDPorNombre($_SESSION['nombreUsuario']);

  // mostrar mensaje si el reto ya esta completado
  if(estaLogado() && !esEditor() && !esAdmin() && UsuarioReto::compruebaPerteneceReto($id_usuario,$id_reto) && UsuarioReto::compruebaCompletado($id_reto, $id_usuario)){
    $contenidoPrincipal .= "<div class=\"mensajeVerde\"><p> RETO YA COMPLETADO </p></div>";
  }
  $contenidoPrincipal .= "<div class=panelBotones> <div class='butonGeneral'> <a href='retoVista.php'> Volver </a> </div>";

  // si esta logado como usuario normal, puede elegir unirse o abandonar el reto
  if(estaLogado() && !esEditor() && !esAdmin()){


    if(!empty($id_usuario)){

    // si el usuario ya se ha unido al reto
    if(UsuarioReto::compruebaPerteneceReto($id_usuario,$id_reto)){

      // si el reto no esta completado puede o completar reto o abandonar el reto
      if(!UsuarioReto::compruebaCompletado($id_reto, $id_usuario)){
        $formD = new FormUserAbandonReto($id_usuario, $id_reto);
        $htmlFormAbandonReto = $formD->gestiona();
        $contenidoPrincipal .= $htmlFormAbandonReto;
      }
      
    }
    else{
    // si no esta dentro de reto, puede unirse
    
    $formJ = new FormUserJoinReto($id_usuario,$id_reto);
    $htmlFormJoinReto = $formJ->gestiona();
    $contenidoPrincipal .= $htmlFormJoinReto;
    }
    }
    else{
      echo "<p>Error en la muestra de opciones para usuario</p>";
    }
    $contenidoPrincipal .= "</div>";
  }
  // cuando es editor muestra los botones para editar y eliminar reto
  if(esEditor()){
    $contenidoPrincipal .=<<<EOS
    
    <div class='butonGeneral'> <a href='editReto.php?retoid={$id_reto}'> Editar </a> </div>

    $htmlFormElimReto
    
    EOS;
    
    $contenidoPrincipal .= "</div></div>";

  // Si esta logado como editor, permite añadir pelis al reto usando buscador de pelis

    $contenidoPrincipal .="<div class=\"cardPelis\">";
    if(!isset($_GET['busca'])){
    $formB = new FormEditorBuscaPelisReto($id_reto);
    $htmlFormBuscaPelis = $formB->gestiona();
    $contenidoPrincipal .= <<< EOS
      $htmlFormBuscaPelis
      </div>
      </div>
      EOS;
    }else{
      $formA = new FormEditorAddPelisReto($id_reto);
      $htmlFormAnadirPelis = $formA->gestiona();
      
      $contenidoPrincipal .= <<< EOS
      $htmlFormAnadirPelis
      </div>
      </div>
      EOS;
    }
    
    // destruir el array de pelis que se intercambia entre formB y formA.
    unset($_SESSION['array']); 

  }else{
    $contenidoPrincipal .= "</div></div>";
  }
  }else{
      echo "<p>Error en la muestra de retos</p>";
  }
}
else{ //No es un usuario registrado -> no puede acceder a las vistas de pelis/series/bso/blog/etc

  $contenidoPrincipal .= "<div class='avisoLog'>";
  $contenidoPrincipal .= "<h1> Usuario no registrado </h1>";
  $contenidoPrincipal .= "<h3> Debes iniciar sesión para ver el contenido. </h3>";
  $contenidoPrincipal .=" <div class='butonGeneral'><a href='login.php'> Login </a> </div>";
  $contenidoPrincipal .= "</div>"; //fin div = avisoLog

}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>