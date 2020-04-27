<?php
//Conexión con la base de datos
;$db = new mysqli("localhost", "root", "", "chefmi");;
$db->set_charset("UTF8");
if ($db->connect_error) {
    var_dump($db->connect_error);
    die;
}

//Desplegable de los tipos de recetas del menú
$tipos_li = '';
$query = "SELECT * FROM tipos";
if ($resultado = $db->query($query)) {
    if ($resultado->num_rows > 0) {
        while ($tipo = $resultado->fetch_assoc()) {
            $tipos_li .= '<a class="text-blue-500 hover:text-blue-800" href="recetas/index.php?tipo=' . $tipo['id_tipo'] . '">' . $tipo['nombre'] . '</a>';
        }
    } else {
        $error = "";
    }
}

//Obtenemos los platos para el carrusel
$platos = array();
$query = "SELECT id_plato, nombre, descripcion, imagen FROM platos ORDER BY id_plato DESC LIMIT 3";
if ($resultado = $db->query($query)) {
    if ($resultado->num_rows > 0) {
        while ($plato = $resultado->fetch_assoc()) {
            array_push($platos, $plato);
        }
    } else {
        $error = "No se han encontrado platos.";
    }
}

include('static.php');
?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php foreach ($platos as $index => $plato) : ?>
            <div class="item <?php if ($index == 0) echo 'active'; ?>" style=" height:500px; background: url('uploads/<?php echo $plato["imagen"] ? $plato["imagen"] : 'default.jpg'; ?>') no-repeat fixed; background-size: cover;">
                <a href="recetas/index.php?receta=<?php echo $plato["id_plato"]; ?>">
                    <div class="carousel-caption">
                        <h3><?php echo $plato["nombre"]; ?></h3>
                        <p><?php echo $plato["descripcion"]; ?></p>
                    </div>
                </a>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="presentation w-8/12 mx-auto p-8 px-4">
    <p class="text-gray-700 text-3xl">
        Si buscas recetas sencillas, deliciosas y sobre todo adaptables...¡este es tu sitio!
        Dentro de las propias recetas tendrás opciones para transformar esa misma receta en una
        receta sin gluten o sin lactosa. Además hay apartados especiales para recetas vegetarianas y vegetarianas.
        También tendrás en las recetas productos sustitutivos que se adapten a tus necesidades, gustos...¡o a lo que
        tengas en la nevera!
    </p>
</div>
</body>

</html>