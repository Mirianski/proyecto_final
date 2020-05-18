<?php
//Inicializamos el objeto session
session_start();
$mensaje_error = 'No se ha podido realizar el voto';
if (isset($_POST['voto']) && $_POST['id_plato'] != '') {
    //Conexión con la base de datos
    $db = new mysqli("localhost", "root", "uniroot", "chefmi");
    $db->set_charset("UTF8");
    if ($db->connect_error) {
        var_dump($db->connect_error);
        die;
    }

    $query = "SELECT v.id_voto FROM votos v JOIN votos_platos vp ON vp.id_voto=v.id_voto WHERE v.id_usuario=" . $_SESSION["user_login"] . " AND vp.id_plato=" . $_POST['id_plato'];
    if ($voto = $db->query($query)) {
        if ($voto->num_rows < 1) {
            $query = "INSERT INTO votos (id_usuario, voto) VALUES (" . $_SESSION["user_login"] . ", " . $_POST['voto'] . ")";
            $result = $db->query($query);
            if ($result) {
                $id_voto = (int) $db->insert_id;
                $query = "INSERT INTO votos_platos (id_voto, id_plato) VALUES (" . $id_voto . ", " . $_POST['id_plato'] . ")";
                $result = $db->query($query);
                if ($result) {
                    if ($result = $db->query("SELECT SUM(v.voto)/COUNT(v.voto) as voto FROM platos p JOIN votos_platos vp ON vp.id_plato=p.id_plato JOIN votos v ON v.id_voto=vp.id_voto WHERE p.id_plato =" . $_POST['id_plato'])) {
                        if ($result->num_rows > 0) {
                            $query = "UPDATE platos SET votos = " . (int) $result->fetch_assoc()['voto'] . " WHERE id_plato =" . $_POST['id_plato'];
                            $result = $db->query($query);
                            if ($result) {
                                echo 'Voto realizado con éxito';
                            }else{
                                echo $mensaje_error." 7";
                            }
                        }else{
                            echo $mensaje_error." 6";
                        }
                    }else{
                        echo $mensaje_error." 5";
                    }
                }else{
                    echo $mensaje_error." 4";
                }
            }else{
                echo $mensaje_error." 3";
            }
        } else {
            echo 'Ya has votado esta receta';
        }
    }else{
        echo $mensaje_error." 2";
    }
} else {
    echo $mensaje_error." 1";
}
