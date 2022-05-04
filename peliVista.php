<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$id_pelicula = isset($_GET['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_GET["id_pelicula"]))) : 0;

$id_reto = isset($_GET['idreto']) ? htmlspecialchars(trim(strip_tags($_GET["idreto"]))) : 0;

 
$pelicula = path\Pelicula::buscaPeliID($id_pelicula);
$titulo = $pelicula->getTitulo();

$formP = new path\FormEditorElimPeli($id_pelicula);
$htmlFormElimPeli = $formP->gestiona();


$duracion = $pelicula->getDuracion();
$director = $pelicula->getDirector();
$genero = $pelicula->getGenero();
$sinopsis= $pelicula->getSinopsis();
$ruta = $pelicula->getRutaImagen();
$cadena = substr($ruta,2);


$tituloPagina = 'Película';
$claseArticle = 'vistaPeli';
$contenidoPrincipal = "";

if(estaLogado()){
  $idUsuario = path\Usuario::buscaIDPorNombre($_SESSION['nombreUsuario']);
$formC = new path\FormUserCompletaReto($idUsuario, $id_reto,$id_pelicula);
$htmlFormCompletaReto = $formC->gestiona();
  $contenidoPrincipal .= "<div class='peli-card' id ='peli-card'>";
  
  $contenidoPrincipal .= "<div class='derecha'>";
  $contenidoPrincipal .= "<div class='peli-foto-card' id ='peli-foto'> <img alt='imgPeli' src=$cadena /> </div>";
  
  if(esEditor()){
    
    $contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";
  
    $contenidoPrincipal .="<div class ='generalBoton'> $htmlFormElimPeli </div>";
    $contenidoPrincipal .=" <div class='butonGeneral'><a href='editPeli.php?id_pelicula=$id_pelicula'> Editar </a> </div>";
    $contenidoPrincipal .= "</div>"; //fin div = peli-editar
  
  }

  if(!esEditor() && !esAdmin() && $id_reto && path\UsuarioReto::compruebaPerteneceReto($idUsuario,$id_reto) && !(path\UsuarioReto::compruebaCompletado($id_reto, $idUsuario)) && !(path\PelisReto::compruebaPelisComplet($idUsuario,$id_reto,$id_pelicula))){
 
    $contenidoPrincipal .="<div class ='generalBoton'> $htmlFormCompletaReto </div>";

   
  
  }
  
  $contenidoPrincipal .= "</div>"; //cierra div derecha
  
  $contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";
  
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Director:  </strong>$director</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Duracion:  </strong>$duracion  minutos</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Genero:  </strong>$genero</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";
  
  $contenidoPrincipal .= "</div>"; //fin div = peli-datos-card
  
  $contenidoPrincipal .= "</div>"; //fin div = peli-card
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