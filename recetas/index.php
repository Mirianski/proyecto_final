<?php
$error = '';
$exito = '';

if (isset($_GET["voto"])) {
    $exito = 'Votación realizada correctamente!';
}

//Conexión con la base de datos
$db = new mysqli("localhost", "id8631729_root", "}Ko}XAy4]SmkFA/G", "id8631729_chefmi");
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
        $tipos_li .= '<hr>';
        $query = "SELECT * FROM etiquetas LIMIT 3";
        if ($etiquetas = $db->query($query)) {
            if ($etiquetas->num_rows > 0) {
                while ($etiqueta = $etiquetas->fetch_assoc()) {
                    $tipos_li .= '<a class="text-blue-500 hover:text-blue-800" href="?etiqueta=' . $etiqueta['id_etiqueta'] . '">' . $etiqueta['nombre'] . '</a>';
                }
            } else {
                $error = '';
            }
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

    if (isset($_GET["etiqueta"])) {
        $query = "SELECT p.id_plato, p.nombre, p.descripcion, p.imagen, p.dificultad, p.tiempo, p.votos, t.nombre AS tipo FROM platos p JOIN tipos t ON t.id_tipo=p.id_tipo JOIN etiquetas_platos ep ON p.id_plato=ep.id_plato WHERE estado = TRUE AND ep.id_etiqueta=" . $_GET["etiqueta"] . ";";
    }

    if (isset($_GET["tipo"])) {
        $query .= " AND t.id_tipo=" . $_GET["tipo"];
    }

    if (isset($_GET["keyword"])) {
        $query .= " AND (p.nombre LIKE '%" . $_GET['keyword'] . "%' OR p.descripcion LIKE '%" . $_GET['keyword'] . "%' OR p.ingredientes LIKE '%" . $_GET['keyword'] . "%' )";
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
    if (!isset($_GET["etiqueta"])) {
        $query .= " ORDER BY p.votos DESC, p.nombre ASC LIMIT $from,$per_page ";
    }
    if ($resultado = $db->query($query)) {
        if ($resultado->num_rows > 0) {
            while ($plato = $resultado->fetch_assoc()) {
                if ($result = $db->query("SELECT e.nombre, e.imagen, e.id_etiqueta FROM etiquetas e LEFT JOIN etiquetas_platos ep ON ep.id_etiqueta=e.id_etiqueta 
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
        <div class="contenedor-carta w-8/12 mx-auto p-8 px-4">


            <?php if (isset($platos)) foreach ($platos as $plato) : ?>
                
                <a  href="?receta=<?php echo $plato["id_plato"]; ?>">
                <div class="carta-enlace">
                    <div class="contenedor-carta-plato w-full h-48 lg:flex m-5 border border-orange-900">
                    
                        <div class="carta-imagen-div h-48 w-48 bg-cover" style="background-image: url('../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>')"></div>
                        <div class="carta-imagen-img">
                            <img class=" w-full" src="../uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>">
                        </div>                       
                        <div class="carta-plato h-48 relative border-r border-b border-l border-black-400 lg:border-l-0 lg:border-t lg:border-black-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex-1 justify-between leading-normal">
                            <div>
                                <div class="font-bold text-xl mb-2"><?php echo $plato["nombre"]; ?>
                                    <div class="etiqueta float-right text-sm inline-block rounded-full px-2 py-1">
                                        <?php for ($i = 0; $i < (int) $plato['votos']; $i++) : ?>
                                            <span class="rated_span">☆</span>
                                        <?php endfor; ?>
                                        <?php for ($i = 0; $i < (5 - (int) $plato['votos']); $i++) : ?>
                                            <span>☆</span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="text-black-700 text-base">
                                    <?php echo $plato["descripcion"]; ?>
                                </p>
                            </div>
                            <div class="etiqueta-categoria">
                                <div class="etiquetas flex items-center float-left m-2 absolute bottom-0 left-0">
                                    <?php if (isset($plato['etiquetas'])) foreach ($plato['etiquetas'] as $etiqueta) : ?>
                                        <a href="?etiqueta=<?php echo $etiqueta["id_etiqueta"]; ?>"><img class="imagen-etiqueta" src="../src/images/<?php echo $etiqueta["imagen"]; ?>" alt="<?php echo $etiqueta["nombre"]; ?>" title="<?php echo $etiqueta["nombre"]; ?>" /></a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="categorias flex items-center float-right m-2 absolute bottom-0 right-0">
                                    <span class="etiqueta inline-block rounded-full px-3 py-1 text-sm m-2">Categoría: <?php echo $plato["tipo"]; ?></span>
                                    <span class="etiqueta inline-block rounded-full px-3 py-1 text-sm m-2">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                                    <span class="etiqueta inline-block rounded-full px-3 py-1 text-sm m-2">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                                </div>
                            </div>
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

                $num_personas = $plato['num_personas'];
                if (isset($_POST["comensales"])) {
                    $num_personas = $_POST["comensales"];
                }
                $comensales_options = '';
                $persona = 'persona';
                for ($i = 1; $i < 9; $i++) {
                    if ($i > 1) {
                        $persona = 'personas';
                    }
                    if ($num_personas == $i) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    $comensales_options .= '<option value="' . $i . '" ' . $selected . '>' . $i . ' ' . $persona . '</option>';
                }
            } else {
                $error = "No se ha encontrado el plato.";
            }
        }
    ?>
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
                    <form action="" method="post">
                        <label for="comensales">Seleccionar comensales</label>
                        <select name="comensales" id="comensales" onchange="submit()">
                            <?php echo $comensales_options; ?>
                        </select>
                    </form>
                </div>
                <h2 class="text-3xl">Ingredientes</h2>
                <div class="flex p-4">
                    <div class="text-black-700 py-2 m-2">
                        <ul class="list-inside list-disc">
                            <?php if (isset($ingredientes)) foreach ($ingredientes as $ingrediente) : ?>

                                <li>
                                    <?php
                                    if ($num_personas != $plato['num_personas']) {
                                        preg_match_all('!\d+!', $ingrediente, $matches);
                                        foreach ($matches[0] as $numero) {
                                            $nuevo_valor = ($num_personas * $numero) / $plato['num_personas'];
                                            $ingrediente = str_replace($numero, $nuevo_valor, $ingrediente);
                                        }
                                    }
                                    echo $ingrediente;
                                    ?>
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
                            <div class="voto inline-block rounded-full px-3 py-1">
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