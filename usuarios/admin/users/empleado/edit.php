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

      // Consulta para ver registro usuarios
    $busca=$_GET["id"];    

    /* Una consulta a la base de datos. */
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
                        <h3 class="mb-0 ">Editar Usuario</h3>
                    </div>
                    <br>
                        <div class="container center4">
                            <div class="modal-body">
                                <form method="post" action="validedit.php">
                                <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Tipo documento</div>
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
                                        <div class="input-group col ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rol</div>
                                            </div>
                                            <td>
                                                <select class="form-control" name="rol" >
                                                    <option value="0">Seleccionar:</option>
                                                    <?php
                                                    $sql4= "SELECT * FROM rol";
                                                    $resultado=$base->prepare($sql4);
                                                    $resultado->execute(array());
                                                    while($rols=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <option value="<?php echo $rols['id_rol'];?>"><?php echo $rols['rol']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Documento</div>
                                            </div>
                                            <input type="number" class="form-control" name="idr" value="<?php echo $reg1["id_usu"]?>">
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
                                        <div class="input-group col ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Tipo Estado</div>
                                            </div>
                                            <td>
                                                <select class="form-control" name="est" >
                                                    <option value="0">Seleccionar:</option>
                                                    <?php
                                                    $sql2= "SELECT * FROM estado  limit 2";
                                                    $resultado=$base->prepare($sql2);
                                                    $resultado->execute(array());
                                                    while($estado=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <option value="<?php echo $estado['id_est'];?>"><?php echo $estado['tip_est']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
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
                                        <a href="../users.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                        <input  type="submit" class="btn btn-blue" name="edita" value="Guardar" >
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
            </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>