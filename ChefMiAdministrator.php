<html>
<?php
session_start();
?>

<?php
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['password'] = $_POST['password'];

        $usuario = $_SESSION['user'];
        $contra = $_SESSION['password'];

        $db = new mysqli("localhost", "root", "uniroot", "chefmi");
        $db->set_charset("UTF8");

        if ($db->connect_error) {
            var_dump($mysqli->connect_error);
            die;
        }
        header("Location:addRecipes.php", true, 301);
    }
?>

<head>
    <meta charset="UTF-8">
    <meta lang="es">
    <title>Blog de Chef'Mi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="administrator.css" type="text/css">
</head>


<body>
    <div id="cabecera">
    </div>
    <h2>Administración </h2>
    <div class="session">
        <form method="post">
            <label for="user"> Introduzca su usuario</label></br>
            <input type="text" id="user" name="user"></br>
            <label for="password"> Introduzca su contraseña </label></br>
            <input type="password" id="password" name="password"></br>
            <input type="submit" id="inicioSesion" value="Iniciar sesión"></br>
        </form>
    </div>
</body>

</html>