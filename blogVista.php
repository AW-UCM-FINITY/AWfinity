<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Noticia';
$claseArticle = 'Noticia';

$contenidoPrincipal = '';

$contenidoPrincipal .=<<<EOS
          <div class="header2">
            <h2>Blog AWfinity</h2>
          </div>
          <div class="menublog">
          <a class="active" href="blog.php">Inicio</a>
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
    <div class="imgBlogBlock">
      <img class="imagNoticias2" src="img/{$noticia->getImagenNombre()}" alt="Imagen">
    </div> 
    <div><p> </p></div>
    <p>{$noticia->getContenido()}</p>
EOS;

// cuando es editor muestra el boton para editar blog
if(esEditor()){
  $contenidoPrincipal .=<<<EOS
  
  <div class='butonGeneral'> <a href='editNoticia.php?idnoticia={$id_noticia}'> Editar </a> </div>

  $htmlFormElimNoticia
  
EOS;
}
$contenidoPrincipal .=<<<EOS
  </div>
  </div>
EOS;

$comentarios=Valoracion::getComentarios($id_noticia);
$contenidoPrincipal .="<div class=\"comentarioPanel\">";
foreach($comentarios as $com){
  $id=$com->getIdUser();
  $user=Usuario::buscaPorId($id);
  $formms= new FormElimValoracion($com);
  $FormElimValoracion=$formms->gestiona();
  $contenidoPrincipal .=<<<EOS
  <div class="boxlayComentario">
  
  <p>Comentado por:  {$user->getNombre() } </p>
  <p><b>Puntuación:   {$com->getPuntuacion()}</b></p>
  <p> {$com->getContenido()} </p>
  {$FormElimValoracion}
  </div>
EOS;
}
$contenidoPrincipal .="</div>";

// formulario para crear valoracion por usuario
if(isset( $_SESSION['nombreUsuario'])){
$usuarioid=Usuario::buscaIDPorNombre(  $_SESSION['nombreUsuario']);

$formm= new FormEditorCreaValoracion($id_noticia, $usuarioid);
$formularioCrearValoracion=$formm->gestiona();


$contenidoPrincipal .=<<<EOS
</div>
<div>
{$formularioCrearValoracion}
</div>
EOS;
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>