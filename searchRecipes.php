<?php

if (isset($_POST['keyword']) && $_POST['keyword'] != '') {
    //Conexión con la base de datos
    $db = new mysqli("localhost", "id8631729_root", "}Ko}XAy4]SmkFA/G", "id8631729_chefmi");
    $db->set_charset("UTF8");
    if ($db->connect_error) {
        var_dump($db->connect_error);
        die;
    }
    $current_url =$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    
    if ($platos = $db->query("SELECT * FROM platos WHERE 
    (nombre LIKE '%".$_POST['keyword']."%' OR 
    descripcion LIKE '%".$_POST['keyword']."%' OR 
    ingredientes LIKE '%".$_POST['keyword']."%' ) AND estado = TRUE ORDER BY votos DESC, nombre ASC")) {
        if ($platos->num_rows > 0) {
            $html = '<ul id="country-list">';
            while ($plato = $platos->fetch_assoc()) {
                $html .= '<li><a href="http://'.$current_url.'/../recetas/index.php?receta='.$plato["id_plato"].'"> '.$plato["nombre"].'</a></li>';
            }
            $html .= '</ul>';
            echo $html;
        }
    }
}else{
    echo 'No se han encontrado platos con ese criterio de búsqueda';
}
