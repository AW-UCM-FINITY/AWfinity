<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Noticias';
$claseArticle = 'Noticia';
$valr =isset($_GET['search']) ? htmlspecialchars(trim(strip_tags($_GET["search"]))) : 0;

$contenidoPrincipal = '';

$contenidoPrincipal .=<<<EOS
          <div class="header2">
            <h2>Blog AWfinity</h2>
EOS;

// cuando es editor muestra el boton para crear blog
if(esEditor()){
  $contenidoPrincipal.=<<<EOS

    <div class='butonGeneral'> <a href='creaNoticia.php'> Crear </a> </div>
EOS;
}

$contenidoPrincipal.=<<<EOS
          </div>
          <div class="menublog">
          <a class="active" href="blog.php">Inicio</a>
          <div class="barraBusca">
          <form action="blog.php" method="GET">
          <input type="text" placeholder="Busca por título o contenido" name="search">
          <button type="submit">Buscar</button>
          </form>
          </div>
          </div>
          <div class="columna">
            <div class="columnaIzq">
EOS;

if(isset($_GET['search'])){
  
 

  $noticias=Noticia::busca($valr);
}else{
  $noticias=Noticia::getNoticias();
}


if(!($noticias==false)){
      foreach($noticias as $notic){
        $parteContenido = substr($notic->getContenido(), 0, 295)."...";
        $contenidoPrincipal .=<<<EOS
                      
       
                           <div class="card" onclick="location.href='./blogVista.php?tituloid={$notic->getIdNoticia()}'">
                            <h2>{$notic->getTitulo()}</h2>
                            <h5>{$notic->getSubtitulo()}, {$notic->getFechaPublicacion()}</h5>
                            <div></div>
                            <div class="imagNoticias"><img
                             class="imagNoticias2" src="img/{$notic->getImagenNombre()}" alt="Imagen">
                            </div> 
                            <div><p> </p></div>
                            <p>{$parteContenido}</p>
                            <p><b>Pincha en la noticia para seguir viendo..</b></p>
                            </div>

                            
                        
          EOS;
      }

  $contenidoPrincipal.=<<<EOS
                       </div>
                       <div class="columnaDer">
                        <div class="card">
                          <h2>About Us</h2>
                          <div >
                          <img class="imagAboutus" src="img/logan.jpeg" alt="Imagen">
                          </div>
                          <p>El blog que tu quieres, con el mejor contenido ofrecido por los mejores editores de contenidos del mundo de la cinematografía</p>
                        </div>
                        <div class="card">
                        <h3>Ultimas noticias!</h3>
    EOS;
  
  $ultimasNoticias=Noticia::ordenarPorFecha(1);
  $rondas=0;
  foreach($ultimasNoticias as $notic){
    if($rondas===3){
      break;
    }
    $rondas=$rondas+1;
    $contenidoPrincipal.=<<<EOS
                        <div onclick="location.href='./blogVista.php?tituloid={$notic->getIdNoticia()}'">
                        <img class="img2" src="img/{$notic->getImagenNombre()}" alt="Imagen">
                        </div>
      EOS;
   
  }
  $contenidoPrincipal.=<<<EOS
          </div>
          <div class="card">
            <h3>Siguenos</h3>
            <p>"@Awfinity"</p>
          </div>
        </div>
      </div>

      <div class="footer2">
        <h2>Bienvenido a Fondo de Bikini..</h2>
      </div>
EOS;

}else{
  $contenidoPrincipal.=<<<EOS
<h2> No hay noticias que mostrarle</h2>
</div>
</div>

EOS;
}
require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>