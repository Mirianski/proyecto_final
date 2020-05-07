<?php
//Inicializamos el objeto session
session_start();

// $mensaje = '';
// if (isset($_POST['name'])) {
//     $nombre = $_POST['name'];
//     $correo = $_POST['email'];
//     $tipo_receta = $_POST['type'];
//     $ingredientes = $_POST['ingredients'];
//     $preparacion = $_POST['steps'];

//     $para = "miriam.martinba93@gmail.com";
//     $asunto = 'Nueva receta';

//     $contenido = '<h1>Nueva receta:</h1>';
//     $contenido .= 'Nombre: ' . $nombre;
//     $contenido .= '<h2>Ingredientes</h2>';
//     $contenido .= $ingredientes;
//     $contenido .= '<h2>Preparación</h2>';
//     $contenido .= $preparacion;

//     if (mail($para, $asunto, $contenido)) {
//         $mensaje = "Se ha enviado correctamente";
//     } else {
//         $mensaje = "Error al enviar el correo";
//     }
// }

$db = new mysqli("localhost", "root", "", "chefmi");
$db->set_charset("UTF8");

if ($db->connect_error) {
   var_dump($db->connect_error);
   die;
}
$tipos_options = '';
$exito = '';

if (isset($_GET["receta"])) {
    $exito = 'Receta creada correctamente';
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
                    $etiquetas_checkboxes .= '<label for="' . $etiqueta['id_etiqueta'] . '">' . $etiqueta['nombre'] . '</label><br>';
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
             " . (int) $_POST["dificultad"] . "," . (int) $_POST["tiempo"] . "," . (int) $_POST["num_personas"] . ",'".$autor."')";
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

include('static.php');
?>
<div id="formulary">
    
<p><?php echo $exito?></p>
    <h1>¡Envía tu receta!</h1>
    <?php if(isset($_SESSION["user_login"])) : ?>
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
            <input type="number" name="tiempo"  min="1" required />
        </div>
        <div>
            <label for="dificultad">Dificultad (1 - 5):</label></br>
            <input type="number" name="dificultad" min="1" max="5" required />
        </div>
        <div>
            <label for="num_personas">Num. personas:</label></br>
            <input type="number" name="num_personas" min="1" required />
        </div>
        <input type="submit" id="sendFormulary" value="Crear receta" />
    </form>
    <?php else : ?>
        <p>Para poder enviar tu receta tienes que estar registrado</p>
        <a href="login.php">Iniciar sesión</a>
    <?php endif;?>
    <p><?php echo $error?></p>
</div>


</body>

</html>