<html>
<?php
//Inicializamos el objeto session
session_start();

//Comprobamos si el usuario ha iniciado sesión antes
if (!isset($_SESSION["admin_login"])) header("Location:index.php", true);
$error = '';

//Conexión con la base de datos
$db = new mysqli("localhost", "root", "", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
   var_dump($db->connect_error);
   die;
}
?>


<?php

// Cerrar sesión
if (isset($_GET["cerrar_session"])) {
   unset($_SESSION["admin_login"]);
   header("Location:index.php", true);
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

      $insert_query = "INSERT INTO platos (id_tipo, nombre, descripcion, ingredientes, preparacion, imagen, dificultad, tiempo, num_personas) 
            VALUES (" . (int) $_POST["tipo"] . ",'" . $_POST["nombre"] . "', '" . $_POST["descripcion"] . "','" . nl2br($_POST["ingredientes"]) . "','" . nl2br($_POST["preparacion"]) . "','" . $file_name . "',
            " . (int) $_POST["dificultad"] . "," . (int) $_POST["tiempo"] . "," . (int) $_POST["num_personas"] . ")";
      $result = $db->query($insert_query);

      if ($result) {
         $id_plato = (int) $db->insert_id;
         foreach ($_POST["etiquetas"] as $id_etiqueta) {
            $insert_query = "INSERT INTO etiquetas_platos (id_etiqueta, id_plato) VALUES (" . (int) $id_etiqueta . "," . $id_plato . ")";
            $result = $db->query($insert_query);
         }
         header("Location:addRecipes.php", true);
      }
   } else {
      print_r($errors);
   }
}
?>

<head>
   <meta charset="UTF-8">
   <meta lang="es">
   <title>Administración de Chef'Mi</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" type="text/css" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

   <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-3.5.0.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

   <link rel="stylesheet" href="../src/css/style.css" type="text/css">
</head>

