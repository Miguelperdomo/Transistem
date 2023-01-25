<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../includes/validarsession.php");
    require_once("../../connections/connection.php");

     /* Obtener el valor de las variable de sesión "Globales" y asignarlo a otras variable ``. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

    /* Una consulta a la base de datos trayendo las tablas rol y usuarios y concatenando el id_rol con usuarios y el id_usu con la variable Global session  */
    $sql= "SELECT * FROM rol, usuarios, tipo_cliente, ident, estado where rol.id_rol = usuarios.id_rol 
        and tipo_cliente.id_tip_clien = usuarios.id_tip_clien and ident.id_ident = usuarios.id_ident 
        and estado.id_est = usuarios.id_est and id_usu = $doc"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);

    $nomrol=$reg["rol"];
    $password=$reg["pass"];
    $usu = $reg["foto"];
    $name=$reg["nom_usu"];
    $tipide = $reg["ident"];
    $tipcli=$reg["tip_clien"];
    $dire = $reg["dir"];
    $tele=$reg["tel"];
    $ema = $reg["email"];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashuser.css">
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
                    <li><!-- Muestra el nombre y rol de conductor y su foto correspondiente -->
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                             <!-- Este es el boton de ver perfil y salir de Jefe Operaciones -->
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
        <div class="row">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                     <!-- Este es el menu lateral del Jefe Operaciones-->     
                    <a href="jefeope.php"><i class="fa-solid fa-house"></i><span>Inicio</span></a>
                    <a href="ordenes.php"><i class="fa-solid fa-bus"></i><span>Ordenes de Servicio</span></a>
                    <a href="servicios.php"><i class="fa-sharp fa-solid fa-id-card"></i></i><span>Historial Servicio</span></a>
                    <a href="conduc.php"><i class="fa-solid fa-user-tie"></i><span>Gestionar Conductor</span></a>
                    <a href="vehi.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Vehiculos</span></a>
                    <a href="system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Perfil de Usuario</h3>
                    </div>
                    <br>
                            <!-- Creación de un formulario con la información del usuario.-->
                            <div class="container center4">
                                <div class="modal-body">
                                    <form> 
                                        <div class="col-auto">
                                            <td><?php echo (' <img src="../../fotos/'.$usu.'"  width="100" alt="Foto perfil"> ')?></td>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Identidad</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center"  readonly name="ide" value="<?php echo $tipide?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Documento</div>
                                                </div>
                                                <input type="text" class="form-control text-center"  readonly name="idr" value="<?php echo $doc?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Nombre Usuario</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly name="nom" value="<?php echo $name?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rol</div>
                                                </div>
                                                <td>
                                                    <input type="text" class="form-control text-center"  readonly name="rol" value="<?php echo $nomrol?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Cliente</div>
                                                </div>
                                                <td>
                                                    <input type="text" class="form-control text-center"  readonly name="tip" value="<?php echo $tipcli?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Direccion</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly  name="dir" value="<?php echo $dire?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Telefono</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly  name="tel" value="<?php echo $tele?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Email</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly  name="email" value="<?php echo $ema?>">
                                            </div>
                                        </div>
                                        <br>                         
                                        <div class="col-auto">

                                            <!-- Un código PHP que se utiliza para editar el perfil del usuario.-->
                                            <a href="perfil/edit.php?id=<?php echo $doc ?> & pas= <?php $password ?>"><button type="button" class="btn btn-primary">Editar</button></a>

                                            <!-- Crear un botón que enlace a una página que permita la
                                            usuario para cambiar su foto de perfil. -->
                                            <a href="perfil/foto.php?id=<?php echo $doc ?>"><button type="button" class="btn btn-warning">Cambiar Foto</button></a>

                                            <!-- Crear un botón que llevará al usuario a una página
                                            donde pueden cambiar su contraseña. -->
                                            <a href="perfil/cambiarpass.php?id=<?php echo $doc ?>"><button type="button" class="btn btn-danger">Cambiar Contraseña</button></a><br><br>
                                            <a href="jefeope.php"><button type="button" class="btn btn-secondary">Volver</button></a><br><br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                     </div>
                    </div>
            </main>
    <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>