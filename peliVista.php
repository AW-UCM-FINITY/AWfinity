<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

// $id_pelicula = isset($_GET['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_GET["id_pelicula"]))) : 0;
// $id_pelicula = isset($_POST['id_pelicula']) ? htmlspecialchars(trim(strip_tags($_POST["id_pelicula"]))) : $id_pelicula;

$id_pelicula = $_GET['id_pelicula'];
//$id_pelicula = $_GET['id_pelicula'];
print("este es el id");
print($id_pelicula);
// $pelicula = path\Pelicula::buscaPeliID($id_pelicula);

// $titulo = $pelicula->getTitulo();
// $director = $pelicula->getDirector();
// $duracion = $pelicula->getDuracion();
// $genero = $pelicula->getGenero();
// $sinopsis= $pelicula->getSinopsis();
// $ruta = $pelicula->getRutaImagen();
// $cadena = substr($ruta,25);


$tituloPagina = 'Película';

$contenidoPrincipal = <<<EOS
<div class="card">
	<div class="card-header text-center">
		<h2 id="Título"></h2>
		<h6 id="Sinopsis"></h6>
	</div>
	<div class="row my-2">
		<div class="col-md-3 offset-md-3">
			<div class="row"><label><em>Titulo: </em></label></div>
			<div class="row"><label><b>Director: </b></label></div>
			<div class="row"><label><b>Duracion </b></label></div>
			<div class="row"><label><b>Genero: </b></label></div>
			<div class="row"><label><b>Sinopsis: </b></label></div>
		</div>
		<div class="col-md-2">
			<div class="row"><label id="titulo">$titulo</label></div>
			<div class="row"><label id="director">$director</label></div>
			<div class="row"><label id="duracion">$duracion</label></div>
			<div class="row"><label id="genero">$genero</label></div>
			<div class="row"><label id="sinopsis"></label>$sinopsis</div>
		</div>
		<div class="col-md-3">
			<img class="w-100 rounded mt-3" id="foto_receta" src=$cadena >
		</div>
	</div>
</div>
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>