<body>
   <div id="cabecera">
   </div>
   <h2 id="adminBar">Administración </h2>
   <nav class="menuDesplegable">
      <ul>
         <li class="mr-6"><a href="addRecipes.php">Listado de recetas</a></li>
         <li class="mr-6"><a href="?recetas_pendientes=1">Listado de recetas pendientes</a></li>
         <li class="mr-6"><a href="?nueva_receta=1">Nueva receta</a></li>
         <li class="mr-6"><a href="../index.php" target="_blank">Blog</a></li>
         <li class="mr-6"><a href="?cerrar_session=1">Cerrar sesión</a></li>
      </ul>
   </nav>
   <div>
      <?php
      // Nueva receta
      if (isset($_GET["nueva_receta"])) {
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
      } else if (isset($_GET["recetas_pendientes"])) {
         $tabla_recetas = '<div class="w-8/12 mx-auto p-8 px-4 m-5" style="background-color:#fff8ee">
         <table class="table-auto cell-border compact stripe hover order-column" id="admin-table">
            <thead>
               <tr>
                  <th class="px-4 py-2">Nombre</th> <th class="px-4 py-2">Tipo</th> <th class="px-4 py-2">Duración</th> <th class="px-4 py-2">Dificultad</th> <th class="px-4 py-2">Acción</th> 
               </tr>
            </thead>
            <tbody>
         ';
         $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.ingredientes, p.preparacion, p.imagen, p.dificultad, p.tiempo, t.nombre AS tipo FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo WHERE estado = FALSE";
         if ($resultado = $db->query($query)) {
            if ($resultado->num_rows > 0) {
               while ($plato = $resultado->fetch_assoc()) {
                  $tabla_recetas .= '<tr><td class="border px-4 py-2">' . $plato["nombre"] . '</td><td class="text-center border px-4 py-2">' . $plato["tipo"] . '</td>
                  <td class="text-center border px-4 py-2">' . $plato["tiempo"] . ' min</td><td class="text-center border px-4 py-2">' . $plato["dificultad"] . '/5</td>
                  <td><a href="?editar_receta='.$plato["id_plato"].'">Editar</a><br><a href="?publicar_receta='.$plato["id_plato"].'">Publicar</a><br><a href="#" onclick="confirmacion('.$plato["id_plato"].')">Eliminar</a></td></tr>';
               }
               $tabla_recetas .= '
                     </tbody>
                  </table>
               </div>';
               echo $tabla_recetas;
            } else {
               echo "No se ha encontrado ningúna receta.";
            }
         }
      } else if (isset($_GET["editar_receta"])) {

         $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.ingredientes, p.preparacion, p.imagen, p.dificultad, p.tiempo, t.nombre AS tipo 
         FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo WHERE id_plato='".$_GET["editar_receta"]."'";

         if ($plato = $db->query($query)) {
            if ($plato->num_rows > 0) {
               $plato = $plato->fetch_assoc();
               $tipos_options = '';
               if ($tipos = $db->query("SELECT * FROM tipos")) {
                  if ($tipos->num_rows > 0) {

                     while ($tipo = $tipos->fetch_assoc()) {
                        if($plato['tipo'] == $tipo['nombre']) $tipos_options .= '<option value=' . $tipo['id_tipo'] . ' selected>' . $tipo['nombre'] . '</option>';
                        else $tipos_options .= '<option value=' . $tipo['id_tipo'] . '>' . $tipo['nombre'] . '</option>';
                     }

                     $etiquetas_checkboxes = '';
                     // $plato_etiquetas = $db->query('SELECT id_etiqueta FROM etiquetas_platos WHERE id_plato ="'.$plato['id_plato'].'"'));
                     // if ($plato_etiquetas->num_rows > 0) {
                        
                     //    $plato_etiquetas
                     // }else $plato_etiquetas = array();

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
            }
         }
      } else if (isset($_GET["publicar_receta"])) {
         $db->query("UPDATE platos SET estado=TRUE WHERE id_plato='".$_GET["publicar_receta"]."'");
         header("Location: index.php?recetas_pendientes=1", true);
      } else if (isset($_GET["despublicar_receta"])) {
         $db->query("UPDATE platos SET estado=FALSE WHERE id_plato='".$_GET["despublicar_receta"]."'");
         header("Location: index.php", true);
      } else if (isset($_GET["eliminar_receta"])) {
         $db->query("DELETE FROM platos WHERE id_plato='".$_GET["eliminar_receta"]."'");
         header("Location: index.php?recetas_pendientes=1", true);
      }else {
         // Listado recetas
         $tabla_recetas = '<div class="w-8/12 mx-auto p-8 px-4 m-5" style="background-color:#fff8ee">
         <table class="table-auto cell-border compact stripe hover order-column" id="admin-table">
            <thead>
               <tr>
                  <th class="px-4 py-2">Nombre</th> <th class="px-4 py-2">Tipo</th> <th class="px-4 py-2">Duración</th> <th class="px-4 py-2">Dificultad</th> <th class="px-4 py-2">Acción</th> 
               </tr>
            </thead>
            <tbody>
         ';
         $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.ingredientes, p.preparacion, p.imagen, p.dificultad, p.tiempo, t.nombre AS tipo FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo WHERE estado = TRUE";
         if ($resultado = $db->query($query)) {
            if ($resultado->num_rows > 0) {
               while ($plato = $resultado->fetch_assoc()) {
                  $tabla_recetas .= '<tr><td class="border px-4 py-2">' . $plato["nombre"] . '</td><td class="text-center border px-4 py-2">' . $plato["tipo"] . '</td><td class="text-center border px-4 py-2">' . $plato["tiempo"] . ' min</td><td class="text-center border px-4 py-2">' . $plato["dificultad"] . '/5</td>
                  <td><a href="?editar_receta='.$plato["id_plato"].'">Editar</a><br><a href="?despublicar_receta='.$plato["id_plato"].'">Des-publicar</a><br><a href="#" onclick="confirmacion('.$plato["id_plato"].')">Eliminar</a></td></tr>';
               }
               $tabla_recetas .= '
                     </tbody>
                  </table>
               </div>';
               echo $tabla_recetas;
            } else {
               echo "No se ha encontrado ningúna receta.";
            }
         }
      }
      ?>

   </div>
   <script>
      function confirmacion(idPlato){  
         var respuesta = confirm("¿Seguro que quieres eliminar la receta?");
         if (respuesta == true) {
            window.location.href = window.location.origin + window.location.pathname + '?eliminar_receta='+idPlato;
         }
      }
      $(document).ready(function() {
         $('#admin-table').dataTable( {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        } );
      });
   </script>
</body>

</html>