<html>
<?php
//Inicializamos el objeto session
session_start();

if (isset($_GET["cerrar_session"])) {
    unset($_SESSION["user_login"]);
    header("Location:index.php", true);
}

//Comprobamos si el usuario ha iniciado sesión antes
// if (isset($_SESSION["admin_login"])) header("Location:addRecipes.php", true);

$error = '';
$exito = '';
if (!isset($_GET['registro'])) {
    $titulo = "Inicio de sesión";
    $boton = "Iniciar sesión";
    $enlace = "<a href='?registro=1'>Registro de usuario</a>";
}else{
    $titulo = "Nuevo usuario";
    $boton = "Crear usuario";
    $enlace = "<a href='login.php'>Inicio de sesión</a>";
}

if (isset($_GET['alta'])) {
    $exito = 'Usuario creado correctamente';
}

if (isset($_POST['usuario']) && isset($_POST['contrasenia'])) {

    $usuario = $_POST['usuario'];
    $contra = $_POST['contrasenia'];

    //Conexión con la base de datos
    $db = new mysqli("localhost", "root", "", "chefmi");
    $db->set_charset("UTF8");
    if ($db->connect_error) {
        var_dump($db->connect_error);
        die;
    }

    if (!isset($_GET['registro'])) {
        //Comprobamos que exista un usuario con los datos del formulario
        $query = "SELECT id_usuario, tipo FROM usuarios WHERE usuario LIKE '" . $usuario . "' AND contrasenia LIKE '" . $contra . "'";
        if ($usuario = $db->query($query)) {
            if ($usuario->num_rows > 0) {
                $usuario = $usuario->fetch_assoc();
                if ($usuario["tipo"] == "admin") {
                    header("Location:admin/addRecipes.php");
                    $_SESSION["admin_login"] = true;
                } else {
                    $_SESSION["user_login"] = $usuario["id_usuario"];
                    header("Location:index.php?");
                }
            } else {
                $error = "Usuario y/o contraseña incorrectos";
            }
        } else {
            $error = "Usuario y/o contraseña incorrectos";
        }
    } else {
        $query = "SELECT id_usuario FROM usuarios WHERE usuario LIKE '" . $usuario . "'";
        if ($usuario = $db->query($query)) {
            if ($usuario->num_rows > 0) {
                $error = "Ya existe un usuario con estos datos";
            } else {
                $query = "INSERT INTO usuarios (usuario, contrasenia, tipo) VALUES ('" . $_POST['usuario'] . "','" . $_POST['contrasenia'] . "', 'cocinero')";
                $usuario = $db->query($query);                
                header("Location:login.php?alta=1");
            }
        } 
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
    <h2 id="adminBar"><?php echo $titulo?></h2>
    <div class="session">
        <form method="post">
            <label for="usuario"> Introduzca su usuario</label></br>
            <input type="text" id="usuario" name="usuario" required></br>
            <label for="contrasenia"> Introduzca su contraseña </label></br>
            <input type="password" id="contrasenia" name="contrasenia" required></br>
            <input type="submit" id="inicioSesion" value="<?php echo $boton ?>"></br>
            <p id="mensaje-error"><?php echo $error; ?></p>
            <p id="mensaje-exito"><?php echo $exito; ?></p>
        </form>
        <?php echo $enlace?></h2>
        
    </div>
</body>

</html>