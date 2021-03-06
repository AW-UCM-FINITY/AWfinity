<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Noticia';
$claseArticle = 'Noticia';

$contenidoPrincipal = '';

if(estaLogado()){
  $contenidoPrincipal .=<<<EOS
            <div class="encabezado encabezado-bg">
            <div class="tituloIndex">
              <h1>Blog AWfinity</h1>
            </div>
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
      
      {$noticia->getContenido()}
  EOS;
  
  // cuando es editor muestra el boton para editar blog
  if(esEditor()){
    $contenidoPrincipal .=<<<EOS
    <div class=panelBotones>
    <div class='butonGeneral'> <a href='editNoticia.php?idnoticia={$id_noticia}'> Editar </a> </div>
  
    $htmlFormElimNoticia </div>
    
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
    {$com->getContenido()} 
    <label>Puntuaci??n:</label>
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

}
else{ //No es un usuario registrado -> no puede acceder a las vistas de pelis/series/bso/blog/etc

  $contenidoPrincipal .= "<div class='avisoLog'>";
  $contenidoPrincipal .= "<h1> Usuario no registrado </h1>";
  $contenidoPrincipal .= "<h3> Debes iniciar sesi??n para ver el contenido. </h3>";
  $contenidoPrincipal .=" <div class='butonGeneral'><a href='login.php'> Login </a> </div>";
  $contenidoPrincipal .= "</div>"; //fin div = avisoLog

}


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>