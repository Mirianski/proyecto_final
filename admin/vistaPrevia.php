<?php
$error = '';
$exito = '';

if (isset($_GET["voto"])) {
    $exito = 'Votación realizada correctamente!';
}

//Conexión con la base de datos
;$db = new mysqli("localhost", "root", "uniroot", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    $error = $db->connect_error;
    die;
}
?>


<!-- DETALE DE RECETA -->
<?php
if (isset($_GET["receta"])) :
    $platos = array();
    $votoUsuario = 0;
    $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.ingredientes, p.preparacion, p.imagen, p.dificultad, p.tiempo, p.num_personas, p.votos, p.autor, t.nombre AS tipo FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo WHERE p.id_plato=" . $_GET["receta"];
    if ($resultado = $db->query($query)) {
        if ($resultado->num_rows > 0) {
            $plato = $resultado->fetch_assoc();
            $ingredientes = explode('<br />', $plato["ingredientes"]);
            $preparacion = explode('<br />', $plato["preparacion"]);

            if ($result = $db->query("SELECT e.nombre, e.imagen FROM etiquetas e LEFT JOIN etiquetas_platos ep ON ep.id_etiqueta=e.id_etiqueta 
                    LEFT JOIN platos p ON p.id_plato=ep.id_plato WHERE p.id_plato =" . $plato['id_plato'])) {
                if ($result->num_rows > 0) {
                    $plato['etiquetas'] = array();
                    while ($etiqueta = $result->fetch_assoc()) {
                        array_push($plato['etiquetas'], $etiqueta);
                    }
                }
            }

            $query = "SELECT v.voto FROM votos v JOIN votos_platos vp ON vp.id_voto=v.id_voto WHERE v.id_usuario=" . $_SESSION["user_login"] . " AND vp.id_plato=" . $plato['id_plato'];
            if ($voto = $db->query($query)) {
                if ($voto->num_rows > 0) {
                    $votoUsuario = $voto->fetch_assoc()['voto'];
                }
            }
        } else {
            $error = "No se ha encontrado el plato.";
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
      <!-- <ul>
         <li class="mr-6"><a href="addRecipes.php">Listado de recetas</a></li>
         <li class="mr-6"><a href="?recetas_pendientes=1">Listado de recetas pendientes</a></li>
         <li class="mr-6"><a href="?nueva_receta=1">Nueva receta</a></li>
         <li class="mr-6"><a href="../index.php" target="_blank">Blog</a></li>
         <li class="mr-6"><a href="?cerrar_session=1">Cerrar sesión</a></li>
      </ul> -->
   </nav>
   <div>
   <div class="recipes-container container mx-auto p-8 px-4 m-8">
            <?php if ($error != '') echo $error; ?>
            <div class="text-center text-5xl">
                <h1><?php echo $plato["nombre"]; ?><div class="flex items-center float-right m-2">
                        <?php if (isset($plato['etiquetas'])) foreach ($plato['etiquetas'] as $etiqueta) : ?>
                            <img class="imagen-etiqueta" src="../src/images/<?php echo $etiqueta["imagen"]; ?>" alt="<?php echo $etiqueta["nombre"]; ?>" title="<?php echo $etiqueta["nombre"]; ?>" />
                        <?php endforeach; ?>
                    </div>
                </h1>

            </div>
            <div class="flex p-4">
                <div class="flex-1 block text-black-700 text-center px-4 py-2"><?php echo $plato["descripcion"]; ?></div>
                <div class="flex-1 text-black-700 text-center px-4 py-2">
                    <img class="max-w-sm m-2 recipes-img" src="../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>">
                </div>
            </div>
            <div class="flex p-4">
                <p>Publicado por: <b><?php echo $plato['autor'] ?></b></p>
            </div>
            <div class="block px-4 py-2 mt-2">
                <div class="text-black-700 px-4 py-2 m-4">
                    <div class="text-black-700 px-4 py-2 m-4">
                        <span class="etiqueta inline-block rounded-full px-3 py-1 text-bg m-2">Nº personas: <?php echo $plato["num_personas"]; ?></span>
                        <span class="etiqueta inline-block rounded-full px-3 py-1 text-bg m-2">
                            <div>
                                <?php for ($i = 0; $i < (int) $plato['votos']; $i++) : ?>
                                    <span class="rated_span">☆</span>
                                <?php endfor; ?>
                                <?php for ($i = 0; $i < (5 - (int) $plato['votos']); $i++) : ?>
                                    <span>☆</span>
                                <?php endfor; ?>
                            </div>
                        </span>
                        <span class="etiqueta inline-block rounded-full px-3 py-1 text-sm m-2 float-right">Categoría: <?php echo $plato["tipo"]; ?></span>
                        <span class="etiqueta inline-block rounded-full px-3 py-1 text-sm m-2 float-right">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                        <span class="etiqueta inline-block rounded-full px-3 py-1 text-sm m-2 float-right">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                    </div>
                </div>
                <h2 class="text-3xl">Ingredientes</h2>
                <div class="flex p-4">
                    <div class="text-black-700 py-2 m-2">
                        <ul class="list-inside list-disc">
                            <?php if (isset($ingredientes)) foreach ($ingredientes as $ingrediente) : ?>
                                <li>
                                    <?php echo $ingrediente; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <h2 class="text-3xl">Preparación</h2>
                <div class="flex p-4">
                    <div class="flex-1 block text-black-700 px-4 py-2 mt-2">
                        <!-- <ul class="list-inside list-disc"> -->
                        <?php if (isset($preparacion)) foreach ($preparacion as $paso) : ?>
                            <?php if(trim($paso) != '') : ?>
                                <p class="preparacion">- <?php echo $paso; ?></p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <!-- </ul> -->
                    </div>
                    <!-- <div class="flex-1 text-black-700 text-center px-4 py-2">
                <img class="max-w-sm m-2" src="../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>">
            </div> -->
                </div>

                <h2 class="text-3xl">Valoración</h2><?php if (isset($_SESSION["user_login"])) : ?>
                    <div class="flex p-4">
                        <?php if ($votoUsuario == 0) : ?>
                            <div class="voto float-left rating inline-block rounded-full px-3 py-1">
                                <span data-voto="5">☆</span><span data-voto="4">☆</span><span data-voto="3">☆</span><span data-voto="2">☆</span><span data-voto="1">☆</span>
                            </div>
                        <?php else : ?>
                            <div>
                                <?php for ($i = 0; $i < (int) $votoUsuario; $i++) : ?>
                                    <span class="rated_span">☆</span>
                                <?php endfor; ?>
                                <?php for ($i = 0; $i < (5 - (int) $votoUsuario); $i++) : ?>
                                    <span>☆</span>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p><?php echo $exito; ?></p>
                    <script>
                        $(document).ready(function() {
                            $('.rating span').on('click', function(e) {
                                e.preventDefault();
                                $.ajax({
                                    type: "POST",
                                    url: "../votoRecipes.php",
                                    data: {
                                        voto: $(this).data().voto,
                                        id_plato: "<?php echo $plato['id_plato'] ?>"
                                    },
                                    success: function(data) {
                                        window.location.href = window.location.href + "&voto=1";
                                    }
                                });
                            })
                        });
                    </script>
                <?php else : ?>
                    <div class="flex p-4">
                        <p>Para poder enviar tu receta tienes que estar registrado <a style="text-decoration:underline;" href="../login.php">Iniciar sesión</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
<?php endif; ?>


</body>

</html>