<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';

use es\ucm\fdi\aw as path;

$id_serie = isset($_GET['id_serie']) ? htmlspecialchars(trim(strip_tags($_GET["id_serie"]))) : 0;

 
$serie = path\Serie::buscaSerieID($id_serie);
$titulo = $serie->getTitulo();

$formP = new path\FormEditorElimSerie($id_serie);
$htmlFormElimSerie = $formP->gestiona();


$productor = $serie->getProductor();
$genero = $serie->getGenero();
$numTemporadas = $serie->getNumTemporadas();
$sinopsis= $serie->getSinopsis();
$ruta = $serie->getRutaImagen();
$cadena = substr($ruta,2);


$tituloPagina = 'Serie';
$claseArticle = 'vistaSerie';
$contenidoPrincipal = "";

if(estaLogado()){
  $contenidoPrincipal .= "<div class='peli-card' id ='peli-card'>";
  
  $contenidoPrincipal .= "<div class='derecha'>";
  $contenidoPrincipal .= "<div class='peli-foto-card' id ='peli-foto'> <img alt='imgPeli' src=$cadena /> </div>";
  if(esEditor()){
    
    $contenidoPrincipal .= "<div class='peli-editar-card' id ='peli-editar'>";
  
    $contenidoPrincipal .=" <div class ='generalBoton'>$htmlFormElimSerie </div>";
    $contenidoPrincipal .=" <div class='butonGeneral'><a href='editSerie.php?id_serie=$id_serie'> Editar </a> </div>";
    $contenidoPrincipal .= "</div>"; //fin div = peli-editar
  
  }
  $contenidoPrincipal .= "</div>"; //cierra div derecha
  
  $contenidoPrincipal .= "<div class='peli-datos-card' id ='peli-datos'>";
  
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Titulo:  </strong>$titulo</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Productor:  </strong>$productor</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Temporadas:  </strong>$numTemporadas temporadas</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Genero:  </strong>$genero</div>";
  $contenidoPrincipal .= "<div class='fila-dato'> <strong>Sinopsis:  </strong>$sinopsis</div>";
  
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "";
  $contenidoPrincipal .= "<div class='temporadas-container'>";
  for($i = 1; $i <= $numTemporadas; $i++) {
    $contenidoPrincipal .= "<div class='capitulos-container'>";
    // $contenidoPrincipal .=" <div class='butonGeneral'><a href='temporadaVista.php?id_serie=$id_serie&temporada=$i'> Temporada $i </a> </div>";
    $contenidoPrincipal .= "<button class='dropdown-btn'>Temporada $i   <i class='icon icon-circle-down'>  </i>";
    if(esEditor()){
      //Antes de modificar
      $contenidoPrincipal .= "<a class='edit-cap' href='creaEpisodio.php?id_serie=$id_serie&temporada=$i'>  <i class='icon icon-plus'></i></a>";
      
    }
    $contenidoPrincipal .= "</button>";
    $arrayEpisodios = path\Episodio::listaEpisodios($id_serie, $i);
    $contenidoPrincipal .= "<div class='dropdown-container'>";
    foreach ($arrayEpisodios as $key => $episodio) {
      $tituloEp = $episodio->getTitulo();
      // $duracionEp = $episodio->getDuracion();
      $id_episodio = $episodio->getId();
      $contenidoPrincipal .= "<a href='episodioVista.php?id_episodio=$id_episodio'>$tituloEp</a>";
    }
    $contenidoPrincipal .= "</div>"; //cierra drop-container
    $contenidoPrincipal .= "</div>"; //cierra capitulos-container

    // $contenidoPrincipal .= "<div class='dropdown-content'>";
    // $contenidoPrincipal .= "<a href='#'>Link 1</a>";
    // $contenidoPrincipal .= "<a href='#'>Link 2</a>";
    // $contenidoPrincipal .= "<a href='#'>Link 3</a>";
  }
  $contenidoPrincipal .= "</div>"; //cierra temporada container
    
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


$contenidoPrincipal .= "<script src='js/dropdown.js'></script>";

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>