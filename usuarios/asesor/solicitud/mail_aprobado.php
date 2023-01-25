<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../includes/validarsession.php");

    require_once("../../../connections/connection.php"); 

    /* Este es un script PHP que se utiliza para enviar un correo electrónico al usuario que ha sido aprobado. */
    $email = $_GET['email'];

    $sql= "SELECT * FROM usuarios where email = :id"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$email));
    $regi=$resultado->fetch(PDO::FETCH_ASSOC);

    // Varios destinatarios
    $para  =$regi['email']; 
    //$para .= 'wez@example.com';

    // título
    $título = 'Solicitud Aprobada.';

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
        <h3>Solicitud de servicio Aprobada</h3>
        
        <p> Por favor verifique el estado de su solicitud en el sistema. En el transcurso de la semana se enviará un correo confirmando programación de la ruta contratada.</p>
        <a 
            href="http://localhost/transistem/index.html"> 
            Acceda a Transistem Aquí </a> </p>
    </div>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Enviarlo
$enviado = false;
if(mail($para, $título, $mensaje, $cabeceras)){
    $enviado = true;
}

?>