<html>
<?php
if (isset($_GET['id']) && isset($_POST['contrasenia'])) {
    if ($_POST['contrasenia'] == $_POST['contrasenia-bis']) {

        //Conexión con la base de datos
        $db = new mysqli("localhost", "root", "", "chefmi");
        $db->set_charset("UTF8");
        if ($db->connect_error) {
            var_dump($db->connect_error);
            die;
        }

        $query = "SELECT id_usuario FROM usuarios WHERE perdida LIKE '" . $_GET['id'] . "'";
        if ($usuario = $db->query($query)) {
            if ($usuario->num_rows > 0) {
                $usuario = $usuario->fetch_assoc();
                $query = "UPDATE usuarios SET perdida = '', contrasenia='" . $_POST['contrasenia']."' WHERE id_usuario LIKE '" . $usuario['id_usuario'] . "'";
                $result = $db->query($query);
                if ($result) {
                    $exito = "Contraseña cambiada con éxito";
                } else {
                    $error = "Error al cambiar la contraseña, solicita otro enlace";
                }
            } else {
                $error = "El enlace ha caducado, solicita una nuevo";
            }
        }
    } else {
        $error = 'Las contraseñas no coinciden';
    }
}

include('static.php');
?>
    <h3 id="adminBar">Cambiar contraseña</h3>
    <div class="session">
        <form method="post">
            <label for="contrasenia"> Introduzca su contraseña </label></br>
            <input type="password" id="contrasenia" name="contrasenia" required></br>
            <label for="contrasenia-bis"> Introduzca de nuevo su contraseña </label></br>
            <input type="password" id="contrasenia-bis" name="contrasenia-bis" required></br>
            <input type="submit" id="recuperar" value="Establecer contraseña"></br>
            <p id="mensaje-error"><?php echo $error; ?></p>
            <p id="mensaje-exito"><?php echo $exito; ?></p>
        </form>
        <span><a href='login.php'>Iniciar sesión</a></span>
    </div>
</body>

</html>