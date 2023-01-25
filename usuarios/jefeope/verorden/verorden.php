<?php
 /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require_once("../../../connections/connection.php");

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

    /* Obtener el id y el ser de la URL. */
    $busca=$_GET["id"];
    $busca1=$_GET["ser"];

  
   
    /* Una consulta a la base de datos. */
   /* Seleccionando todos los datos de la tabla regis_vehi, vinculo, tipo_veh, modelo, marcas, carroceria,
   estado donde el id_tip_vincu es igual al id_tip_vincu en la tabla vinculo y así sucesivamente. */
    $sql="SELECT * FROM `orden_ser` 
    INNER JOIN solicitud ON orden_ser.id_soli=solicitud.id_soli
    INNER JOIN servicios ON solicitud.id_ser = servicios.id_ser
    INNER JOIN estado ON solicitud.id_est = estado.id_est
    INNER JOIN rutas ON solicitud.id_ruta =rutas.id_ruta 
    INNER JOIN origen ON rutas.id_origen = origen.id_origen 
    INNER JOIN destino ON rutas.id_destino = destino.id_destino
    INNER JOIN ciudad ON destino.id_ciudad = ciudad.id_ciudad
    AND id_auto = '$busca' "; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $regveh=$resultado->fetch(PDO::FETCH_ASSOC);

    $ori=$regveh['id_origen'];
    
    /* Seleccionando todos los datos de la tabla origen y ciudad donde el id_origen es igual al
    variable. */
    $sql="SELECT  * from origen, ciudad where origen.id_ciudad = ciudad.id_ciudad and id_origen = $ori";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $origen=$resultado->fetch(PDO::FETCH_ASSOC);


    $auto = $regveh["id_auto"];
    $soliciutd = $regveh["id_soli"];
    $dias = $regveh ["n_dias"];
    $pasajeros = $regveh["n_pasa"];
    $servicio=$regveh["servi"];
    $fechaini=$regveh["fecha_ini_real"];
    $fechafin=$regveh["fecha_fin_real"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
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
                    <li><!-- Muestra el nombre y rol de conductor y su foto correspondiente -->
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <!-- Este es el boton de ver perfil y salir de Jefe Operaciones -->
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
                    <!-- Este es el menu lateral del Jefe Operaciones-->           
                    <a href="../jefeope.php"><i class="fa-solid fa-house"></i><span>Inicio</span></a>
                    <a href="../ordenes.php"><i class="fa-solid fa-bus"></i><span>Ordenes de Servicio</span></a>
                    <a href="../servicios.php"><i class="fa-sharp fa-solid fa-id-card"></i></i><span>Historial Servicio</span></a>
                    <a href="../conduc.php"><i class="fa-solid fa-user-tie"></i><span>Gestionar Conductor</span></a>
                    <a href="../vehi.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Vehiculos</span></a>
                    <a href="../system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Historial Servicios </h3>
                    </div>
                    <br>
                            <!-- Creación de un formulario con los datos de la base de datos. -->
                            <div class="container center4">
                                <div class="modal-body">
                                    <form>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">ID</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center"  readonly name="auto" value="<?php echo $auto?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Solicitud N.</div>
                                                </div>
                                                <input type="number" class="form-control text-center"  readonly name="solicitud" value="<?php echo $soliciutd?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Servicio</div>
                                                </div>
                                                <input type="text" class="form-control text-center"  readonly name="servicio" value="<?php echo $servicio?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Destino</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly name="fecha" value="<?php echo $origen['ciudad'] ?> - <?php echo $regveh['ciudad'] ?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Numero Pasajeros</div>
                                                </div>
                                                <td>
                                                    <input type="number" class="form-control text-center"  readonly name="pasajeros" value="<?php echo $pasajeros?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Numero Dias</div>
                                                </div>
                                                <td>
                                                    <input type="number" class="form-control text-center"  readonly name="dias" value="<?php echo $dias?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Fecha Inicial</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly name="fechaini" value="<?php echo $fechaini?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Fecha Final</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly name="fecha" value="<?php echo $fechafin?>">
                                            </div>
                                        </div>
                                        <br>                            
                                        <div class="col-auto">
                                            <a href="../servicios.php"><button type="button" class="btn btn-secondary">volver</button></a>
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