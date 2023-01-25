<?php
    /* Incluido el archivo connection.php. */
    session_start();
    include("../../connections/connection.php");
    
    require_once("../../connections/connection.php");
    
    /* Configuración de las variables de sesión. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

    /* Obteniendo los datos de la base de datos. */
    $sql1= "SELECT * FROM rol, usuarios where rol.id_rol = usuarios.id_rol and id_usu = $doc"; 
    $resultado=$base->prepare($sql1);
    $resultado->execute(array());
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);
 
    $nomrol=$reg["rol"];
    $usu = $reg["foto"];
   
    $busca=$_GET["id"];

   /* Uniendo las tablas y seleccionando los datos de las tablas. */
//    consulta en ordenes, detalle ordenes y solicitudes
    $sql="SELECT * from detalle_ord, orden_ser, solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad, detalle_vehi where detalle_ord.id_soli=orden_ser.id_soli and detalle_ord.id_est=estado.id_est and orden_ser.id_soli=solicitud.id_soli and solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino and destino.id_ciudad=ciudad.id_ciudad and detalle_ord.id_detave=detalle_vehi.id_detave and orden_ser.id_soli = $busca";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $solicitud=$resultado->fetch(PDO::FETCH_ASSOC);

    $ori=$solicitud['id_origen'];
    $detavehi=$solicitud['id_detave'];
    
    $sql="SELECT  * from origen, ciudad where origen.id_ciudad = ciudad.id_ciudad and id_origen = $ori";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $origen=$resultado->fetch(PDO::FETCH_ASSOC); 

    //consulta a detalle orden relacionada con detalle vehiculo
    $sql2="SELECT * from detalle_ord, detalle_vehi, solicitud, regis_veh, marcas, tipo_veh, usuarios where detalle_ord.id_detave=detalle_vehi.id_detave and detalle_ord.id_soli=solicitud.id_soli and detalle_vehi.placa=regis_veh.placa and regis_veh.id_marca=marcas.id_marca and regis_veh.id_tip_veh=tipo_veh.id_tip_veh and detalle_vehi.id_usu=usuarios.id_usu and detalle_ord.id_detave=$detavehi";
    $resultado=$base->prepare($sql2);
    $resultado->execute(array());
    $vehi=$resultado->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashuser.css">
    <link rel="stylesheet" href="../../css/stylecusto.css">
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
        <div class="row">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                    <a href="cliente.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="solicitud.php"><i class="fa-solid fa-address-book"></i><span>Solicitar Servicio</span></a>
                    <a href="estadosoli.php"><i class="fa-solid fa-clipboard"></i><span>Estado de Solicitudes</span></a>
                    <a href="contrato.php"><i class="fa-solid fa-clipboard"></i><span>Contratos Generados</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Servicio programado</h3>
                    </div>
                </div>
                <div class="container center4">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Contrato N°</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['id_auto']?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Solicitud N°</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['id_soli'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Estado</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['tip_est'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <!-- Espacio vacio Dejar -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5>Datos Cliente</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>N. Documento</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['id_usu'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Nombre</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['nom_usu'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <!-- Espacio vacio Dejar -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5>Datos del servicio</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Servicio</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['servi'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Origen</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $origen['ciudad'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">                            
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Destino</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $solicitud['ciudad'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">                           
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Fecha Inicio</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center" readonly name="fechain" value="<?php echo $solicitud['fech_ini']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Fecha Final</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center" readonly name="fechafin" value="<?php echo $solicitud['fech_fin']?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Hora Inicial</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center"  readonly name="hora" value="<?php echo $solicitud['hora_ini']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Número Días</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center"  readonly name="dia" value="<?php echo $solicitud['n_dias']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Número Pasajeros</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center"  readonly name="pasajeros" value="<?php echo $solicitud['n_pasa']?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5>Recomendaciones adicionales</h5>
                        <div class="input-group input-group">
                            <input type="text" name="reco" class="form-control fs-5" aria-label="Large" readonly value="<?php echo $solicitud['recomend']?>" aria-describedby="inputGroup-sizing-sm ">
                        </div>
                        <br>
                        <h5>Datos del conductor</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Nombre</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center"  readonly name="nomco" value="<?php echo $vehi['nom_usu']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Teléfono</strong></span>
                                    </div>
                                    <input type="number" class="form-control text-center" readonly name="telco" value="<?php echo $vehi['tel']?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5>Datos vehículo</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Tipo</strong></span>
                                    </div>
                                    <input type="varchar" class="form-control text-center"  readonly name="tipve" value="<?php echo $vehi['tip_veh']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Marca</strong></span>
                                    </div>
                                    <input type="varchar" class="form-control text-center" readonly name="marc" value="<?php echo $vehi['marca']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Placa</strong></span>
                                    </div>
                                    <input type="varchar" class="form-control text-center" readonly name="pla" value="<?php echo $vehi['placa']?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <a href="./pdfsoli.php?id=<?php echo $solicitud['id_soli'];?>"><button type="button" class="btn btn-danger">PDF</button></a> -->
                            <a href="./contrato.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                        </div>
                    </form>
                </div>
            </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>