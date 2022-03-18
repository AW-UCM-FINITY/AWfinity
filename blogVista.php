<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';



$tituloPagina = 'Noticia';
$claseArticle = 'Noticia';

$contenidoPrincipal = '';

$contenidoPrincipal .=<<<EOS
          <div class="header2">
            <h2>Blog AWfinity</h2>
          </div>
          <div class="columna">
         
EOS;

$id_noticia =isset($_GET['tituloid']) ? htmlspecialchars(trim(strip_tags($_GET["tituloid"]))) : 0;


$formP = new FormEditorElimNoticia($id_noticia);
$htmlFormElimNoticia = $formP->gestiona();



$noticia=Noticia::buscaNoticiaID($id_noticia);

$contenidoPrincipal .=<<<EOS
                      
                     
  <div class="card">
    <h2>{$noticia->getTitulo()}</h2>
    <h5>{$noticia->getSubtitulo()}, {$noticia->getFechaPublicacion()}</h5>
    <div></div>
    <div>
      <img class="imagNoticias2" src="img/{$noticia->getImagenNombre()}" alt="Imagen">
    </div> 
    <div><p> </p></div>
    <p>{$noticia->getContenido()}</p>
EOS;

// cuando es editor muestra el boton para editar blog
if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true && $_SESSION['esEditor']==true){
  $contenidoPrincipal .=<<<EOS
  
  <div class='butonGeneral'> <a href='editNoticia.php?idnoticia={$id_noticia}'> Editar </a> </div>

  $htmlFormElimNoticia
  
EOS;
}

$contenidoPrincipal .=<<<EOS
                            </div>
                            </div>
                            EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>