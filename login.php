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

    if(isset($_POST['email'])) $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $contra = $_POST['contrasenia'];

    //Conexión con la base de datos
    ;$db = new mysqli("localhost", "root", "uniroot", "chefmi");
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
                if ($usuario["tipo"] == "cocinero") {
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
        $query = "SELECT id_usuario FROM usuarios WHERE usuario LIKE '" . $usuario . "' OR email LIKE '" . $email . "'";
        if ($usuario = $db->query($query)) {
            if ($usuario->num_rows > 0) {
                $error = "Ya existe un usuario con estos datos";
            } else {
                $query = "INSERT INTO usuarios (email, usuario, contrasenia, tipo) VALUES ('" . $email . "','" . $_POST['usuario'] . "','" . $_POST['contrasenia'] . "', 'cocinero')";
                $usuario = $db->query($query);                
                header("Location:login.php?alta=1");
            }
        } 
    }
}
include('static.php');
?>
    <h3 id="adminBar"><?php echo $titulo?></h3>
    <div class="session">
        <form method="post">
            <?php if (isset($_GET['registro'])) : ?>
                <label for="email"> Introduzca su email</label></br>
                <input type="email" id="email" name="email" required></br>
            <?php endif;?>
            <label for="usuario"> Introduzca su usuario</label></br>
            <input type="text" id="usuario" name="usuario" required></br>
            <label for="contrasenia"> Introduzca su contraseña </label></br>
            <input type="password" id="contrasenia" name="contrasenia" required></br>
            <input type="submit" id="inicioSesion" value="<?php echo $boton ?>"></br>
            <p id="mensaje-error"><?php echo $error; ?></p>
            <p id="mensaje-exito"><?php echo $exito; ?></p>
        </form>
        <span><?php echo $enlace?></span>
        <br><br>
        <span><a href='recuperar.php' target="_blank">¿Olvidaste tu contraseña?</a></span>
        
    </div>
</body>

</html>