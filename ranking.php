<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Ranking TOP usuarios';
$claseArticle = 'Ranking';

$contenidoPrincipal = '';



$contenidoPrincipal .= <<<EOS
<div class="header2">
                                <h2>Ranking</h2>
                                </div>
                                <div class="columna">
                                <div class="columnaIzq">
                                <div class="contened">
                                <div class="wrapper">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Retos completados</th>
                                            <th>Puntos</th>
                                            <th>+/-</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
EOS;

$usuarios= Usuario::getUsuariosOrdenPuntos();

        foreach($usuarios as $us){
                $contenidoPrincipal .=<<<EOS
                <tr>
                                            <td class="rank">{$us->getNombre()}</td>
                        
                EOS;

                $retoscompl=UsuarioReto::retosCompletadosPorUser($us->getId());
                $contenidoPrincipal.=<<<EOS
                <td class="team">{$retoscompl}</td>
                                <td class="points">{$us->getPuntos()}</td>
                                <td class="up-down">0</td>
                                </tr>
                EOS;
        }	
                
$contenidoPrincipal.=<<<EOS
</tbody>
		</table>
		</div>
		</div>
        </div>
        </div>
EOS;


  
   
  
 


require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>