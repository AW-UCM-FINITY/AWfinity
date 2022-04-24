<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" id="estilo" type="text/css" href="<?= RUTA_CSS ?>/default.css"/>
    <script type="text/javascript" src="<?= RUTA_JS ?>/cambiarcss.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/fonts.css"/>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="<?= RUTA_JS ?>/botonSubir.js"> </script>

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

    <div class="ir-arriba icon-circle-up"> </div>
    
</div>
</body>
</html>