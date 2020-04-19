<?php
$error = '';
$db = new mysqli("localhost", "root", "", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    $error = $db->connect_error;
    die;
}

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

include('static.php');

if (isset($_GET["tipo"])) {
    $platos = array();
    $tipo = "";
    $query = "SELECT * FROM platos WHERE id_tipo=" . $_GET["tipo"];
    if ($resultado = $db->query($query)) {
        if ($resultado->num_rows > 0) {
            while ($plato = $resultado->fetch_assoc()) {
                array_push($platos, $plato);
            }
            if ($result = $db->query("SELECT nombre FROM tipos WHERE id_tipo=" . $_GET["tipo"])) {
                if ($result->num_rows > 0) {
                    $tipo = $result->fetch_assoc();
                }
            }
        } else {
            $error = "No se han encontrado platos para esta categoría.";
        }
    }
}

if (isset($_GET["receta"])) {
    $platos = array();
    $tipo = "";
    $query = "SELECT * FROM platos WHERE id_plato=" . $_GET["receta"];
    if ($resultado = $db->query($query)) {
        if ($resultado->num_rows > 0) {
            $plato = $resultado->fetch_assoc();
            $ingredientes = explode('<br />', $plato["ingredientes"]);
            $preparacion = explode('<br />', $plato["preparacion"]);
            if ($result = $db->query("SELECT nombre FROM tipos WHERE id_tipo=" . $plato["id_tipo"])) {
                if ($result->num_rows > 0) {
                    $tipo = $result->fetch_assoc();
                }
            }
        } else {
            $error = "No se ha encontrado el plato.";
        }
    }
}

if (!isset($_GET["tipo"]) && !isset($_GET["receta"])) {
    $platos = array();
    $query = "SELECT * FROM platos";
    if ($resultado = $db->query($query)) {
        if ($resultado->num_rows > 0) {
            while ($plato = $resultado->fetch_assoc()) {
                if ($result = $db->query("SELECT nombre FROM tipos WHERE id_tipo=" . $plato["id_tipo"])) {
                    if ($result->num_rows > 0) {
                        $tipo = $result->fetch_assoc();
                        $plato['categoria'] = $tipo['nombre'];
                    }
                }
                array_push($platos, $plato);
            }
        } else {
            $error = "No se han encontrado platos.";
        }
    }
}
?>

<?php if (isset($_GET["tipo"])) { ?>
    <div class="w-8/12 mx-auto p-8 px-4">
        <?php if ($error != '') echo $error; ?>
        <?php foreach ($platos as $plato) : ?>
            <a href="?receta=<?php echo $plato["id_plato"]; ?>">
                <div class="max-w-xl w-full lg:max-w-full lg:flex m-3">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('../uploads/<?php echo $plato["imagen"]; ?>')"></div>
                    <div style="background-color:#fff8ee" class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex-1 justify-between leading-normal">
                        <div class="mb-8">
                            <div class="font-bold text-xl mb-2"><?php echo $plato["nombre"]; ?></div>
                            <p class="text-gray-700 text-base">
                                <?php echo $plato["descripcion"]; ?>
                            </p>
                        </div>
                        <div class="flex items-center float-right m-2">
                            <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Categoría: <?php echo $tipo["nombre"]; ?></span>
                            <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                            <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php } ?>

<?php if (isset($_GET["receta"])) { ?>
    <div class="container mx-auto p-8 px-4 m-8 border-4 border-solid border-white">
        <?php if ($error != '') echo $error; ?>
        <div class="text-center text-5xl">
            <h1><?php echo $plato["nombre"]; ?></h1>
        </div>
        <div class="flex p-4">
            <div class="flex-1 block text-gray-700 text-center px-4 py-2"><?php echo $plato["descripcion"]; ?></div>
            <div class="flex-1 text-gray-700 text-center px-4 py-2">
                <img class="max-w-sm m-2" src="../uploads/<?php echo $plato["imagen"]; ?>">
            </div>
        </div>
        <div class="block text-center px-4 py-2 mt-2">
            <div class="text-gray-700 px-4 py-2 m-4">
                <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Categoría: <?php echo $tipo["nombre"]; ?></span>
                <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
            </div>
        </div>
        <h2 class="text-3xl">Ingredientes</h2>
        <div class="flex p-4">

            <div class="text-gray-700 py-2 m-2">
                <ul class="list-inside list-disc">
                    <?php foreach ($ingredientes as $ingrediente) : ?>
                        <li><?php echo $ingrediente; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <h2 class="text-3xl">Preparación</h2>
        <div class="flex p-4">
            <div class="flex-1 block text-gray-700 px-4 py-2 mt-2">
                <!-- <ul class="list-inside list-disc"> -->
                <?php foreach ($preparacion as $paso) : ?>
                    <p><?php echo $paso; ?></p>
                <?php endforeach; ?>
                <!-- </ul> -->
            </div>
            <!-- <div class="flex-1 text-gray-700 text-center px-4 py-2">
                <img class="max-w-sm m-2" src="../uploads/<?php echo $plato["imagen"]; ?>">
            </div> -->
        </div>
    </div>
<?php } ?>

<?php if (!isset($_GET["tipo"]) && !isset($_GET["receta"])) { ?>
    <div class="w-8/12 mx-auto p-8 px-4">
        <?php foreach ($platos as $plato) : ?>
            <a href="?receta=<?php echo $plato["id_plato"]; ?>">
                <div class="w-full h-58 lg:flex m-3">
                    <div class="h-auto w-48 bg-cover" style="background-image: url('../uploads/<?php echo $plato["imagen"]; ?>')"></div>
                    <div style="background-color:#fff8ee" class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex-1 justify-between leading-normal">
                        <div class="mb-8">
                            <div class="font-bold text-xl mb-2"><?php echo $plato["nombre"]; ?></div>
                            <p class="text-gray-700 text-base">
                                <?php echo $plato["descripcion"]; ?>
                            </p>
                        </div>
                        <div class="flex items-center float-right m-2">
                            <span style="background-color:#4c2721;color:#fff8ee" class="inline-block rounded-full px-3 py-1 text-sm m-2">Categoría: <?php echo $plato["categoria"]; ?></span>
                            <span style="background-color:#4c2721;color:#fff8ee"  class="inline-block rounded-full px-3 py-1 text-sm m-2">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                            <span style="background-color:#4c2721;color:#fff8ee"  class="inline-block rounded-full px-3 py-1 text-sm m-2">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
        <?php if ($error != '') echo $error; ?>
    </div>
<?php } ?>


</body>

</html>