<?php
    require_once("../connections/connection.php");

    $email = $_POST['email'];

    /* Este es un script PHP que se utiliza para enviar un correo electrónico al usuario para cambio de clave. */
    $sql= "SELECT * FROM usuarios where email = :id"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$email));
    $regi=$resultado->fetch(PDO::FETCH_ASSOC);

    // Varios destinatarios
    $para  =$regi['email']; // atención a la coma
    //$para .= 'wez@example.com';

    // título
    $título = 'Restablecer contraseña de acceso.';
    $codigo = rand(1000,9999);


    // mensaje
    $mensaje = '
<html>
<head>
  <title>Restablecer</title>
</head>
<body>
    <h1>Puriestur</h1>
    <div style="text-align:center">
        <img src="https://i.pinimg.com/originals/dd/39/20/dd3920023053d660b2452c96f2559e10.jpg" width="250" alt="Transistem">
        <p>Restablecer contraseña</p>
        <h3>'.$codigo.'</h3>
        <p> <a 
            href="http://localhost/transistem/includes/reset.php?email='.$email.'&token='.$token.'"> 
            Para restablecer dar Click Aqui! </a> </p>
        <p> <small>Si usted no envió este código, por favor verifique su cuenta iniciando sesión. </small> </p>
        <a 
            href="http://localhost/transistem/login.php"> 
            Acceda a Transistem </a> </p>
    </div>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
/*
// Cabeceras adicionales
$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$cabeceras .= 'From: Recordatorio <cumples@example.com>' . "\r\n";
$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
*/
// Enviarlo
$enviado = false;
if(mail($para, $título, $mensaje, $cabeceras)){
    $enviado = true;
}

?>