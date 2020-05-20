<html>
<?php
    //Inicializamos el objeto session
    session_start();

    //Comprobamos si el usuario ha iniciado sesión antes
    if (isset($_SESSION["admin_login"])) header("Location:addRecipes.php", true);
    
    $error = '';

    if (isset($_POST['user']) && isset($_POST['password'])) {

        $usuario = $_POST['user'];
        $contra = $_POST['password'];

        //Conexión con la base de datos
        $db = new mysqli("localhost", "id8631729_root", "}Ko}XAy4]SmkFA/G", "id8631729_chefmi");
        $db->set_charset("UTF8");
        if ($db->connect_error) {
            var_dump($db->connect_error);
            die;
        }

        //Comprobamos que exista un usuario con los datos del formulario
        $query = "SELECT tipo FROM usuarios WHERE usuario LIKE '".$usuario."' AND contrasenia LIKE '".$contra."'";
        if ($resultado = $db->query($query)) {
            if($resultado->num_rows > 0){
                $usuario = $resultado->fetch_assoc();
                if ($usuario["tipo"] == "admin") {
                    $_SESSION["admin_login"] = true;
                    header("Location:addRecipes.php");
                }else{
                    $error = "Usuario y/o contraseña incorrectos";
                }
            }else{
                $error = "Usuario y/o contraseña incorrectos";
            }
        }
    }
?>

<head>
    <meta charset="UTF-8">
    <meta lang="es">
    <title>Blog de Chef'Mi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../src/css/style.css" type="text/css">
</head>


<body>
    <div id="cabecera">
    </div>
    <h3 id="adminBar">Inicio de sesión</h3>
    <div class="session">
        <form method="post">
            <label for="user"> Introduzca su usuario</label></br>
            <input type="text" id="user" name="user" required></br>
            <label for="password"> Introduzca su contraseña </label></br>
            <input type="password" id="password" name="password" required></br>
            <input type="submit" id="inicioSesion" value="Iniciar sesión"></br>
            <p id="mensaje-error"><?php echo $error; ?></p>
        </form>
    </div>
</body>

</html>