<?php    
    //Inicializamos el objeto session
    session_start();
    if (isset($_GET["cerrar_session"])) {
        unset($_SESSION["user_login"]);
        header("Location:index.php", true);
    }
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta lang="es">
    <title>Blog de Chef'Mi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/d2adc97f69.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="src/css/style.css">
</head>

<body>
    <div id="cabecera"></div>
    <nav class="menuDesplegable">
        <ul class="flex">
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="index.php">Inicio</a>
            </li>
            <li class="mr-6 dropdown">
                <a class="text-blue-500 hover:text-blue-800" href="recetas/index.php">Recetas</a>
                <div class="dropdown-content">
                    <?php echo $tipos_li; ?>
                </div>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="formulary.php">Envía tus recetas</a>
            </li>
            <li class="mr-6">
                <div class="login">
                    <?php if ($_SESSION["user_login"]) : ?>
                        <a class="text-blue-500 hover:text-blue-800" href="login.php?cerrar_session=1"><i title="Cerrar sesión" class="fa fa-sign-out" aria-hidden="true"></i></a>
                    <?php else : ?>
                        <a class="text-blue-500 hover:text-blue-800" href="login.php"><i title="Iniciar sesión" class="fa fa-sign-in" aria-hidden="true"></i></a>
                    <?php endif; ?>
                </div>
            </li>
            <li>
                <div class="buscador">
                    <input type="text" id="cuadro_busqueda" placeholder="Buscar receta" />
                    <div id="resultados_busqueda" class="absolute"></div>
                </div>
            </li>
        </ul>
    </nav>
    <div class="social">
        <ul>
            <li><a href="http://www.twitter.com/mirianski93" target="_blank" class="icon-twitter"><img src="src/images/twitter.svg" height="25" width="25" alt="Imagen_1"></a></li>
            <li><a href="http://www.instagram.com/mirianski" target="_blank" class="icon-instagram"><img src="src/images/instagram.svg" height="25" width="25" alt="Imagen_1"></a></li>
            <li><a href="http://www.pinterest.com/mirianski" target="_blank" class="icon-pinterest"><img src="src/images/pinterest.svg" height="25" width="25" alt="Imagen_1"></a></li>
        </ul>
    </div>
    <script>
        $(document).ready(function() {
            $("#cuadro_busqueda").on('keyup',function() {
                if($(this).val().length  < 3) return  $("#resultados_busqueda").html();
                $.ajax({
                    type: "POST",
                    url: "searchRecipes.php",
                    data: 'keyword=' + $(this).val(),
                    beforeSend: function() {
                        $("#cuadro_busqueda").css("background", "#FFF");
                    },
                    success: function(data) {
                        console.log(data);
                        $("#resultados_busqueda").show();
                        $("#resultados_busqueda").html(data);
                        $("#cuadro_busqueda").css("background", "#FFF");
                    }
                });
            });
            $("#cuadro_busqueda").on('blur',function() {
                $("#resultados_busqueda").html();
            });
        });
    </script>