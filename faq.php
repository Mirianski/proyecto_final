<?php
//Inicializamos el objeto session
session_start();
if (isset($_GET["cerrar_session"])) {
    unset($_SESSION["user_login"]);
    header("Location:index.php", true);
}

//Conexión con la base de datos
$db = new mysqli("localhost", "root", "", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    var_dump($db->connect_error);
    die;
}

//Desplegable de los tipos de recetas del menú
$tipos_li = '';
$query = "SELECT * FROM tipos";
if ($resultado = $db->query($query)) {
    if ($resultado->num_rows > 0) {
        while ($tipo = $resultado->fetch_assoc()) {
            $tipos_li .= '<a class="text-blue-500 hover:text-blue-800" href="recetas/index.php?tipo=' . $tipo['id_tipo'] . '">' . $tipo['nombre'] . '</a>';
        }
        $tipos_li .= '<hr>';
        $query = "SELECT * FROM etiquetas LIMIT 3";
        if ($etiquetas = $db->query($query)) {
            if ($etiquetas->num_rows > 0) {
                while ($etiqueta = $etiquetas->fetch_assoc()) {
                    $tipos_li .= '<a class="text-blue-500 hover:text-blue-800" href="recetas/index.php?etiqueta=' . $etiqueta['id_etiqueta'] . '">' . $etiqueta['nombre'] . '</a>';
                }
            } else {
                $error = '';
            }
        }
    } else {
        $error = '';
    }
}
include('static.php');
?>

<div class="faq-container">
    <h1>FAQ</h1>
    <h3>Proceso de publicación:</h3>
    <p>La receta no se publicará automáticamente.Primero se enviará a los administradores para que comprueben que todo está correcto. Una vez se haya hecho la comprobación, se publicará la receta en la web con los credenciales correspondientes. Este proceso tardará un máximo de 48 h.</p>
</div>
</body>

</html>