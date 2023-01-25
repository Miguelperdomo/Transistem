<?php
    
    require_once("../../connections/connection.php");
 
   /* Una consulta SQL que va seleccionando todas las columnas de la tabla "solicitud" y uniéndola con la
   otras mesas. */
    $busca=$_GET["id"];

    $sql="SELECT * FROM `solicitud` 
    INNER JOIN usuarios ON solicitud.id_usu = usuarios.id_usu 
    INNER JOIN servicios ON solicitud.id_ser = servicios.id_ser
    INNER JOIN estado ON solicitud.id_est = estado.id_est
    INNER JOIN rutas ON solicitud.id_ruta =rutas.id_ruta 
    INNER JOIN origen ON rutas.id_origen = origen.id_origen 
    INNER JOIN destino ON rutas.id_destino = destino.id_destino
    INNER JOIN ciudad ON destino.id_ciudad = ciudad.id_ciudad AND id_soli = $busca";

    /* Obteniendo el id_origen de la base de datos. */
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $solicitud=$resultado->fetch(PDO::FETCH_ASSOC);

    $ori=$solicitud['id_origen'];
    
   /* Seleccionando todos los datos de la tabla origen y ciudad donde el id_origen es igual al
    variable . */
    $sql="SELECT  * from origen, ciudad where origen.id_ciudad = ciudad.id_ciudad and id_origen = $ori";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $origen=$resultado->fetch(PDO::FETCH_ASSOC);    
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
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Solicitud Servicio</h3>
                    </div>
                </div>
                <div class="container center4">
                    <form method="POST" action="">
                        <div class="row">
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
                        <div class="modal-footer">                          
                            <a href="listo.php?id=<?php echo $solicitud['id_usu'];?>"><button type="button" class="btn btn-secondary">Volver</button></a>
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