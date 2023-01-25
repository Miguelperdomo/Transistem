<?php
   /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
   session_start();
   include("../../../../includes/validarsession.php");
   require("../../../../connections/connection.php");//conexión a la BD

   /* Obtener el valor de las variable de sesión "Globales" y asignarlo a otras variable ``. */
   $doc=$_SESSION['doc'];
   $rol=$_SESSION['rol'];
   $name=$_SESSION['nameu'];

   /* Una consulta a la base de datos trayendo las tablas rol y usuarios y concatenando el id_rol con usuarios y el id_usu con la variable Global session  */
   $sql= "SELECT * FROM rol, usuarios where rol.id_rol = usuarios.id_rol and id_usu = $doc"; 
   $resultado=$base->prepare($sql);
   $resultado->execute(array());
   $reg=$resultado->fetch(PDO::FETCH_ASSOC);

   /* Obtener el rol y la foto del usuario de la base de datos de arriba. */
   $nomrol=$reg["rol"];
   $usu = $reg["foto"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../css/dashuser.css">
    <link rel="stylesheet" href="../../../../css/style.css">
    <link rel="icon" href="../../../../img/bus.png">
</head>

<body>
    <!--Barra cabecera-->
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light"><img src="../../../../img/logo_blanco.png" alt="logo" width="200px"></h4>
            </div>
            <div class="col-4 text-right barra">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="../../perfil.php?id=<?php echo $doc ?>">
                                <i class="fas fa-user m-1"></i>Perfil</a>
                            <a class="dropdown-item menuperfil cerrar" href="../../../../includes/close.php">
                                <i class="fas fa-sign-out-alt m-1"></i>Salir</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                    <a href="../../admin.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../../users.php"><i class="fa-solid fa-address-book"></i><span>Gestión Usuarios</span></a>
                    <a href="../../system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestión Sistema</span></a>
                    
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Reportes de usuarios</h3>
                    </div>
                   
                    <br> <br> <br> 
                    <a href="../users.php"><button type="button" class="btn btn-sm btn-primary"><img src="../../../../img/turn-left.png" width="20" height="20" alt="turn-left"></button></a>
                                        
                    <div class="row ancho">
                        <br>
                        <div></div>
                        <div class="col-6">
                            <div class="container">

                                <h5 class="mb-0 ">Usuarios Activos</h5><br>
                                <a href="reporteclact.php"><button class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button></a>
                                <a href="activopdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                                <a href="cliactpdfx.php" target="blank"><button class="btn btn-info"><i class="fa-solid fa-print"></i></button></a>
                                <br> <br> 
                            </div>
                        </div>
                       
                        <div class="col-6">
                            <div class="container">

                                <h5 class="mb-0 ">Usuarios Inactivos</h5><br>
                                <a href="reporteclinac.php"><button class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button></a>
                                <a href="inactpdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                                <a href="inacim.php" target="blank"><button class="btn btn-info"><i class="fa-solid fa-print"></i></button></a>
                                <br> <br> 

                            </div>
                        </div>

                    </div>
                    
                     
                </div>   
                <br> 
            </main>
            <!--FIN del cont principal-->
        </div>
    </div>
    <script src="loginvalida.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>