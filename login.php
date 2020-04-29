<html>
<?php
    //Inicializamos el objeto session
    session_start();

    if (isset($_GET["cerrar_session"])) {
        unset($_SESSION["user_login"]);
        header("Location:index.php", true);
    }

    //Comprobamos si el usuario ha iniciado sesión antes
    if (isset($_SESSION["admin_login"])) header("Location:addRecipes.php", true);
    
    $error = '';

    if (isset($_POST['usuario']) && isset($_POST['contrasenia'])) {

        $usuario = $_POST['usuario'];
        $contra = $_POST['contrasenia'];

        //Conexión con la base de datos
        $db = new mysqli("localhost", "root", "uniroot", "chefmi");
        $db->set_charset("UTF8");
        if ($db->connect_error) {
            var_dump($db->connect_error);
            die;
        }

        //Comprobamos que exista un usuario con los datos del formulario
        $query = "SELECT id_usuario, tipo FROM usuarios WHERE usuario LIKE '".$usuario."' AND contrasenia LIKE '".$contra."'";
        if ($usuario = $db->query($query)) {
            if($usuario->num_rows > 0){
                $usuario = $usuario->fetch_assoc();
                if($usuario["tipo"] == "admin"){
                    header("Location:admin/addRecipes.php");
                    $_SESSION["admin_login"] = true;
                }
                else{
                    $_SESSION["user_login"] = $usuario["id_usuario"];
                    header("Location:index.php");
                }
            }else{
                $error = "Usuario y/o contraseña incorrectos";
            }
        }else{
            $error = "Usuario y/o contraseña incorrectos";
        }
    }
?>

<head>
    <meta charset="UTF-8">
    <meta lang="es">
    <title>Blog de Chef'Mi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="src/css/style.css">
</head>


<body>
    <div id="cabecera">
    </div>
    <h2 id="adminBar">Inicio de sesión</h2>
    <div class="session">
        <form method="post">
            <label for="usuario"> Introduzca su usuario</label></br>
            <input type="text" id="usuario" name="usuario" required></br>
            <label for="contrasenia"> Introduzca su contraseña </label></br>
            <input type="password" id="contrasenia" name="contrasenia" required></br>
            <input type="submit" id="inicioSesion" value="Iniciar sesión"></br>
            <p id="mensaje-error"><?php echo $error; ?></p>
        </form>
    </div>
</body>

</html>