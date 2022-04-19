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
$formms=array();
$cont=0;
$FormElimValoracion=array();
foreach($comentarios as $com){
  $id=$com->getIdUser();
  $user=Usuario::buscaPorId($id);
  $formms[$cont]= new FormElimValoracion($com);
  $FormElimValoracion[$cont]=$formms[$cont]->gestiona();
  
  $contenidoPrincipal .=<<<EOS
  <div class="boxlayComentario">
  
  <h5>Comentado por:  {$user->getNombre() } </h5>
  <p> {$com->getContenido()} </p>
  <label>Puntuación:</label>
EOS;

// generacion icono estrella en funcion de la puntuacion que da usuario al ese blog
$contador=1;
for($i=0; $i<5; $i++){
  if($contador<=$com->getPuntuacion()){
    $contenidoPrincipal.= "<img alt='' class=\"imagenNivel1\" src=\"img/estrella1.png\">";
  }
  else{
    $contenidoPrincipal.= "<img   alt='' class=\"imagenNivel2\" src=\"img/estrella2.png\">";
  }
  $contador++;
}

$contenidoPrincipal.= "{$FormElimValoracion[$cont]}</div>";
$cont++;
}
$contenidoPrincipal .="</div>";

// formulario para crear valoracion por usuario
if(isset( $_SESSION['nombreUsuario'])){
$usuarioid=Usuario::buscaIDPorNombre(  $_SESSION['nombreUsuario']);

$formm= new FormEditorCreaValoracion($id_noticia, $usuarioid);
$formularioCrearValoracion=$formm->gestiona();


$contenidoPrincipal .=<<<EOS

<div class="crearValoracionPanel">
{$formularioCrearValoracion}
</div>
EOS;
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>