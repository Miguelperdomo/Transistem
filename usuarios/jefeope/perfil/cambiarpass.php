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

   /* Comprobando si el formulario ha sido enviado. */
    if(isset($_POST['enviar'])){

        /* Selección del usuario de la base de datos. */
        $sql="SELECT  * from usuarios  where  id_usu=:id";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":id"=>$doc));
        $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

       /* Comparar la contraseña de la base de datos con la contraseña que ha introducido el usuario.*/
        $pass = $usuarios['pass'];
        $clave = $_POST["passactual"];
        $verify = password_verify($clave, $pass);
  
        // Imprime el resultado dependiendo si coinciden
        if ($verify) {
            
            header("Location:actualizar.php");

        } else {
            echo'<script> alert("La contraseña no coincide");</script>';
            echo'<script>window.location= "cambiarpass.php"</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="icon" href="../../../img/bus.png">
    <title>Recuperar Contraseña</title>
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

    <!--Barra menú lateral-->
    <div class="container-fluid">
        <div class="row">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
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
                    <h3 class="mb-0 ">Actualizar Contraseña</h3>
                </div>
                <br>
                <!-- Este es el formulario que el usuario rellenará para cambiar la contraseña. -->
                <div class="container center4">
                    <div class="modal-body">
                        <form method="POST" action="" autocomplete="off">
                            <div class="form-group">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Contraseña actual</div>
                                    </div>
                                    <input type="password" class="form-control text-center" name="passactual" id="passactual">
                                </div>  
                            </div>
                            <div class="col-10">
                                <input type="submit" class="btn btn-blue" name="enviar" value="Enviar">
                                <input type="hidden"  name="enviar" value="Enviar">
                                <a href="../perfil.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
     <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
</html>