<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor
require __DIR__. '/includes/helpers/miembros.php'; // Para generar panel de miembros

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
	<h1><span>Contáctanos</span> :)</h1>";
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg

$contenidoPrincipal .= <<<EOS
<div class="panelContactoGeneral">
<div class="cardMiembros">
        <h1>Miembros</h1>
		
        <div class="panelMiembros">
            
EOS;

$descripcion = "Chen, Zhenbo Chen. De día estudiante de ingeniería informática en la ucm, de noche agente secreto. 
Su doble vida no le permite socializar con sus compañeros de facultad y hacer planes o excursiones (a menos que sea comida). 
Su gato le engaña con su compañero de piso. Él engaña a su gato con el gato de su compañero.";
$contenidoPrincipal .= htmlMiembros("Zhenbo Chen", "img/miembros/zhen.png", "foto de zhen", "zhenboch@ucm.es", $descripcion, "chocolate con churros", "img/miembros/alma.png", "foto de zhen", "gema del alma");


$descripcion = "Sus amigos le llaman David. Su habilidad le permite encontrar con facilidad similitudes entre profesores y personajes de dibujos animados. 
Es eurofan en secreto. El drama es el combustible de su vida. No le tiembla el pulso a la hora de mandar correitos. Hasta en su DNI pone WICKED.";
$contenidoPrincipal .= htmlMiembros("Mohammed El Messaoudi", "img/miembros/mohaaa.png", "foto de moha", "mohelmes@ucm.es", $descripcion, "no sabe de desiertos", "img/miembros/mente.png", "foto de moha", "gema de la mente");

$descripcion = "La jefa del equipo. *** **** ** ** *******, ***** ******* * *** ******. 
¿Su hobby? Sus compañeros de equipo coleccionan cromos, ¿ella? matrículas de honor. 
Sus wallpapers son los más chulos. Dicen los rumores que era fan del K-Pop.";
$contenidoPrincipal .= htmlMiembros("Jie Gao", "img/miembros/jie2.png", "foto de jie", "jiegao@ucm.es", $descripcion, "no tiene (es superpoderosa)", "img/miembros/poder.png", "foto de jie", "gema del poder");


$descripcion = "Es de Aluche, el único madrileño del equipo (no se le puede pedir más). 
Si crees que ahora luce informático, no quieras verlo con el pelo largo (todos cometemos errores). 
Él es Batman y los demás miembros su Robin.";
$contenidoPrincipal .= htmlMiembros("Álvaro López Olmos", "img/miembros/alvaro1.png", "foto de alvaro", "alvlop14@ucm.es", $descripcion, "nació en Aluche, ya es débil", "img/miembros/real.png", "foto de alvaro", "gema de la realidad");


$descripcion = "La Mcgyver del equipo, problema que surge problema que resuelve. Es la delegada de clase por votación absoluta. 
Desciende de la dinastía Jimena, su tatatatatatatatatatatatatatatatatarabuela era la Reina Urraca de Zamora. 
Zamora es una ciudad, no un pueblo. Es solo un poco hipocondríaca.";
$contenidoPrincipal .= htmlMiembros("Gloria Porto Cabero", "img/miembros/gloria.png", "foto de gloria", "gporto@ucm.es", $descripcion, "fotos de bebés o animales monos", "img/miembros/space.png", "foto de gloria", "gema del espacio");

$descripcion = "Perder el tiempo es su especialidad, le encanta tomar descansos. Su edad espiritual es 80 años (se va a la cama a las 21:00). Por las mañanas, cuando se despierta, se parece a Betameche de la película Arthur y los Minimoys. ";
$contenidoPrincipal .= htmlMiembros("Sandra Sánchez Prevost", "img/miembros/sandra1.png", "foto de sandra", "sansan12@ucm.es", $descripcion, "su perro (es monísimo)", "img/miembros/tiempo.png", "foto de sandra", "gema del tiempo");

$contenidoPrincipal .= "</div></div><div class=\"cardContacto\">";
                                

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