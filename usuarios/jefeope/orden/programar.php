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

    /* Obtener la identificación y el correo electrónico de la URL. */
    $orden = $_GET["id"];
    

    /* Seleccionar todos los datos de la base de datos y colocarlos en una matriz. */
    $sql="SELECT * from orden_ser, solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
    where orden_ser.id_soli=solicitud.id_soli and solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est 
    and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
    and destino.id_ciudad=ciudad.id_ciudad and orden_ser.id_auto = $orden";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $regist=$resultado->fetch(PDO::FETCH_ASSOC);

    $ori=$regist['id_origen'];    
    
    /* Seleccionando todos los datos de la tabla origen y ciudad donde el id_origen es igual al
    variable $ori. */
    $sql="SELECT  * from origen, ciudad where origen.id_ciudad = ciudad.id_ciudad and id_origen = $ori";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $origen=$resultado->fetch(PDO::FETCH_ASSOC); 

  /* El código anterior está comprobando si se ha hecho clic en el botón Insertar. */
    if(isset($_POST['insert'])){

        /* Comprobando si el valor de la variable "vehiculo" es igual a 0. */
        if($_POST['vehiculo']==0){

            echo '<script>alert("Selecione el tipo de vehiculo para continuar.");</script>';
            echo '<script>window.location= "../verord.php"</script>';
        }else{
            $email = $_GET['email'];
            $soli=$_POST['soli'];
            $vehi=$_POST['vehiculo'];
            $estado=4;

            /* Inserción de datos en una tabla. */
            $sql="INSERT INTO detalle_ord (id_soli, id_detave, id_est ) values (:so, :ve, :es )";
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":so"=>$soli, ":ve"=>$vehi, ":es"=>$estado));

           /* Obteniendo los datos de la base de datos. */
            $sql= "SELECT * FROM detalle_vehi, regis_veh where detalle_vehi.placa=regis_veh.placa and detalle_vehi.id_detave=$vehi "; 
            $resultado=$base->prepare($sql);
            $resultado->execute(array());
            $regist=$resultado->fetch(PDO::FETCH_ASSOC);

            $vehicu=$regist['placa'];
            $estVehi=7;

           /* Actualización de la tabla regis_veh con los valores de las variables */
            $sql="UPDATE regis_veh SET id_est=:est WHERE placa=:pl";
            $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
            $resultado->execute(array(":pl"=>$vehicu, ":est"=>$estVehi));

            $estSoli=4;

            /* Actualizando la tabla "solicitud" con los valores de las variables */
            $sql="UPDATE solicitud SET id_est=:est WHERE id_soli=:id";
            $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
            $resultado->execute(array(":id"=>$soli, ":est"=>$estSoli));//asigno las variables a los marcadores

            /* Incluyendo el archivo mail_programado.php */
            include "mail_programado.php";

            echo '<script>alert("Orden de servicio Programada.");</script>';
            echo '<script>window.location= "../ordenes.php"</script>';
        }
    }
    
    /* Comprobando si el boton "adicion" esta pulsado. */
    if(isset($_POST['adicion'])){

        /* Comprobando si el valor de la variable "vehiculo" es igual a 0. */
        if($_POST['vehiculo']==0){

            echo '<script>alert("Selecione el tipo de vehículo para continuar.");</script>';
            echo '<script>window.location= "../verord.php"</script>';
        }else{

            header("Location:programar.php?id=$orden");

            $soli=$_POST['soli'];
            $vehi=$_POST['vehiculo'];
            $estado=4;

           /* Inserción de datos en la base de datos. */
            $sql="INSERT INTO detalle_ord (id_soli, id_detave, id_est ) values (:so, :ve, :es )";
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":so"=>$soli, ":ve"=>$vehi, ":es"=>$estado));

            /* Obtener los datos de la base de datos y almacenarlos en la variable. */
            $sql= "SELECT * FROM detalle_vehi, regis_veh where detalle_vehi.placa=regis_veh.placa and detalle_vehi.id_detave=$vehi "; 
            $resultado=$base->prepare($sql);
            $resultado->execute(array());
            $regist=$resultado->fetch(PDO::FETCH_ASSOC);

            $vehicu=$regist['placa'];
            $estVehi=7;

            /*Actualización de la tabla regis_veh con los valores de las variables */
            $sql="UPDATE regis_veh SET id_est=:est WHERE placa=:pl";
            $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
            $resultado->execute(array(":pl"=>$vehicu, ":est"=>$estVehi));//asigno las variables a los marcadores

            $estSoli=4;
           
           /* Actualizando la tabla "solicitud" con los valores de las variables */
           $sql="UPDATE solicitud SET id_est=:est WHERE id_soli=:id";
           $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
           $resultado->execute(array(":id"=>$soli, ":est"=>$estSoli));//asigno las variables a los marcadores

            
        }
    }
    
    if(isset($_POST['cancelar'])){

            $solici=$_POST['soli'];
            $vehiculo=$_POST['vehiculo'];
            $estVehi=6;
            $estSoli=5;

            $sql="DELETE FROM detalle_ord WHERE id_soli=:id";
            $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
            $resultado->execute(array(":id"=>$solici));//asigno las variables a los marcadores
            
            $sql="UPDATE regis_veh SET id_est=:est WHERE placa=:pl";
            $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
            $resultado->execute(array(":pl"=>$vehiculo, ":est"=>$estVehi));//asigno las variables a los marcadores

            /* Actualizando la tabla "solicitud" con los valores de las variables */
            $sql="UPDATE solicitud SET id_est=:est WHERE id_soli=:id";
            $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
            $resultado->execute(array(":id"=>$solici, ":est"=>$estSoli));//asigno las variables a los marcadores

            header("Location: ../verord.php");
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
    <link rel="stylesheet" href="../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/dashuser.css">
    <link rel="stylesheet" href="../../../css/stylecusto.css">
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
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
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
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Programar servicio</h3>
                    </div>
                </div>
                <div class="container center4">
                    
                    <form method="POST" id="form">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Orden N.</span>
                                    </div>
                                    <input type="number" class="form-control" name="auto" readonly aria-label="Username"
                                        aria-describedby="basic-addon1" value="<?php echo $regist['id_auto'];?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Solicitud N.</span>
                                    </div>
                                    <input type="text" class="form-control" name="soli" readonly aria-label="Username"
                                        aria-describedby="basic-addon1" value="<?php echo $regist['id_soli']; ?>">
                                </div>
                            </div>
                        </div>
                        <h5>Datos Cliente</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>N. Documento</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $regist['id_usu'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Nombre</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="nom" value="<?php echo $regist['nom_usu'] ?>" aria-label="Username"
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
                                    <input type="text" class="form-control" readonly name="ser" value="<?php echo $regist['servi'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Origen</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="ori" value="<?php echo $origen['ciudad'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">                            
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Destino</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="des" value="<?php echo $regist['ciudad'] ?>" aria-label="Username"
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
                                    <input type="text" class="form-control text-center" readonly name="fechain" value="<?php echo $regist['fech_ini']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Fecha Final</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center" readonly name="fechafin" value="<?php echo $regist['fech_fin']?>">
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
                                    <input type="text" class="form-control text-center"  readonly name="hora" value="<?php echo $regist['hora_ini']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Número Días</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center"  readonly name="dia" value="<?php echo $regist['n_dias']?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Número Pasajeros</strong></span>
                                    </div>
                                    <input type="text" class="form-control text-center"  readonly name="pasajeros" value="<?php echo $regist['n_pasa']?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5>Recomendaciones adicionales</h5>
                        <div class="input-group input-group">
                            <input type="text" name="reco" class="form-control fs-5" aria-label="Large" readonly value="<?php echo $regist['recomend']?>" aria-describedby="inputGroup-sizing-sm ">
                        </div>
                    
                        <br>
                        <h5>Asignar Vehículo</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Vehículo - Capacidad - Vínvulo - Conductor</span>
                                    </div>
                                    <select class="custom-select" name="vehiculo">
                                        <option value="0" >Seleccione</option>
                                        <?php
                                        /* Creación de una lista desplegable de opciones. */
                                        $sql= "SELECT * FROM detalle_vehi, usuarios, regis_veh, tipo_veh, vinculo WHERE detalle_vehi.id_usu = usuarios.id_usu and detalle_vehi.placa=regis_veh.placa and regis_veh.id_tip_veh=tipo_veh.id_tip_veh and regis_veh.id_tip_vincu=vinculo.id_tip_vincu and regis_veh.id_est=6"; 
                                        $resultado=$base->prepare($sql);
                                        $resultado->execute(array());
                                        while($asig=$resultado->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                            <option value="<?php echo $asig['id_detave'];?>"><?php echo $asig['tip_veh'];?>-<?php echo $asig['capaci_pasa'];?>-<?php echo $asig['vinculo'];?>-<?php echo $asig['nom_usu'];?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div class="modal-footer">
                            <p>Adicionar otro Vehículo</p>
                            <input  type="submit" class="btn btn-danger" name="adicion" id="adicion" value="Agregar +" >
                            <p>Finalizar proceso</p>
                            <input  type="submit" class="btn btn-blue" name="insert" id="insert" value="Guardar" >
                            <input  type="submit" class="btn btn-secondary" name="cancelar" id="insert" value="Cancelar" >
                            <!-- <a href="../ordenes.php"><button type="button" class="btn btn-secondary">Cancelar</button></a> -->
                        </div>
                    </form>
                </div>
                


            </main>
            <!--FIN del cont principal-->
        </div>
    </div>
    <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="loginvalida.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>