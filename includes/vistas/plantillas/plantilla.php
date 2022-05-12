<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" id="estilo" type="text/css" href="<?= RUTA_CSS?>/<?= es\ucm\fdi\aw\Apariencia::getAspecto()->getCss();?>"/>
    
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/fonts.css"/>
    <link rel="shortcut icon" href="<?= RUTA_IMGS ?>/awfinity.png" />
    

    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="<?= RUTA_JS ?>/botonSubir.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js" referrerpolicy="origin"></script>

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

    <div class="botonAtras icon-undo2" onclick="history.go(-1)"></div>
    <div class="ir-arriba icon-circle-up"> </div>
    <?php
		require(RAIZ_APP.'/vistas/comun/pie.php');
	?>


</div>
</body>
</html>