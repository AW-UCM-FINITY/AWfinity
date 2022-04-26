<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" id="estilo" type="text/css" href="<?= RUTA_CSS ?>/default.css"/>
    <script type="text/javascript" src="<?= RUTA_JS ?>/cambiarcss.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/fonts1.css"/>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="<?= RUTA_JS ?>/botonSubir.js"> </script>

    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/fonts2.css"/>

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

    <a href="javascript: history.go(-1)"><div class="botonAtras icon-undo2"></div></a>
    <div class="ir-arriba icon-circle-up"> </div>
    <?php
		require(RAIZ_APP.'/vistas/comun/pie.php');
	?>


</div>
</body>
</html>