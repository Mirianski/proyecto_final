<html>

<head>
    <meta charset="UTF-8">
    <meta lang="es">
    <title>Blog de Chef'Mi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>

<body>
    <div id="cabecera"></div>
    <nav class="menuDesplegable">
        <ul class="flex">
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="../index.php">Inicio</a>
            </li>
            <li class="mr-6 dropdown">
                <a class="text-blue-500 hover:text-blue-800" href="index.php?">Recetas</a>
                <div class="dropdown-content">
                    <?php echo $tipos_li; ?>
                </div>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="../formulary.php">Envía tus recetas</a>
            </li>
        </ul>
    </nav>
    <div class="social">
        <ul>
            <li><a href="http://www.twitter.com/mirianski93" target="_blank" class="icon-twitter"><img src="../images/twitter.svg" height="25" width="25" alt="Imagen_1"></a></li>
            <li><a href="http://www.instagram.com/mirianski" target="_blank" class="icon-instagram"><img src="../images/instagram.svg" height="25" width="25" alt="Imagen_1"></a></li>
            <li><a href="http://www.pinterest.com/mirianski" target="_blank" class="icon-pinterest"><img src="../images/pinterest.svg" height="25" width="25" alt="Imagen_1"></a></li>
        </ul>
    </div>