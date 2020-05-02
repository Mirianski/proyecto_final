<?php
$error = '';

//Conexión con la base de datos
$db = new mysqli("localhost", "root", "uniroot", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    $error = $db->connect_error;
    die;
}

//Desplegable de los tipos de recetas del menú
$tipos_li = '';
$query = "SELECT * FROM tipos";
if ($resultado = $db->query($query)) {
    if ($resultado->num_rows > 0) {
        while ($tipo = $resultado->fetch_assoc()) {
            $tipos_li .= '<a class="text-blue-500 hover:text-blue-800" href="?tipo=' . $tipo['id_tipo'] . '">' . $tipo['nombre'] . '</a>';
        }
    } else {
        $error = '';
    }
}

//Contenido estático de la página
include('static.php');
?>



<!-- LISTADO DE RECETAS -->
<?php
if (!isset($_GET["receta"])) :
    $platos = array();
    $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.imagen, p.dificultad, p.tiempo, p.votos, t.nombre AS tipo FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo WHERE estado = TRUE";
    if (isset($_GET["tipo"])) {
        $query .= " AND t.id_tipo=" . $_GET["tipo"];
    }

    $page = "1";
    $per_page = 10;
    if (!isset($_POST['total'])) {
        $count = $db->query($query)->num_rows;
        $_POST['total'] = round($count / $per_page);
        if ($count / $per_page > round($count / $per_page)) $_POST['total']++;
    } else {
        if (isset($_POST['pageq']) && $_POST['pageq'] == '<' && $_POST['page'] > 2) {
            $_POST['page']--;
        } else if (isset($_POST['pageq']) && $_POST['pageq'] == '>' && $_POST['page'] < $_POST['total']) {
            $_POST['page']++;
        } else if (isset($_POST['pageq']) && $_POST['pageq'] == '<<') {
            $_POST['page'] = 1;
        } else if (isset($_POST['pageq']) && $_POST['pageq'] == '>>') {
            $_POST['page'] = $_POST['total'];
        }
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    }

    $from = ($page - 1) * $per_page;
    $query .= " ORDER BY p.votos DESC, p.nombre ASC LIMIT $from,$per_page ";

    if ($resultado = $db->query($query)) {
        if ($resultado->num_rows > 0) {
            while ($plato = $resultado->fetch_assoc()) {

                if ($result = $db->query("SELECT e.nombre, e.imagen FROM etiquetas e LEFT JOIN etiquetas_platos ep ON ep.id_etiqueta=e.id_etiqueta 
                LEFT JOIN platos p ON p.id_plato=ep.id_plato WHERE p.id_plato =" . $plato['id_plato'])) {
                    if ($result->num_rows > 0) {
                        $plato['etiquetas'] = array();
                        while ($etiqueta = $result->fetch_assoc()) {
                            array_push($plato['etiquetas'], $etiqueta);
                        }
                    }
                }

                array_push($platos, $plato);
            }
        } else {
            $error = "No se han encontrado platos.";
        }
    }
?>
    <form action="index.php<?php if (isset($_GET["tipo"])) echo '?tipo=' . $_GET["tipo"]; ?>" method="post">
        <div class="w-8/12 mx-auto p-8 px-4">
            <?php if (isset($platos)) foreach ($platos as $plato) : ?>
                <a href="?receta=<?php echo $plato["id_plato"]; ?>">
                    <div class="w-full h-48 lg:flex m-3">
                        <div class="h-48 w-48 bg-cover" style="background-image: url('../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>')"></div>
                        <div style="background-color:#fff8ee" class="h-48 relative  border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex-1 justify-between leading-normal">
                            <div class="">
                                <div class="font-bold text-xl mb-2"><?php echo $plato["nombre"]; ?>
                                    <div class="float-right">
                                        <?php for ($i = 0; $i < (int) $plato['votos']; $i++) : ?>
                                            <span class="rated_span">☆</span>
                                        <?php endfor; ?>
                                        <?php for ($i = 0; $i < (5 - (int) $plato['votos']); $i++) : ?>
                                            <span>☆</span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-base">
                                    <?php echo $plato["descripcion"]; ?>
                                </p>
                            </div>
                            <div class="flex items-center float-left m-2 absolute bottom-0 left-0">
                                <?php if (isset($plato['etiquetas'])) foreach ($plato['etiquetas'] as $etiqueta) : ?>
                                    <img style="width:45px; height:45px" src="../src/images/<?php echo $etiqueta["imagen"]; ?>" alt="<?php echo $etiqueta["nombre"]; ?>" title="<?php echo $etiqueta["nombre"]; ?>" />
                                <?php endforeach; ?>
                            </div>
                            <div class="flex items-center float-right m-2 absolute bottom-0 right-0">
                                <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Categoría: <?php echo $plato["tipo"]; ?></span>
                                <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                                <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if ($error != '') echo $error; ?>
        </div>
    <?php endif; ?>

    <input type="hidden" name="total" value="<?php echo $_POST['total']; ?>">
    <input type="hidden" name="page" value="<?php echo isset($_POST['page']) ? (int) $_POST['page'] : 1; ?>">

    <?php if (isset($_POST['total']) &&  $_POST['total'] && $_POST['total'] > 1) : ?>
        <div class="text-center text-xl  w-8/12 mx-auto p-8 px-4">
            <input class="p-2" type="submit" name="pageq" value="<<">
            <input class="p-2" type="submit" name="pageq" value="<">
            <?php for ($i = 1; $i <= $_POST['total']; $i++) : ?>
                <input class="p-2 <?php if (isset($_POST['page']) && $_POST['page'] == $i || !isset($_POST['page']) && $i == 1) echo 'current_page'; ?>" type="submit" name="page" value="<?php echo $i; ?>">
            <?php endfor; ?>
            <input class="p-2" type="submit" name="pageq" value=">">
            <input class="p-2" type="submit" name="pageq" value=">>">
        </div>
    <?php endif; ?>
    </form>

    <!-- DETALE DE RECETA -->
    <?php
    if (isset($_GET["receta"])) :
        $platos = array();
        $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.ingredientes, p.preparacion, p.imagen, p.dificultad, p.tiempo, p.num_personas, p.votos, t.nombre AS tipo FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo WHERE p.id_plato=" . $_GET["receta"];
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
            } else {
                $error = "No se ha encontrado el plato.";
            }
        }
    ?>
        <div class="container mx-auto p-8 px-4 m-8 border-4 border-solid border-white">
            <?php if ($error != '') echo $error; ?>
            <div class="text-center text-5xl">
                <h1><?php echo $plato["nombre"]; ?><div class="flex items-center float-right m-2">
                        <?php if (isset($plato['etiquetas'])) foreach ($plato['etiquetas'] as $etiqueta) : ?>
                            <img style="width:45px; height:45px" src="../src/images/<?php echo $etiqueta["imagen"]; ?>" alt="<?php echo $etiqueta["nombre"]; ?>" title="<?php echo $etiqueta["nombre"]; ?>" />
                        <?php endforeach; ?>
                    </div>
                </h1>

            </div>
            <div class="flex p-4">
                <div class="flex-1 block text-gray-700 text-center px-4 py-2"><?php echo $plato["descripcion"]; ?></div>
                <div class="flex-1 text-gray-700 text-center px-4 py-2">
                    <img class="max-w-sm m-2" src="../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>">
                </div>
            </div>
            <div class="block px-4 py-2 mt-2">
                <div class="text-gray-700 px-4 py-2 m-4">
                    <div class="text-gray-700 px-4 py-2 m-4">
                        <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-bg m-2">Nº personas: <?php echo $plato["num_personas"]; ?></span>
                        <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-bg m-2">
                            <div>
                                <?php for ($i = 0; $i < (int) $plato['votos']; $i++) : ?>
                                    <span class="rated_span">☆</span>
                                <?php endfor; ?>
                                <?php for ($i = 0; $i < (5 - (int) $plato['votos']); $i++) : ?>
                                    <span>☆</span>
                                <?php endfor; ?>
                            </div>
                        </span>
                        <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2 float-right">Categoría: <?php echo $plato["tipo"]; ?></span>
                        <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2 float-right">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                        <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2 float-right">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                    </div>
                </div>
                <h2 class="text-3xl">Ingredientes</h2>
                <div class="flex p-4">
                    <div class="text-gray-700 py-2 m-2">
                        <ul class="list-inside list-disc">
                            <?php if (isset($ingredientes)) foreach ($ingredientes as $ingrediente) : ?>
                                <li><?php echo $ingrediente; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <h2 class="text-3xl">Preparación</h2>
                <div class="flex p-4">
                    <div class="flex-1 block text-gray-700 px-4 py-2 mt-2">
                        <!-- <ul class="list-inside list-disc"> -->
                        <?php if (isset($preparacion)) foreach ($preparacion as $paso) : ?>
                            <p><?php echo $paso; ?></p>
                        <?php endforeach; ?>
                        <!-- </ul> -->
                    </div>
                    <!-- <div class="flex-1 text-gray-700 text-center px-4 py-2">
                <img class="max-w-sm m-2" src="../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>">
            </div> -->
                </div>
                <?php if ($_SESSION["user_login"]) : ?>
                    <h2 class="text-3xl">Valoración</h2>
                    <div class="flex p-4">
                        <div class="float-left rating">
                            <span data-voto="5">☆</span><span data-voto="4">☆</span><span data-voto="3">☆</span><span data-voto="2">☆</span><span data-voto="1">☆</span>
                        </div>
                    </div>
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
                                        console.log(data);
                                        window.location.reload();
                                    }
                                });
                            })
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


    </body>

    </html>