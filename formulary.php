<?php
//Inicializamos el objeto session
session_start();


//Conexión con la base de datos
$db = new mysqli("localhost", "id8631729_root", "}Ko}XAy4]SmkFA/G", "id8631729_chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    var_dump($db->connect_error);
    die;
}


if ($db->connect_error) {
    var_dump($db->connect_error);
    die;
}
$tipos_options = '';
$exito = '';

if (isset($_GET["receta"])) {
    $exito = 'Receta enviada correctamente';
}
if ($tipos = $db->query("SELECT * FROM tipos")) {
    if ($tipos->num_rows > 0) {

        while ($tipo = $tipos->fetch_assoc()) {
            $tipos_options .= '<option value=' . $tipo['id_tipo'] . '>' . $tipo['nombre'] . '</option>';
        }

        $etiquetas_checkboxes = '';
        if ($etiquetas = $db->query('SELECT id_etiqueta, nombre FROM etiquetas')) {
            if ($etiquetas->num_rows > 0) {
                while ($etiqueta = $etiquetas->fetch_assoc()) {
                    $etiquetas_checkboxes .= '<input type="checkbox" id="' . $etiqueta['id_etiqueta'] . '" name="etiquetas[]" value="' . $etiqueta['id_etiqueta'] . '">';
                    $etiquetas_checkboxes .= '<span for="' . $etiqueta['id_etiqueta'] . '">' . $etiqueta['nombre'] . '</span>';
                }
            }
        }
    } else {
        $error = "";
    }
}


// Nueva receta
if (isset($_POST["nombre"])) {
    $errors = array();
    $target_dir = '../uploads/';
    $file_name = $_FILES['imagen']['name'];
    $file_size = $_FILES['imagen']['size'];
    $file_tmp = $_FILES['imagen']['tmp_name'];
    $file_type = $_FILES['imagen']['type'];
    $aux = explode('.', $file_name);
    $aux = end($aux);
    $file_ext = strtolower($aux);
    $extensions = array("jpeg", "jpg", "png");

    if (isset($file_name) && $file_name != '') {
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "Solo se permiten imágenes con extensión jpeg o png";
        }
        if ($file_size > 2097152) {
            $errors[] = 'El tamaño máximo de la imagen son 2 MB';
        }
    }


    if (empty($errors) == true) {
        if (isset($file_name) && $file_name != '') {
            move_uploaded_file($file_tmp, $target_dir . $file_name);
        }
        $query = "SELECT usuario FROM usuarios WHERE id_usuario LIKE '" . $_SESSION["user_login"] . "'";
        if ($usuario = $db->query($query)) {
            if ($usuario->num_rows > 0) {
                $autor = $usuario->fetch_assoc()['usuario'];
                $insert_query = "INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, imagen, dificultad, tiempo, num_personas, autor) 
             VALUES (" . (int) $_POST["tipo"] . ",'" . $_POST["nombre"] . "', '" . $_POST["descripcion"] . "','" . nl2br($_POST["ingredientes"]) . "','" . nl2br($_POST["preparacion"]) . "','" . $file_name . "',
             " . (int) $_POST["dificultad"] . "," . (int) $_POST["tiempo"] . "," . (int) $_POST["num_personas"] . ",'" . $autor . "')";
                $result = $db->query($insert_query);

                if ($result) {
                    $id_plato = (int) $db->insert_id;
                    foreach ($_POST["etiquetas"] as $id_etiqueta) {
                        $insert_query = "INSERT INTO etiquetas_platos (id_etiqueta, id_plato) VALUES (" . (int) $id_etiqueta . "," . $id_plato . ")";
                        $result = $db->query($insert_query);
                    }
                    header("Location:formulary.php?receta=1", true);
                }
            }
        }
    } else {
        print_r($errors);
    }
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
<div id="formulary">

    <p><?php echo $exito ?></p>
    <h1>¡Envía tu receta!</h1>
    <?php if (isset($_SESSION["user_login"])) : ?>
        <div id="nueva-receta">
            <form action="formulary.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nombre">Nombre de la receta:</label></br>
                    <input type="text" id="nombre" name="nombre" required maxlength="60" />
                </div>

                <div>
                    <label for="descripcion">Descripción:</label></br>
                    <textarea rows="7" id="descripcion" name="descripcion" placeholder="Desriba brevemente en qué consiste el plato" required></textarea>
                </div>

                <div>
                    <label for="tipo">Tipo de Receta:</label></br>
                    <select name="tipo" id="tipo" required>
                        <option>Seleccionar</option>
                        <?php echo $tipos_options; ?>
                    </select>
                </div>

                <div id="contenedor-etiquetas">
                    <label>Etiquetas:</label>
                    <?php echo $etiquetas_checkboxes; ?>
                </div>

                <div>
                    <label for="ingredientes">Ingredientes:</label></br>
                    <textarea rows="7" id="ingredientes" name="ingredientes" placeholder="Ponga uno debajo de otro junto a las cantidades/medidas" required></textarea>
                </div>
                <div>
                    <label for="preparacion">Preparación:</label></br>
                    <textarea rows="9" id="preparacion" name="preparacion" placeholder="Preparación..." required></textarea>
                </div>
                <div class="input-number">
                    <label for="imagen">Imagen:</label></br>
                    <input type="file" name="imagen" id="imimagenage">
                </div>
                <div class="input-number">
                    <label for="tiempo">Tiempo (min):</label></br>
                    <input type="number" name="tiempo" min="1" required />
                </div>
                <div class="input-number">
                    <label for="dificultad">Dificultad (1 - 5):</label></br>
                    <input type="number" name="dificultad" min="1" max="5" required />
                </div>
                <div class="input-number">
                    <label for="num_personas">Num. personas:</label></br>
                    <input type="number" name="num_personas" min="1" required />
                </div>
                <input type="submit" id="sendFormulary" value="Crear receta" />
            </form>
        <?php else : ?>
            <p>Para poder enviar tu receta tienes que estar registrado</p>
            <a href="login.php">Iniciar sesión</a>
        <?php endif; ?>
        <p><?php echo $error ?></p>

        <p><a href="faq.php">Proceso de publicación <i class="fa fa-question-circle" aria-hidden="true"></i></a></p>
        </div>
</div>

</body>

</html>