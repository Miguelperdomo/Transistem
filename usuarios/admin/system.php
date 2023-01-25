<?php
/* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../includes/validarsession.php");

    require_once("../../connections/connection.php");


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
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/bus.png">

</head>

<body>
    <!--Barra cabecera-->
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light"><img src="../../img/logo_blanco.png" alt="logo" width="200px"></h4>
            </div>
            <div class="col-4 text-right barra">
                <ul class="navbar-nav mr-auto">
                     <!-- /* Un menú desplegable que muestra el perfil del usuario y la opción de cerrar la sesión. */ -->
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>

                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="perfil.php?id=<?php echo $doc ?>">
                                <i class="fas fa-user m-1"></i>Perfil</a>
                            <a class="dropdown-item menuperfil cerrar" href="../../includes/close.php">
                                <i class="fas fa-sign-out-alt m-1"></i>Salir</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row ">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                    <a href="admin.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="users.php"><i class="fa-solid fa-address-book"></i><span>Gestión Usuarios</span></a>
                    <a href="system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestión Sistema</span></a>
                    
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                
                <div class="row">
                    <div class="container">
                        <img src="../../img/config.png" alt="usu" width="120px" class="center">
                    </div>
                </div>
                <br>
                <br>
                <!-- /* Un div que contiene dos botones que redirigen a otras páginas */ -->
                <div class="container">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="panel">
                                    <a href="system/iden.php"><div><button type="button" class="btn btn-blue tam1">Identificación</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/estado.php"><div><button type="button" class="btn btn-blue tam1">Estados</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/servicio.php"><div><button type="button" class="btn btn-blue tam1">Servicios</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/tipcli.php"><div><button type="button" class="btn btn-blue tam1">Tipo personas</button></div></a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="panel">
                                    <a href="system/crearuta.php"><div><button type="button" class="btn btn-blue tam1">Rutas</button></div></a>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="panel">
                                    <a href="system/turno.php"><div><button type="button" class="btn btn-blue tam1">Turnos</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/tipvehi.php"><div><button type="button" class="btn btn-blue tam1">Tipo Vehículos</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/carroce.php"><div><button type="button" class="btn btn-blue tam1">Carrocería</button></div></a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="panel">
                                    <a href="system/marca.php"><div><button type="button" class="btn btn-blue tam1">Marcas</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/vinculo.php"><div><button type="button" class="btn btn-blue tam1">Vínculo</button></div></a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="panel">
                                    <a href="system/modelo.php"><button type="button" class="btn btn-blue tam1">Modelo</button></a>
                                </div>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div> 
                </div>
            </main>
        </div>
    </div>
    <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>