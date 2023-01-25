<!-- /* Iniciando una sesión e incluyendo un archivo llamado validarsession.php. */ -->
<?php
    session_start();
    include("../../includes/validarsession.php");

    require_once("../../connections/connection.php");

   /* Obtener los valores de las variables de sesión. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

   /* Una consulta a la base de datos. */
    $sql= "SELECT * FROM rol where id_rol = :ro"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":ro" => $rol));
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);

    $nomrol=$reg["rol"];

    $sql="SELECT * from usuarios where id_usu=:id";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$doc));
    $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

   /* Comprobando si el formulario ha sido enviado. */
    if(isset($_POST['insert'])){
     
       /* Obtener los valores del formulario. */
        $docu=$_POST['docu'];
        $servicio=$_POST['servicio'];
        $ruta=$_POST['ruta'];
        
        $fechainicial=$_POST['fechaini'];
        $fechafinal=$_POST['fechafin'];
        $hora=$_POST['hora'];
        $dias=$_POST['dias'];
        $pasajero=$_POST['pasajeros'];
        $recomendado=$_POST['reco'];
        $estado = 3;
         
      /* Insertar los valores en la base de datos. */
        $sql="INSERT INTO solicitud (id_usu, id_ser, id_ruta, fech_ini, fech_fin, hora_ini, n_dias, n_pasa, recomend, id_est) values (:usu, :ser, :ruta, :fechini, :fechfn, :hora, :dia, :pasa, :recomen, :est)";
        $resultado=$base->prepare($sql);
        $resultado->execute(array( ":usu"=>$docu, ":ser"=>$servicio, ":ruta"=>$ruta, ":fechini"=>$fechainicial, ":fechfn"=>$fechafinal, ":hora"=>$hora, ":dia"=>$dias, ":pasa"=>$pasajero, ":recomen"=>$recomendado, ":est"=>$estado));
        
       /* Mostrando una alerta y redirigiendo a cliente.php */
        echo '<script>alert("Se ha enviado su solicitud con Exito.");</script>';
        echo '<script>window.location= "cliente.php"</script>';
    }

?>
/* El código HTML de la página. */
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
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
                        <h5 class="navbar-brand rol usuario"><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario"><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../fotos/'.$usuarios['foto'].'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>


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
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
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
                        <h3 class="mb-0 ">Programación de Rutas</h3>
                    </div>
                </div>
                <div class="container center4">

                </div>
            </main>
        </div>
    </div>

    <!-- /* Un script que se utiliza para cargar la biblioteca de arranque. */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>