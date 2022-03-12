<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilo.css"/>

    <title><?= $tituloPagina ?></title>

</head>
<body>
<div id="contenedor">
    <?php
		require(RAIZ_APP.'/vistas/comun/cabecera.php');
	?>
    
    <main>
        <article class="<?= $claseArticle?>">
			<?= $contenidoPrincipal ?>
    </article>
    </main>

    <?php
		require(RAIZ_APP.'/vistas/comun/pie.php');
	?>
</div>
</body>
</html>