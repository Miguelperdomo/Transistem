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

    $ver=$_GET['id'];

    $sql="SELECT * from usuarios where id_usu=:id";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$ver));
    $cliente=$resultado->fetch(PDO::FETCH_ASSOC);


    if(isset($_POST['insert'])){

        if (empty($_POST['servicio']) || empty($_POST['ruta']) || empty($_POST['fechaini']) || empty($_POST['hora']) || empty($_POST['pasajeros']) || empty($_POST['reco']) ){
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>'; 
        }else
        {

     /* Calcular la diferencia entre dos fechas. */
        $fechainicial=$_POST['fechaini'];
        $fechafinal=$_POST['fechafin'];
        $segundosTranscurridos =strtotime($fechafinal) - strtotime($fechainicial);
        $minutosTranscurridos =$segundosTranscurridos / 60;
        $horas = $minutosTranscurridos / 60;
        $dias = $horas / 24;
        $diasRedondiados =floor($dias);     
       
       /* Inserción de datos en una base. */
        $servicio=$_POST['servicio'];
        $ruta=$_POST['ruta'];
        $fechainicial=$_POST['fechaini'];
        $fechafinal=$_POST['fechafin'];
        $hora=$_POST['hora'];
        $pasajero=$_POST['pasajeros'];
        $recomendado=$_POST['reco'];
        $estado = 3;
         
        $sql="INSERT INTO solicitud (id_usu, id_ser, id_ruta, fech_ini, fech_fin, hora_ini, n_dias, n_pasa, recomend, id_est) values (:usu, :ser, :ruta, :fechini, :fechfn, :hora, :dia, :pasa, :recomen, :est)";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":usu"=>$ver, ":ser"=>$servicio, ":ruta"=>$ruta, ":fechini"=>$fechainicial, ":fechfn"=>$fechafinal, ":hora"=>$hora, ":dia"=>$diasRedondiados, ":pasa"=>$pasajero, ":recomen"=>$recomendado, ":est"=>$estado));
        $solicitud=$resultado->fetch(PDO::FETCH_ASSOC);
        echo '<script>alert("Se ha enviado su solicitud con Exito.");</script>';
        echo '<script>window.location= "../gestisoli.php"</script>';
        }
    }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
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
                        <h5 class="navbar-brand rol usuario"><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario"><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
                    <a href="../aseso.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../asesorco.php"><i class="fa-solid fa-address-book"></i><span>Gestionar Cliente</span></a>
                    <a href="../gestisoli.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Solicitudes</span></a>
                    <a href="../sistema.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestiónar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Solicitar servicio</h3>
                    </div>
                </div>
                <div class="container center4">
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Documento Cliente</span>
                                </div>
                                <input type="number" class="form-control" name="docu" readonly aria-label="Username"
                                    aria-describedby="basic-addon1" value="<?php echo $cliente['id_usu']; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nombre Cliente</span>
                                </div>
                                <input type="text" class="form-control" name="nom" readonly aria-label="Username"
                                    aria-describedby="basic-addon1" value="<?php echo $cliente['nom_usu']; ?>">
                            </div>
                        </div>
                    </div>
                    <!-- formulario de registro solicitud -->
                    <form method="POST" id="form" enctype="multipart/form-data" autocomplete="off">
                        <br>
                        <h5>Datos del servicio</h5>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Servicio</span>
                                    </div>
                                    <select class="custom-select" name="servicio">
                                        <option value="" >Seleccione</option>
                                        <?php
                                        $sql= "SELECT * FROM servicios"; 
                                        $resultado=$base->prepare($sql);
                                        $resultado->execute(array());
                                        while($servicio=$resultado->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                            <option value="<?php echo $servicio['id_ser'];?>"><?php echo $servicio['servi'];?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Origen</strong></span>
                                    </div>
                                        <?php
                                        $sql= "SELECT * FROM origen, ciudad where origen.id_ciudad = ciudad.id_ciudad"; 
                                        $resultado=$base->prepare($sql);
                                        $resultado->execute(array());
                                        $orig=$resultado->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                    <input type="text" class="form-control" readonly value="<?php echo $orig['ciudad'];?>">                           
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Destino</strong></span>
                                    </div>
                                    <select class="custom-select" name="ruta" id="des" >
                                        <option value="0">Seleccionar</option>
                                            <?php
                                            $sql= "SELECT * FROM rutas, destino, ciudad 
                                            where destino.id_ciudad = ciudad.id_ciudad and rutas.id_destino = destino.id_destino "; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($regi3=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>    
                                        <option value="<?php echo $regi3['id_ruta'];?>"><?php echo $regi3['ciudad'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>                            
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Fecha Inicio</span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="Username" min="2022-10-30" max="2025-01-1" name="fechaini"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Fecha Final</span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="Username" name="fechafin"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Hora</span>
                                    </div>
                                    <input type="time" class="form-control"  aria-label="Username" name="hora"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Número Pasajeros</span>
                                    </div>
                                    <input type="text" class="form-control" name="pasajeros" id="pas" aria-label="Username"
                                        aria-describedby="basic-addon1"> 
                                        <div class="warnings" id="warnings1"></div>                               
                                </div>
                                <center><small>El número de pasajeros debe ser mínimo 9 máximo 100</small></center>
                            </div>
                        </div>
                        <br>
                        <h5>Escriba recomendaciones adicionales</h5>
                        <div class="input-group input-group">
                            <input type="text" name="reco" class="form-control fs-5" aria-label="Large" placeholder="Dirección punto de encuentro, solicitudes especiales de pasajeros, ..." aria-describedby="inputGroup-sizing-sm ">
                        </div>
                        <div class="modal-footer">
                            <a href="../gestisoli.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                            <input  type="submit" class="btn btn-blue" name="insert" id="insert" value="Enviar" >
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
   <!-- /* Importar un archivo javascript llamado validasoli.js  */ -->
    <script src="validasoli.js" charset="utf-8"></script>
    <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
</html>