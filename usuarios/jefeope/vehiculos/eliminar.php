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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
    <link rel="stylesheet" href="../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/dashboard.css">
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
                        <h3 class="mb-0 ">Eliminar Vehiculo</h3>
                    </div>
                    <br>
                    <?php

	               /* Obtener el id del vehículo que se va a eliminar que viaja en la URL */
                    $busca=$_GET["id"];

                    $sql= "SELECT * FROM regis_veh, estado_asig, tipo_veh where regis_veh.id_estvehi = estado_asig.id_estvehi and regis_veh.id_tip_veh=tipo_veh.id_tip_veh and regis_veh.placa='$busca'"; 
                    $resultado=$base->prepare($sql);
                    $resultado->execute(array());
                    $regvehi=$resultado->fetch(PDO::FETCH_ASSOC);
                    
                    if($regvehi){
                            echo '<br><div class="alert alert-danger center4"> No se puede eliminar este vehículo. Vehículo asignado.
                            </div><br>
                            <div class="container">
                            <a href="verregistroveh.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                            </div>';
                    }
                    else{

                        $sql= "SELECT * FROM regis_veh, tipo_veh where regis_veh.id_tip_veh=tipo_veh.id_tip_veh and placa = '$busca'"; 
                        $resultado=$base->prepare($sql);
                        $resultado->execute(array());
                        $vehiculo=$resultado->fetch(PDO::FETCH_ASSOC);   

                        $placa=$vehiculo['placa'];
                                
                        try{
                            /* Esta es una declaración condicional que verifica si el botón "eliminar" se ha hecho clic.*/
                            if(isset($_POST['eliminar'])){
                                 /* Este es el código que elimina el vehículo de la base de datos. */                
                                $sql="DELETE FROM regis_veh WHERE placa=:pla";
                                $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
                                $resultado->execute(array(":pla"=>$placa));//asigno las variables a los marcadores
                                echo '<script>alert("Haz Eliminado este Vehiculo.");</script>';
                                echo '<script>window.location="verregistroveh.php"</script>';
                            }
                   
			        ?>
			            <!-- Un formulario que se muestra en un modal. -->
                        <div class="container center4">
                            <div class="modal-body">
                                <form method="post">
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Placa</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="placa" value="<?php echo $vehiculo['placa']?>">
                                        </div>
                                    </div>
                       
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Tipo Vehiculo</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="nom" value="<?php echo $vehiculo['tip_veh']?>">
                                        </div>
                                    </div>
                           
                                    <br>                                 
                                    <div class="col-10">
                                        <a href="verregistroveh.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                        <input  type="submit" class="btn btn-blue" name="eliminar" value="Eliminar" >
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
    
                    $resultado->closeCursor();

                    /* Un bloque try catch. */
                    }catch(Exception $e){
	                    die('<br><div class="alert alert-danger center4"> No se puede eliminar este Usuario.
                            </div><br>
                            <div class="container">
                            <a href="verregistroveh.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                            </div>');
                    }finally{
	                    $base=null;//vaciar memoria
                    }
                }
                    ?>
            </main>
    <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
</html>