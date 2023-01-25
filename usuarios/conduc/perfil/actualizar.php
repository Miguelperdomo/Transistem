<?php
/* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales y la fecha y hora */
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

    $nomrol=$reg["rol"];
    $usu = $reg["foto"];
    
    /* CComprobando si el formulario con el boton vali ha sido enviado */
    if(isset($_POST['vali']))
    {
        $nueva = $_POST['nueva'];
        $repete = $_POST['nuevarepe'];
        $todo  = $nueva and $repete;
        $pass_cifrado=password_hash($todo,PASSWORD_DEFAULT,array("cost"=>12));//encripta lo que hay en la variable password
        if($nueva == $repete){
        
            /* Actualización de la contraseña en la base de datos. */
            $sql="UPDATE usuarios SET  pass=:pas  WHERE id_usu=:id";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":id"=>$doc, ":pas"=>$pass_cifrado ));
            echo '<script>alert("Haz actualizado la contraseña.");</script>';
            echo '<script>window.location="../perfil.php"</script>';
            
        }else{
           /*Una alerta de javascript y redirección. */
            echo '<script>alert("Las contraseñas no coinciden, vuelva a intentar.");</script>';
            echo '<script>window.location="actualizar.php"</script>';
            
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
                         <!-- Este es el boton de ver perfil y salir de conductor -->
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

    <!--Barra menú lateral-->
    <div class="container-fluid">
        <div class="row">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                     <!-- Este es el menu lateral del conductor-->
                    <a href="../conduc.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../verprogra.php"><i class="fa-solid fa-address-book"></i><span>Ver Programacion</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
        <main class="main col">
            <div class="row justify-content-center align-content-center text-center">
                <div class="col-sm-9" id="title">
                    <h3 class="mb-0 ">Actualizar</h3>
                </div>
                <br>
                <div class="container center4">
                    <div class="modal-body">
                        <form method="POST" action="" autocomplete="off" id="form">
                            <div class="form-group">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Nueva contraseña</div>
                                    </div>
                                    <input type="password" class="form-control text-center" name="nueva" id="nueva">
                                    <div class="warnings" id="warnings1"></div>
                                </div>  
                            </div>
                            <div class="form-group">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Confirmar contraseña</div>
                                    </div>
                                    <input type="password" class="form-control text-center" name="nuevarepe" id="nuevarepe"">
                                    <div class="warnings" id="warnings2"></div>
                                </div>  
                            </div>
                            <div class="col-10">
                                <input type="submit" class="btn btn-blue" name="vali" value="Enviar">
                                <input type="hidden"  name="vali" value="Enviar">
                                <a href="../perfil.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="../../../js/validapass.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
</html>