<html>
<?php
$exito = '';
$error = '';
if (isset($_POST['email'])) {
    //Conexión con la base de datos
    $db = new mysqli("localhost", "root", "uniroot", "chefmi");
    $db->set_charset("UTF8");
    if ($db->connect_error) {
        var_dump($db->connect_error);
        die;
    }

    $query = "SELECT id_usuario FROM usuarios WHERE email LIKE '" . $_POST['email'] . "'";
    if ($usuario = $db->query($query)) {
        if ($usuario->num_rows > 0) {
            $code = mt_rand(100000, 999999);
            $query = "UPDATE usuarios SET perdida = '" . $code . "' WHERE email LIKE '".$_POST['email']."'";
            $result = $db->query($query);
            if ($result) {
                require_once 'Mail.php';
                require_once 'Mail/mime.php';
                require_once 'Mail/mail.php';

                $from = '<chefmi-info@chefmi.es>';
                $to = '<' . $_POST['email'] . '>';
                $subject = 'Recuperar contraseña - Chefmi';

                $headers = array(
                    'From' => $from,
                    'To' => $to,
                    'Subject' => $subject
                );

                $smtp = Mail::factory('smtp', array(
                    'host' => 'ssl://smtp.sendgrid.net',
                    'port' => '465',
                    'auth' => true,
                    'username' => "apikey",
                    'password' => "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"
                ));

                $text = 'Has solicitado un cambio de contraseña, para ello accede al siguiente enlace: http://192.168.0.23:81/cambiar.php?id='.$code;
                $html = '<html><body>Has solicitado un cambio de contraseña, para ello accede al siguiente enlace: <a href="http://192.168.0.23:81/cambiar.php?id='.$code.'">cambiar contraseña</a></body></html>';
                // $crlf = "\n";

                // $mime = new Mail_mime($crlf);
                $mime = new Mail_mime();
                $mime->setTXTBody($text);
                $mime->setHTMLBody($html);

                $mimeparams = array();
                $mimeparams['text_encoding'] = "8bit";
                $mimeparams['text_charset'] = "UTF-8";
                $mimeparams['html_charset'] = "UTF-8";
                $mimeparams['head_charset'] = "UTF-8";

                $body = $mime->get($mimeparams);
                $headers = $mime->headers($headers);

                $mail = $smtp->send($to, $headers, $body);

                if (PEAR::isError($mail)) {
                    $error = "Ha ocurrido un error al enviar el mensaje, por favor inténtalo de nuevo";
                } else {
                    $exito = "Hemos enviado un email a la dirección de correo proporcionada";
                }
            } else {
                $error = "Ha ocurrido un error al enviar el mensaje, por favor inténtalo de nuevo";
            }
        } else {
            $error = "El email no corresponde al de ningún usuario";
        }
    }
}
include('static.php');
?>
    <h3 id="adminBar">Recuperar contraseña</h3>
    <div class="session">
        <form method="post">
            <p>Inserta el email con el que creaste tu cuenta y te enviaremos las instrucciones para crear una nueva contraseña</p>
            <label for="email"> Introduzca su email</label></br>
            <input type="email" id="email" name="email" required></br>
            <input type="submit" id="recuperar" value="Enviar email"></br>
            <p id="mensaje-error"><?php echo $error; ?></p>
            <p id="mensaje-exito"><?php echo $exito; ?></p>
        </form>
    </div>
</body>

</html>