<html>
<?php
   session_start();
   if (!isset($_SESSION["admin_login"])) header("Location:index.php", true);
   $error = '';
?>


<?php
   // Cerrar sesión
   if (isset($_GET["cerrar_session"])) {
      unset($_SESSION["admin_login"]);
      header("Location:index.php", true);
   }

   $db = new mysqli("localhost", "root", "uniroot", "chefmi");
   $db->set_charset("UTF8");

   if ($db->connect_error) {
      var_dump($db->connect_error);
      die;
   }
?>

<?php
   // Nueva receta
   if (isset($_POST["name"])) {      
      $errors= array();
      $target_dir = '../uploads/';
      $file_name = $_FILES['imagen']['name'];
      $file_size =$_FILES['imagen']['size'];
      $file_tmp =$_FILES['imagen']['tmp_name'];
      $file_type=$_FILES['imagen']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['imagen']['name'])));

      $extensions= array("jpeg","jpg","png");
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="Solo se permiten imágenes con extensión jpeg o png";
      }
      if($file_size > 2097152) {
         $errors[]='El tamaño máximo de la imagen son 2 MB';
      }

      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,$target_dir.$file_name);
         // echo "The file ". basename( $_FILES["imagen"]["name"]). " has been uploaded.";

         $insert_query = "INSERT INTO platos (id_tipo, nombre, ingredientes, preparacion, imagen, dificultad, tiempo) 
         VALUES (".(INT)$_POST["type"].",'".$_POST["name"]."','".$_POST["ingredients"]."','".$_POST["steps"]."','".$file_name."',
         ".(INT)$_POST["dificultad"].",".(INT)$_POST["tiempo"].")";
         $result = $db->query($insert_query);
         if($result){
            header("Location:addRecipes.php", true);
         }

      }else{
         print_r($errors);
      }

     

   }

   $db = new mysqli("localhost", "root", "uniroot", "chefmi");
   $db->set_charset("UTF8");

   if ($db->connect_error) {
      var_dump($db->connect_error);
      die;
   }
?>


<head>
   <meta charset="UTF-8">
   <meta lang="es">
   <title>Administración de Chef'Mi</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="src/css/administrator.css" type="text/css">
</head>

<body>
   <div id="cabecera">
   </div>
   <h2>Administración </h2>
   <nav class="menuDesplegable">
      <ul>
         <li><a href="addRecipes.php">Listado de recetas</a></li>
         <li><a href="?nueva_receta=1">Nueva receta</a></li>
         <li><a href="?cerrar_session=1">Cerrar sesión</a></li>
      </ul>
   </nav>
   <div>
      <?php
         // Nueva receta
         if (isset($_GET["nueva_receta"])) {
            $tipos_options = '';
            $query = "SELECT * FROM tipos";
            if ($resultado = $db->query($query)) {
                if($resultado->num_rows > 0){
                  while($tipo = $resultado->fetch_assoc()){
                     $tipos_options .= '<option value='.$tipo['id_tipo'].'>'.$tipo['nombre'].'</option>';
                  }
                  include('formulary.php');
                }else{
                    $error = "";
                }
            }
         } else {
            // Listado recetas
            $tabla_recetas = '<table id="admin-table"><tr><th>Nombre</th><th>Tipo</th><th>Duración</th><th>Difdicultad</th></tr>';
            $query = "SELECT * FROM platos";
            if ($resultado = $db->query($query)) {
                if($resultado->num_rows > 0){
                  while($plato = $resultado->fetch_assoc()){
                     if ($result = $db->query("SELECT nombre FROM tipos WHERE id_tipo=".$plato["id_tipo"])) {
                        if($result->num_rows > 0){
                           $tipo = $result->fetch_assoc();
                           $tabla_recetas .= '<tr><th>'.$plato["nombre"].'</th><th>'.$tipo["nombre"].'</th><th>'.$plato["tiempo"].'</th><th>'.$plato["dificultad"].'</th></tr>';
                        }
                     }
                  }
                  $tabla_recetas .= '</table>';
                  echo $tabla_recetas;
                }else{
                  echo "No se ha encontrado ningúna receta.";
                }
            }
         }
      ?>

   </div>
</body>

</html>