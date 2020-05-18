<?php
//Inicializamos el objeto session
session_start();
if (isset($_GET["cerrar_session"])) {
    unset($_SESSION["user_login"]);
    header("Location:index.php", true);
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