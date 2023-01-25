<?php
    require_once("../../../connections/connection.php");

    $email = $_GET['email'];
 /* Este es un script PHP que se utiliza para enviar un correo electrónico al usuario que ha sido activado. */
    $sql= "SELECT * FROM usuarios where email = :id"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$email));
    $regi=$resultado->fetch(PDO::FETCH_ASSOC);

    // Varios destinatarios
    $para  =$regi['email']; 
    //$para .= 'wez@example.com';

    // título
    $título = 'Activación Usuario Transistem.';

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
        <h3>Activación Usuario Transistem</h3>
        
        <p> Ha sido activado en el sistema Transistem. Podrá Iniciar Sesión con su número de documento y la clave designada en el registro.</p>
        <br>
        <p> <small>Se recomienda Actualizar su contraseña una vez ingresado al sistema. Puede realizarlo desde su Perfil. </small> </p>
        <a href="http://localhost/transistem/login.php"> 
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