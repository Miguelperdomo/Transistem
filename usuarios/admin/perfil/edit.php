<?php
 /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../includes/validarsession.php");

    require_once("../../../connections/connection.php");

    /*Variables globales */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

    // Consulta para ver registro usuario
    $busca=$_GET["id"];

    /* Consulta a la database. */
    $sql= "SELECT * FROM rol, usuarios, tipo_cliente, ident, estado where rol.id_rol = usuarios.id_rol 
    and tipo_cliente.id_tip_clien = usuarios.id_tip_clien and ident.id_ident = usuarios.id_ident 
    and estado.id_est = usuarios.id_est and id_usu = $busca"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $reg1=$resultado->fetch(PDO::FETCH_ASSOC);

    $rol=$reg1["rol"];
    $usu = $reg1["foto"];
    $nom=$reg1["nom_usu"];
    $tipide = $reg1["ident"];
    $tipcli=$reg1["tip_clien"];
    $dire = $reg1["dir"];
    $tele=$reg1["tel"];
    $ema = $reg1["email"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/dashuser.css">
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="icon" href="../../../img/bus.png">

</head>

<body>
    <!--Barra cabecera-->
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light"><img src="../../../img/logo_blanco.png" alt="logo" width="200px"></h4>
            </div>
            <div class="col-4 text-right barra">
                <ul class="navbar-nav mr-auto">
                     <!-- /* Un menú desplegable que muestra el perfil del usuario y la opción de cerrar la sesión. */ -->
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $rol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="../perfil.php?id=<?php echo $doc ?>">
                                <i class="fas fa-user m-1"></i>Perfil</a>
                            <a class="dropdown-item menuperfil cerrar" href="../../../includes/close.php">
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
                    <a href="../admin.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../users.php"><i class="fa-solid fa-address-book"></i><span>Gestión Usuarios</span></a>
                    <a href="../system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestión Sistema</span></a>
                    
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Editar perfil</h3>
                    </div>
                    <br>
                    <div class="container center4">
                            <div class="modal-body">
                                <form method="post" action="validedit.php" autocomplete="off">
                                <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Tipo docu.</div>
                                            </div>
                                            <input type="text" class="form-control" readonly value="<?php echo $tipide?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Tipo persona</div>
                                            </div>
                                            <input type="text" class="form-control" readonly value="<?php echo $tipcli?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Documento</div>
                                            </div>
                                            <input type="number" class="form-control" readonly name="idr" value="<?php echo $reg1["id_usu"]?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Nombre Usuario</div>
                                            </div>
                                            <input type="text" class="form-control" name="nom" value="<?php echo $nom?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Direccion</div>
                                            </div>
                                            <input type="varchar" class="form-control"  name="dir" value="<?php echo $dire?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Telefono</div>
                                            </div>
                                            <input type="number" class="form-control"  name="tel" value="<?php echo $tele?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Email</div>
                                            </div>
                                            <input type="email" class="form-control"  name="email" value="<?php echo $ema?>">
                                        </div>
                                    </div>

                                        <br>                          
                                        <div class="modal-footer">
                                            <a href="../perfil.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                            <input  type="submit" class="btn btn-blue" name="edita" value="Guardar" >
                                        </div>
                                    </form>
                                </div>
                            </div>
                     </div>
                    </div>
            </main>
    <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="../../../js/eliminar.js"></script>
</body>

</html>