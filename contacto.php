<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Panel Administrador';
$claseArticle = 'Contacto';

$contenidoPrincipal = '';

$rutaTemaDefault = RUTA_CSS."/default.css";
$rutaTemaAzul = RUTA_CSS."/azul.css";

// $contenidoPrincipal .= <<<EOS
// <div class="header2">
//         <h2>Contáctanos ;)</h2>
// </div>
// EOS;

$contenidoPrincipal .= "<div class='encabezado encabezado-bg'> ";
$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1><span>Contáctanos</span> ;)</h1>";
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg

$contenidoPrincipal .= <<<EOS
<div class="panelContactoGeneral">
<div class="cardMiembros">
        <h1>Miembros</h1>
		
        <div class="panelMiembros">

            
            <div class="miembros-box-item">
                <div class="miembros-top">
                    <h2>Zhenbo Chen</h2>
                    <img class="a" src="img/miembros/zhen.png" alt="foto de zhen" />
                </div>
                <div class="miembros-list">
                    <ul>
                        <li class="correo"> Email <span>zhenboch@ucm.es</span></li>
                        <li> Descripción

                        <p>Chen, Zhenbo Chen. De día estudiante de ingeniería informática en la ucm, de noche agente secreto. 
                        Su doble vida no le permite socializar con sus compañeros de facultad y hacer planes o excursiones (a menos que sea comida). 
                        Su gato le engaña con su compañero de piso. Él engaña a su gato con el gato de su compañero.  
                                
                        </p></li>
                        <li> Debilidad <span>chocolate con churros</span></li>
                        <li class="rol"> Rol en el equipo <img src="img/miembros/alma.png" alt="foto de zhen" /><span>gema del alma</span></li>
                    </ul>
                </div>                   
            </div>

            <div class="miembros-box-item">
                <div class="miembros-top">
                    <h2>Mohammed El Messaoudi</h2>
                    <img class="a" src="img/miembros/mohaaa.png" alt="foto de moha" />
                </div>
                <div class="miembros-list">
                    <ul>
                        <li class="correo"> Email <span>mohelmes@ucm.es</span></li>
                        <li> Descripción

                        <p>Sus amigos le llaman David. Su habilidad le permite encontrar con facilidad similitudes entre profesores y personajes de dibujos animados. 
                        Es eurofan en secreto. El drama es el combustible de su vida. No le tiembla el pulso a la hora de mandar correitos. Hasta en su DNI pone WICKED.               
                        </p></li>
                        <li> Debilidad <span>no sabe de desiertos</span></li>
                        <li class="rol"> Rol en el equipo <img src="img/miembros/mente.png" alt="foto de moha" /><span>gema de la mente</span></li>
                    </ul>
                </div>                   
            </div>

            <div class="miembros-box-item">
                <div class="miembros-top">
                    <h2>Jie Gao</h2>
                    <img class="a" src="img/miembros/jie2.png" alt="foto de jie" />
                </div>
                <div class="miembros-list">
                    <ul>
                        <li class="correo"> Email <span>jiegao@ucm.es</span></li>
                        <li> Descripción

                        <p>La jefa del equipo. Los profes no le corrigen, ella corrige a los profes. 
                        ¿Su hobby? Sus compañeros de equipo coleccionan cromos, ¿ella? matrículas de honor. 
                        Sus wallpapers son los más chulos. Dicen los rumores que era fan del K-Pop. 
                        </p></li>
                        <li> Debilidad <span>no tiene (es superpoderosa)</span></li>
                        <li class="rol"> Rol en el equipo <img src="img/miembros/poder.png" alt="foto de jie" /><span>gema del poder</span></li>
                    </ul>
                </div>                   
            </div>

            <div class="miembros-box-item">
                <div class="miembros-top">
                    <h2>Álvaro López Olmos</h2>
                    <img class="a" src="img/miembros/alvaro1.png" alt="foto de alvaro" />
                </div>
                <div class="miembros-list">
                    <ul>
                        <li class="correo"> Email <span>alvlop14@ucm.es</span></li>
                        <li> Descripción

                        <p>Es de Aluche, el único madrileño del equipo (no se le puede pedir más). 
                        Si crees que ahora luce informático, no quieras verlo con el pelo largo (todos cometemos errores). 
                        Él es Batman y los demás miembros su Robin. 
                        </p></li>
                        <li> Debilidad <span>nació en Aluche, ya es débil</span></li>
                        <li class="rol"> Rol en el equipo <img src="img/miembros/real.png" alt="foto de alvaro" /><span>gema de la realidad</span></li>
                    </ul>
                </div>                   
            </div>

            <div class="miembros-box-item">
                <div class="miembros-top">
                    <h2>Gloria Porto Cabero</h2>
                    <img class="a" src="img/miembros/gloria.png" alt="foto de gloria" />
                </div>
                <div class="miembros-list">
                    <ul>
                        <li class="correo"> Email <span>gporto@ucm.es</span></li>
                        <li> Descripción

                        <p>La Mcgyver del equipo, problema que surge problema que resuelve. Es la delegada de clase por votación absoluta. 
                        Desciende de la dinastía Jimena, su tatatatatatatatatatatatatatatatatarabuela era la Reina Urraca de Zamora. 
                        Zamora es una ciudad, no un pueblo. Es solo un poco hipocondríaca.
                        </p></li>
                        <li> Debilidad <span>fotos de bebés o animales monos</span></li>
                        <li class="rol"> Rol en el equipo <img src="img/miembros/space.png" alt="foto de gloria" /><span>gema del espacio</span></li>
                    </ul>
                </div>                   
            </div>

            <div class="miembros-box-item">
            <div class="miembros-top">
                <h2>Sandra Sánchez Prevost</h2>
                <img class="a" src="img/miembros/sandra1.png" alt="foto de sandra" />
            </div>
            <div class="miembros-list">
                <ul>
                    <li class="correo"> Email <span>sansan12@ucm.es</span></li>
                    <li> Descripción

                    <p>Perder el tiempo es su especialidad, le encanta tomar descansos. 
                    Su edad espiritual es 80 años (se va a la cama a las 21:00). 
                    Por las mañanas, cuando se despierta, se parece a Betameche de la película Arthur y los Minimoys. 
                    </p></li>
                    <li> Debilidad <span>su perro (es monísimo)</span></li>
                    <li class="rol"> Rol en el equipo <img src="img/miembros/tiempo.png" alt="foto de sandra" /><span>gema del tiempo</span></li>
                </ul>
            </div>                   
            </div>

        </div>
</div>
        
<div class="cardContacto">
                                
EOS;

if(!isset($_SESSION['nombreUsuario'])){
    $nombreUsuario = 'NOREGISTRADO';
}
else{
    $nombreUsuario = $_SESSION['nombreUsuario'];
}


$formC = new FormCreaContacto($nombreUsuario);
$htmlFormCreaContacto = $formC->gestiona();


$contenidoPrincipal .= <<< EOS
    $htmlFormCreaContacto
</div>
</div>
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>