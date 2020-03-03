<?php
// var_dump($_POST);


    $nombre= $_POST['name'];
    $correo= $_POST['email'];
    $tipo_receta = $_POST['type'];
    $ingredientes= $_POST['ingredients'];
    $preparacion= $_POST['steps'];

    $to = "miriam.martinba93@gmail.com";
    $subject = 'Nueva receta';
    
    $message = '<h1>Nueva receta:</h1>';
    $message .= 'Nombre: '.$nombre;
    $message .= '<h2>Ingredientes</h2>';
    $message .= $ingredientes;
    $message .= '<h2>Preparación</h2>';
    $message .= $preparacion;
    

    if(mail($to, $subject, $message)){
        echo "Se ha enviado correctamente";
    }else{
        echo "Error al enviar el correo";
    }


?>