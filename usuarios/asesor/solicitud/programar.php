<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
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
  
   
   /* Obteniendo el id y el email que viajan por la url.. */
    $busca=$_GET["id"];
    $email = $_GET['email'];

        /* Consulta donde se unen las tablas y selecciona los datos de las tablas.. */
    $sql="SELECT * FROM `solicitud` 
    INNER JOIN usuarios ON solicitud.id_usu = usuarios.id_usu 
    INNER JOIN servicios ON solicitud.id_ser = servicios.id_ser
    INNER JOIN estado ON solicitud.id_est = estado.id_est
    INNER JOIN rutas ON solicitud.id_ruta =rutas.id_ruta 
    INNER JOIN origen ON rutas.id_origen = origen.id_origen 
    INNER JOIN destino ON rutas.id_destino = destino.id_destino
    INNER JOIN ciudad ON destino.id_ciudad = ciudad.id_ciudad AND id_soli = $busca";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $solicitud=$resultado->fetch(PDO::FETCH_ASSOC);

    $id=$solicitud['id_soli'];
    $ori=$solicitud['id_origen'];
    
    $sql="SELECT  * from origen, ciudad where origen.id_ciudad = ciudad.id_ciudad and id_origen = $ori";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $origen=$resultado->fetch(PDO::FETCH_ASSOC);

        
  /* Este es el código que se ejecuta cuando el usuario pulsa sobre el botón "Aprobar" */
    if(isset($_POST['programar'])){

        include "mail_aprobado.php";

        $estado = 5;

        $sql="UPDATE solicitud SET id_est=:est WHERE id_soli=:id";
        $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
        $resultado->execute(array(":id"=>$id, ":est"=>$estado));//asigno las variables a los marcadores
        
        /* Insertar el id de la solicitud en la tabla "orden_ser" */
        $sql="INSERT INTO orden_ser (id_soli) values (:usu)";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":usu"=>$id));
        
        echo '<script>alert("Solicitud Aprobada.");</script>';
        echo '<script>window.location= "aprobar.php"</script>';
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesor Comercial</title>
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
                    <a href="../aseso.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../asesorco.php"><i class="fa-solid fa-address-book"></i><span>Gestiónar Clientes</span></a>
                    <a href="../gestisoli.php"><i class="fa-solid fa-clipboard"></i><span>Gestiónar Solicitud</span></a>
                    <a href="../sistema.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestiónar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Aprobar solicitud</h3>
                    </div>
                    <br>
			            <div class="container center4">
                            <div class="modal-body">

                            <!-- formulario que está enviado los datos para la aprobación. -->
                                <form method="post">
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">N° Solicitud</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="idr" value="<?php echo $solicitud['id_soli']?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Documento</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="idr" value="<?php echo $solicitud['id_usu']?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Nombre Cliente</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="tip" value="<?php echo $solicitud['nom_usu']?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                        <div class="input-group col">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Servicio</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="servi" value="<?php echo $solicitud['servi']?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">N° Ruta</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly name="ruta" value="<?php echo $origen['ciudad']?> - <?php echo $solicitud['ciudad']?>">
                                            </div>
                                        </div>
                                        <br>
                                    <div class="col-auto">
                                        <div class="input-group col ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Estado</div>
                                            </div>
                                            <input type="text" class="form-control" readonly name="tip" value="<?php echo $solicitud['tip_est']?>">
                                        </div>
                                    </div>
                                    <br>                              
                                    <div class="modal-footer">
                                        <a href="aprobar.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                        <input  type="submit" class="btn btn-blue" name="programar" value="Aprobar" >
                                    </div>
                                </form>
                            </div>
                </div>
            </main>
              <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
</html>