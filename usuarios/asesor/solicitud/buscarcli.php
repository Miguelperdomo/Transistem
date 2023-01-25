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

    if(isset($_POST['buscar'])){

        /* Comprueba si el campo está vacío y, si lo está, mostrará una alerta. */
        if(empty($_POST['docu'])){

            echo '<script>alert("Campo vacio.");</script>';

        }else{
            $busca=$_POST['docu'];

            $sql="SELECT * from usuarios where id_usu=:id";
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":id"=>$busca));
            $bus=$resultado->fetch(PDO::FETCH_ASSOC);            
            
            $id=$bus['id_usu'];

            /* Redirigir a otra página.  */
            if($busca != $id){
                
                header("Location: agregarcli2.php?id=$busca");            
            }else{  

                header("Location: crearsoli.php?id=$id");            }
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
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Buscar cliente</h3>
                    </div>
                    <br>
                    <div class="container center4">
                        <div class="modal-body">
                           <!-- /* Formulario que se utiliza para buscar un cliente en la base de datos.*/ -->
                           <form method="POST" action="" id="form" autocomplete="off">
                                <div class="col-auto">
                                    <div class="input-group col">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Documento</div>
                                        </div>
                                        <input type="number" class="form-control" name="docu" id="doc">
                                        <div class="warnings" id="warnings1"></div>
                                    </div>
                                    <center><small>El documento debe tener mas 7 números</small></center>
                                </div>
                                <input  type="submit" class="btn btn-blue" name="buscar"  id="buscar" value="Buscar" >
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="vali.js"></script>
    <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>