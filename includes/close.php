<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<!-- /* Cerrar la sesión y redirigir a la página index.html. */ -->
	<?php 
	// Para cerrar las sesiones 
	session_start();
	session_destroy();
	header("Location: ../index.html");
	exit();
	?>
</body>
</html>