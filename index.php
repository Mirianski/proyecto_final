<?php
$db = new mysqli("localhost", "root", "uniroot", "chefmi");
$db->set_charset("UTF8");
if ($db->connect_error) {
    var_dump($db->connect_error);
    die;
}
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

include('static.php');
?>

<div class="presentation">
    <p>
        Si buscas recetas sencillas, deliciosas y sobre todo adaptables...¡este es tu sitio!
        Dentro de las propias recetas tendrás opciones para transformar esa misma receta en una
        receta sin gluten o sin lactosa. Además hay apartados especiales para recetas vegetarianas y vegetarianas.
        También tendrás en las recetas productos sustitutivos que se adapten a tus necesidades, gustos...¡o a lo que
        tengas en la nevera!
    </p>

</div>
</body>

</html>