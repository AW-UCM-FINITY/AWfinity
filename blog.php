<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';



$tituloPagina = 'Noticias';
$claseArticle = 'NoticiasAll';

$contenidoPrincipal = '';

$contenidoPrincipal .=<<<EOS
          <div class="header2">
            <h2>Blog AWfinity</h2>
          </div>

          <div class="columna">
            <div class="columnaIzq">
EOS;

$noticias=Noticia::getNoticias();
if(!$noticias==false){
      foreach($noticias as $notic){
        $contenidoPrincipal .=<<<EOS
                      
       
                           <div class="card" onclick="location.href='./blogVista.php?tituloid={$notic['idNoticia']}'">
                            <h2>{$notic['titulo']}</h2>
                            <h5>{$notic['subtitulo']}, {$notic['fechaPublicacion']}</h5>
                            <div></div>
                            <div>
                            <img class="imagNoticias" src="img/{$notic['imagenNombre']}" alt="Imagen">
                            </div> 
                            <div><p> </p></div>
                            <p>{$notic['contenido']}</p>
                            </div>

                            
                        
          EOS;
      }
 $contenidoPrincipal.=<<<EOS
                       </div>
                       <div class="columnaDer">
                        <div class="card">
                          <h2>About Us</h2>
                          <div >
                          <img class="imagAboutus" src="img/logan.png" alt="Imagen">
                          </div>
                          <p>El blog que tu quieres, con el mejor contenido ofrecido por los mejores editores de contenidos del mundo de la cinematografía</p>
                        </div>
                        <div class="card">
                        <h3>Ultimas noticias!</h3>
    EOS;
  $ultimasNoticias=Noticia::ordenarPorFecha(1);
  $rondas=0;
  foreach($ultimasNoticias as $notic){
    if($rondas==3){
      break;
    }
    $rondas=$rondas+1;
    $contenidoPrincipal.=<<<EOS
                        <div >
                        <img class="img2" src="img/{$notic['imagenNombre']}" alt="Imagen">
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