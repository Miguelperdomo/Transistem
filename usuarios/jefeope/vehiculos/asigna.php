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
    
    /* Obtener la identificación de la url. */
    $busca=$_GET["id"];
    
   /* Una consulta a la base de datos que trae las tablas regis_veh, tipo_veh, modelo y marcas y
   concatena el id_tip_veh con regis_veh, id_modelo con regis_veh, id_marca con regis_veh y
   placa con la variable . */
    $sql="SELECT * FROM `regis_veh` 
    INNER JOIN tipo_veh ON regis_veh.id_tip_veh = tipo_veh.id_tip_veh
    INNER JOIN modelo ON regis_veh.id_modelo = modelo.id_modelo
    INNER JOIN marcas ON regis_veh.id_marca =marcas.id_marca AND placa = '$busca' "; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $vehiculo=$resultado->fetch(PDO::FETCH_ASSOC);


    /* Esta es una función de PHP que verifica si el botón "activar" está presionado. */
    if(isset($_POST['activar'])){

        $placa=$_POST['placa'];
        $conductor=$_POST['conductor'];

       /* Esto es insertar los valores de las variables y en la tabla.
       detalle_vehi.*/
        $sql="INSERT INTO detalle_vehi (id_usu, placa) values (:id, :pla)";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":id"=>$conductor, ":pla"=>$placa)); 

        $estAsig=1;
        
        /* Esta es una consulta para actualizar la tabla regis_veh, configurando el id_estvehi al valor del
        variable donde la placa es igual al valor de la variable. */
        $sql="UPDATE regis_veh  SET  id_estvehi=:asi WHERE placa=:pla";
        $resultado=$base->prepare($sql); 
        $resultado->execute(array(":pla"=>$placa,":asi"=>$estAsig));

       /* Esto es actualizar la tabla de usuarios, configurando el id_estvehi al valor de la variable
       donde id_usu es igual al valor de la variable. */
        $sql="UPDATE usuarios  SET  id_estvehi=:asi WHERE id_usu=:con";
        $resultado=$base->prepare($sql); 
        $resultado->execute(array(":con"=>$conductor,":asi"=>$estAsig));

        echo '<script>alert("Se ha Asignado un conductor.");</script>';
        echo '<script>window.location= "yaasignados.php"</script>';
    }

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
                        <h5 class="navbar-brand rol usuario"><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario"><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
                    <!-- Este es el menu lateral del Jefe Operaciones-->
                    <a href="../jefeope.php"><i class="fa-solid fa-house"></i><span>Inicio</span></a>
                    <a href="../ordenes.php"><i class="fa-solid fa-bus"></i><span>Ordenes de Servicio</span></a>
                    <a href="../servicios.php"><i class="fa-sharp fa-solid fa-id-card"></i></i><span>Historial
                            Servicio</span></a>
                    <a href="../conduc.php"><i class="fa-solid fa-user-tie"></i><span>Gestionar Conductor</span></a>
                    <a href="../vehi.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar
                            Vehiculos</span></a>
                    <a href="../system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar
                            Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Asignar Conductor</h3>
                    </div>
                    <br>
                    <!-- El código siguiente es un formulario que se utiliza para asignar un conductor a un vehículo. -->
                    <div class="container center4">
                        <div class="modal-body">
                            <form method="post">
                                <div class="col-auto">
                                    <div class="input-group col">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Placa</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="placa"
                                            value="<?php echo $vehiculo['placa']?>">
                                    </div>
                                </div>
                                <br>
                                <div class="col-auto">
                                    <div class="input-group col ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Tipo Vehiculo</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="tip"
                                            value="<?php echo $vehiculo['tip_veh']?>">
                                    </div>
                                </div>
                                <br>
                                <div class="col-auto">
                                    <div class="input-group col ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Modelo</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="tip"
                                            value="<?php echo $vehiculo['modelo']?>">
                                    </div>
                                </div>
                                <br>
                                <div class="col-auto">
                                    <div class="input-group col ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Marca</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="tip"
                                            value="<?php echo $vehiculo['marca']?>">
                                    </div>
                                </div>
                                <br>
                                <div class="col-auto">
                                    <div class="input-group col ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Asignar Conductor</div>
                                        </div>
                                        <td>
                                            <!-- Crear una lista desplegable de todos los usuarios en el
                                            base de datos que tienen el rol de 4 y el estado de 2. -->
                                            <select class="form-control" name="conductor">
                                                <?php
                                                    $sql= "SELECT * FROM usuarios, rol, estado_asig where usuarios.id_rol=rol.id_rol and usuarios.id_estvehi=estado_asig.id_estvehi and usuarios.id_rol=4 and usuarios.id_estvehi=2  ";
                                                    $resultado=$base->prepare($sql);
                                                    $resultado->execute(array());
                                                    while($conductor=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                <option value="<?php echo $conductor['id_usu'];?>">
                                                    <?php echo $conductor['nom_usu']?></option>
                                                <?php
                                                    }
                                                    ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>
                                <br>
                                <!-- Un formulario que se envía a un archivo PHP. -->
                                <div class="modal-footer">
                                    <a href="asignarcondu.php"><button type="button"
                                            class="btn btn-secondary">Cancelar</button></a>
                                    <input type="submit" class="btn btn-blue" name="activar" value="Asignar">
                                </div>
                            </form>
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