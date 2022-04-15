<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Retos';
$claseArticle = 'Noticia';// a finees de tener mismo diseño

$contenidoPrincipal = '';

$contenidoPrincipal .=<<<EOS
          <div class="header2">
            <h2>Reto</h2>
          </div>
          <div class="menublog">
          
          <a class="active" href="./retoVista.php">Retos</a>
          <a  href="./ranking.php">Ranking</a>
          </div>
          <div class="columna">
         
EOS;

$id_reto =isset($_GET['retoid']) ? htmlspecialchars(trim(strip_tags($_GET["retoid"]))) : 0;


$formP = new FormEditorElimReto($id_reto);
$htmlFormElimReto = $formP->gestiona();



$reto=Reto::buscarPorId($id_reto);
if($reto){
$suma=$reto->getNumMiembros()+$reto->getNumCompletado();
$numpelisreto=PelisReto::cuentasPelisPorReto($id_reto);
$pelisretoArray=PelisReto::getPelisporReto($id_reto);
$contenidoPrincipal .=<<<EOS
                      
                     
  <div class="card">
    <h2>{$reto->getNombre()}</h2>
    
    <div></div>
    <h5> Este reto tiene una duración de {$reto->getDias()} dias y otorga {$reto->getPuntos()} puntos </h5>
    <h5> Actualmente hay {$suma} personas en el reto </h5> ;
    <h5> El reto tiene una dificultad {$reto->getDificultad()} </h5>
    <h5>El reto ha sido INICIADO POR: {$reto->getNumMiembros()} personas</h5>
    <h5>El reto ha sido COMPLETADO POR: {$reto->getNumCompletado()} personas</h5>
    
    <p>{$reto->getDescripcion()}</p>
    <p> </p>
    <p> ESTE RETO TIENE ASOCIADO {$numpelisreto} PELICULAS </p>
EOS;


$contenidoPrincipal .="<div class='pelisIndex'>"; 
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayPelis = $pelisretoArray;
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img alt='imgPeli' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

// cuando es editor muestra el boton para editar reto
if(esEditor()){
  $contenidoPrincipal .=<<<EOS
  
  <div class='butonGeneral'> <a href='editReto.php?retoid={$id_reto}'> Editar </a> </div>

  $htmlFormElimReto
  
EOS;

// Si esta logado como editor, permite añadir pelis al reto
if(!isset($_GET['busca'])){
  $formB = new FormEditorBuscaPelisReto($id_reto);
  $htmlFormBuscaPelis = $formB->gestiona();
  $contenidoPrincipal .= <<< EOS
    $htmlFormBuscaPelis
    EOS;
  }else{
    $formA = new FormEditorAddPelisReto($id_reto);
    $htmlFormAnadirPelis = $formA->gestiona();
    
    $contenidoPrincipal .= <<< EOS
    $htmlFormAnadirPelis
    EOS;
  }
  
  // destruir el array de pelis que se intercambia entre formB y formA.
  unset($_SESSION['array']); 
}
// si esta logado como usuario normal, puede elegir unirse o abandonar el reto
else if(estaLogado() && !esAdmin()){
  $id_usuario = Usuario::buscaIDPorNombre($_SESSION['nombreUsuario']);
  if(!empty($id_usuario)){

  // si el usuario ya se ha unido al reto
  if(UsuarioReto::compruebaPerteneceReto($id_usuario,$id_reto)){

    // si el reto no esta completado puede o completar reto o abandonar el reto
    if(!UsuarioReto::compruebaCompletado($id_reto, $id_usuario)){
      $formD = new FormUserAbandonReto($id_usuario, $id_reto);
      $htmlFormAbandonReto = $formD->gestiona();
      $contenidoPrincipal .= $htmlFormAbandonReto;

      $formC = new FormUserCompletaReto($id_usuario, $id_reto);
      $htmlFormCompletaReto = $formC->gestiona();
      $contenidoPrincipal .= $htmlFormCompletaReto;
    }
    // si ha completado el reto, no se muestra boton
    else{
      $contenidoPrincipal .= "<p> RETO YA COMPLETADO </p>";
    }
    
  }
  else{
  // si no esta dentro de reto, puede unirse
  
  $formJ = new FormUserJoinReto($id_usuario,$id_reto);
  $htmlFormJoinReto = $formJ->gestiona();
  $contenidoPrincipal .= $htmlFormJoinReto;
  }

  
  }

}

$contenidoPrincipal .=<<<EOS
                            </div>
                            </div>
                            <div class='butonGeneral'> <a href='retoVista.php'> Volver </a> </div>
                            EOS;
}else{
    echo "<p>Error en la muestra de retos</p>";
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>