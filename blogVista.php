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

$noticia=Noticia::buscaNoticiaID($_GET['tituloid'] );

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
                            </div>
                            </div>

                            
                        
          EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>