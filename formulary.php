<?php

$mensaje = '';
if (isset($_POST['name'])) {
    $nombre = $_POST['name'];
    $correo = $_POST['email'];
    $tipo_receta = $_POST['type'];
    $ingredientes = $_POST['ingredients'];
    $preparacion = $_POST['steps'];

    $para = "miriam.martinba93@gmail.com";
    $asunto = 'Nueva receta';

    $contenido = '<h1>Nueva receta:</h1>';
    $contenido .= 'Nombre: ' . $nombre;
    $contenido .= '<h2>Ingredientes</h2>';
    $contenido .= $ingredientes;
    $contenido .= '<h2>Preparación</h2>';
    $contenido .= $preparacion;

    if (mail($para, $asunto, $contenido)) {
        $mensaje = "Se ha enviado correctamente";
    } else {
        $mensaje = "Error al enviar el correo";
    }
}

// $db = new mysqli("localhost", "root", "uniroot", "chefmi");
// $db->set_charset("UTF8");

// if ($db->connect_error) {
//    var_dump($db->connect_error);
//    die;
// }
if(!isset($db)) exit;
$tipos_options = '';
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
                    $etiquetas_checkboxes .= '<label for="' . $etiqueta['id_etiqueta'] . '">' . $etiqueta['nombre'] . '</label><br>';
                }
            }
        }

        include('formulary.php');
    } else {
        $error = "";
    }
}

include('static.php');
?>
<div id="formulary">
    <h1>¡Envía tu receta!</h1>
    <form action="addRecipes.php" method="post" enctype="multipart/form-data">
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

        <div>
            <label>Etiquetas:</label></br>
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
        <div>
            <label for="imagen">Imagen:</label></br>
            <input type="file" name="imagen" id="imimagenage">
        </div>
        <div>
            <label for="tiempo">Tiempo (min):</label></br>
            <input type="number" name="tiempo" required />
        </div>
        <div>
            <label for="dificultad">Dificultad (1 - 5):</label></br>
            <input type="number" name="dificultad" required />
        </div>
        <div>
            <label for="num_personas">Num. personas:</label></br>
            <input type="number" name="num_personas" required />
        </div>
        <input type="submit" id="sendFormulary" value="Crear receta" />
    </form>
</div>


</body>

</html>