<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Noticias';
$claseArticle = 'NoticiasAll';

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
          <a class="active" href="#home">Inicio</a>
          <a href="#about">About</a>
          <a href="#contact">Contact</a>
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

$noticias=Noticia::getNoticias();

if(!($noticias==false)){
      foreach($noticias as $notic){
        $contenidoPrincipal .=<<<EOS
                      
       
                           <div class="card" onclick="location.href='./blogVista.php?tituloid={$notic->getIdNoticia()}'">
                            <h2>{$notic->getTitulo()}</h2>
                            <h5>{$notic->getSubtitulo()}, {$notic->getFechaPublicacion()}</h5>
                            <div></div>
                            <div><img
                             class="imagNoticias" src="img/{$notic->getImagenNombre()}" alt="Imagen">
                            </div> 
                            <div><p> </p></div>
                            <p>{$notic->getContenido()}</p>
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
  echo "<p>Error en la muestra de noticias</p>";
}
require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>