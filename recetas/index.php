<?php
include('static.html');


$db = new mysqli("localhost", "root", "uniroot", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    var_dump($db->connect_error);
    die;
}

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
            $error = "No se han encontrado platos para esta categoría";
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
            if ($result = $db->query("SELECT nombre FROM tipos WHERE id_tipo=" . $plato["id_tipo"])) {
                if ($result->num_rows > 0) {
                    $tipo = $result->fetch_assoc();
                }
            }
        } else {
            $error = "No se han encontrado platos para esta categoría";
        }
    }
}
?>

<?php if (isset($_GET["tipo"])) { ?>
    <div class="container mx-auto px-4">
        <?php foreach ($platos as $plato) : ?>
            <a href="?receta=<?php echo $plato["id_plato"]; ?>">
                <div class="max-w-sm w-full lg:max-w-full lg:flex">
                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('../uploads/<?php echo $plato["imagen"]; ?>')"></div>
                    <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                        <div class="mb-8">
                            <div class="font-bold text-xl mb-2"><?php echo $plato["nombre"]; ?></div>
                            <p class="text-gray-700 text-base">
                                <?php echo $plato["descripcion"]; ?>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">Categoría: <?php echo $tipo["nombre"]; ?></span>
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php } ?>

<?php if (isset($_GET["receta"])) { ?>
    <div class="container mx-auto px-4">

        <?php $ingredientes = explode('<br />', $plato["ingredientes"]); ?>
        <?php $preparacion = explode('<br />', $plato["preparacion"]); ?>

        <div class="bg-gray-200 p-4">
            <div class="block text-gray-700 text-center px-4 py-2"><?php echo $plato["descripcion"]; ?></div>
            <div class="block text-gray-700 text-cente px-4 py-2 mt-2">
                <div class="flex bg-gray-200 p-4">
                    <h2>Ingredientes</h2>
                    <div class="flex-1 text-gray-700 text-center px-4 py-2 m-2">
                        <ul class="list-inside list-disc">
                            <?php foreach ($ingredientes as $ingrediente) : ?>
                                <li><?php echo $ingrediente; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="flex-1 text-gray-700 text-center px-4 py-2 m-2">
                        <img class="max-w-sm " src="../uploads/<?php echo $plato["imagen"]; ?>" >
                        <span class="bg-gray-400 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">Categoría: <?php echo $tipo["nombre"]; ?></span>
                        <span class="bg-gray-400 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">Tiempo: <?php echo $plato["tiempo"]; ?> min</span>
                        <span class="bg-gray-400 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">Dificultad: <?php echo $plato["dificultad"]; ?>/5</span>
                    </div>
                </div>
            </div>
            <h2>Preparación</h2>
            <div class="block text-gray-700 text-center px-4 py-2 mt-2">
                <ul class="list-inside list-disc">
                    <?php foreach ($preparacion as $paso) : ?>
                        <li><?php echo $paso; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>

</body>

</html>