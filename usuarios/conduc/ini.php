<?php
/* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales y la fecha y hora */
 session_start();
 include("../../includes/validarsession.php");
 include("date.php");
 require_once("../../connections/connection.php");

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
 
/* Obtener el id y el idn viajando de la URL. */
 $ord=$_GET['id'];
 $soli=$_GET['idn'];
 
 /* Una consulta a la base de datos trayendo las tablas orden_ser, solicitud, rutas, destino, ciudad y concatenando y el id_auto por la variable que viaja en el URL*/
 $sql="SELECT  * from orden_ser  
 INNER JOIN solicitud ON orden_ser.id_soli=solicitud.id_soli
 INNER JOIN  rutas ON solicitud.id_ruta=rutas.id_ruta
 INNER JOIN destino ON rutas.id_destino=destino.id_destino
 INNER JOIN  ciudad ON destino.id_ciudad=ciudad.id_ciudad
 and  id_auto='$ord'";
 $resultado=$base->prepare($sql);
 $resultado->execute(array());
 $orden=$resultado->fetch(PDO::FETCH_ASSOC);

 if($orden['fecha_ini_real']){
    echo '<script>alert("Ya inicio esta ruta.");</script>';//Imprime un mensaje de que el viaje a Finalizado
    echo '<script>window.location= "verprogra.php"</script>';

}else{
    /* Comprobando si se ha pulsado el botón "programar".*/
    if(isset($_POST['programar'])){

        //  $id=$orden['id_auto'];
        //  $idsoli=$solicitud['id_soli'];
        $fecha= date("Y-m-d H:i:s"); 

        $sql="UPDATE  orden_ser SET fecha_ini_real=:fec WHERE id_auto=:id";
        $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
        $resultado->execute(array(":id"=>$ord, ":fec"=>$fecha));//asigno las variables a los marcadores
        echo '<script>alert("Ha iniciado el viaje.");</script>';//Imprime un mensaje de que el viaje a iniciado
        echo '<script>window.location= "verprogra.php"</script>';//Regresa a verprograma despues de escuchar el boton
    }

}




 
?>

<!DOCTYPE html>
<html lang="es">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Conductor</title>
 <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" href="../../css/dashboard.css">
 <link rel="stylesheet" href="../../css/style.css">
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
                 <li><!-- Muestra el nombre y rol de conductor y su foto correspondiente -->
                     <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                     <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                     <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <?php echo (' <img src="../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                     <!-- Este es el boton de ver perfil y salir de conductor -->
                     <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                         <a class="dropdown-item menuperfil cerrar" href="../perfil.php?id=<?php echo $doc ?>">
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
             <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                <!-- Este es el menu lateral del conductor-->
                 <a href="conduc.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                 <a href="verprogra.php"><i class="fa-solid fa-address-book"></i><span>Ver Programacion</span></a>
             </nav>
         </div>
         <!--Contenido principal-->
         <main class="main col">
             <div class="row justify-content-center align-content-center text-center">
                 <div class="col-sm-9" id="title">
                     <h3 class="mb-0 ">Iniciar Viaje</h3>
                 </div>
                 <br>
                     <div class="container center4">
                         <div class="modal-body">
                             <form method="post">
                                <div class="col-auto">
                                    <div class="input-group col">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">ID Conductor</div>
                                         </div>
                                         <input type="text" class="form-control" readonly name="idcon" value="<?php echo $doc?>">
                                     </div>
                                 </div>
                                 <br>
                                 <div class="col-auto">
                                     <div class="input-group col">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">Nombre Conductor</div>
                                         </div>
                                         <input type="text" class="form-control" readonly name="nombco" value="<?php echo $name?>">
                                     </div>
                                 </div>
                                 <br>
                                 <div class="col-auto">
                                     <div class="input-group col">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">N° Orden</div>
                                         </div>
                                         <input type="text" class="form-control" readonly name="idr" value="<?php echo $orden['id_auto']?>">
                                     </div>
                                 </div>
                                 <br>
                                 <div class="col-auto">
                                     <div class="input-group col ">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">N° Solicitud</div>
                                         </div>
                                         <input type="text" class="form-control" readonly name="tip" value="<?php echo $orden['id_soli']?>">
                                     </div>
                                 </div>
                                 <br>
                                 <div class="col-auto">
                                     <div class="input-group col ">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">Ruta de Destino</div>
                                         </div>
                                         <input type="text" class="form-control" readonly name="tip" value="<?php echo $orden['ciudad']?>">
                                     </div>
                                 </div>
                                 <br>
                                 <!-- Aqui esta el boton Inciar -->                               
                                 <div class="modal-footer">
                                     <a href="verprogra.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                     <input  type="submit" class="btn btn-blue" name="programar" value="Iniciar" >
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