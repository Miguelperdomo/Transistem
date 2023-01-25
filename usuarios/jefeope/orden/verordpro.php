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

    $regis = 4;
    /* Verificando si la página está configurada, si está configurada, verificará si la página es 1, si es 1, lo hará
   redirigir a verord.php, si no es 1 establecerá la página en el número de página. Si la página es
   no configurado, establecerá la página en 1. */
    if(isset($_GET["pagina"])){
        if($_GET["pagina"]==1){
            header("Location:versoli.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    $empieza=($pagina-1)*$regis;

    /* Obteniendo todos los datos de la tabla detalle_ord. */
    $sql= 'SELECT * FROM detalle_ord';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

   /* Calcular el número de páginas necesarias para mostrar los resultados. */
    $totalregis=$senten->rowCount();
    $paginas = $totalregis/$regis;
    $paginas = ceil($paginas);

    /* Obtener el id del soli de la url. */
    $idsoli=$_GET['id'];
    $idord=$_GET['auto'];
  
    $regis=$base->query("SELECT * from detalle_ord, detalle_vehi, solicitud, regis_veh, marcas, tipo_veh, usuarios, servicios, rutas, destino, ciudad, estado where detalle_ord.id_detave=detalle_vehi.id_detave and detalle_ord.id_soli=solicitud.id_soli and detalle_vehi.placa=regis_veh.placa and regis_veh.id_marca=marcas.id_marca and solicitud.id_ser=servicios.id_ser and regis_veh.id_tip_veh=tipo_veh.id_tip_veh and solicitud.id_ruta=rutas.id_ruta and rutas.id_destino= destino.id_destino and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_est=estado.id_est and detalle_vehi.id_usu=usuarios.id_usu and detalle_ord.id_soli=$idsoli LIMIT $empieza, $regis ")->fetchALL(PDO::FETCH_OBJ);

    // $regis=$base->query("SELECT * from orden_ser, solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
    // where orden_ser.id_soli=solicitud.id_soli and solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_soli=$idsoli ")->fetchALL(PDO::FETCH_OBJ);
       
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
                        <h3 class="mb-0 ">Detalle Orden N. <?php echo $idord;?> </h3>
                    </div>
                </div>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="contenido">
                                <a href="../ordprogram.php"><button type="button" class="btn btn-sm btn-primary"><img src="../../../img/turn-left.png" width="25" height="25" alt="turn-left"></button></a>
                                <a href="reportedetalle.php"><button class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button></a>
                                <a href="detalleordenpdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                                             
                                <br> <br> 
                                                <!-- Filtro -->
                                <input class="form-control w-25" id="myInput" type="text" placeholder="Buscar...">  
                                <br>                              
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr> <!-- Crear un encabezado de tabla. -->
                                            <th>Orden N.</th>
                                            <th>Solicitud</th>
                                            <th>Documento</th>
                                            <th>Conductor</th>
                                            <th>Servicio</th>   
                                            <th>Ruta</th>                                         
                                            <th>Estado</th>                                            
                                            <th colspan="3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="myTable">
                                        <?php
                                        /* Creando un bucle foreach que recorrerá el
                                           matriz y asigne cada valor a la variable. */
                                            foreach ($regis as $orden):
                                        ?> 
                                        <tr class="table-light" >
                                            <!-- Un código PHP que se utiliza para mostrar los datos del
                                            base de datos. -->
                                            <td><?php echo $idord ?></td>
                                            <td><?php echo $orden->id_soli ?></td>
                                            <td><?php echo $orden->id_usu?></td>
                                            <td><?php echo $orden->nom_usu?></td>
                                            <td><?php echo $orden->servi?></td>
                                            <td><?php echo $orden->ciudad?></td>
                                            <td><span class="status"><?php echo $orden->tip_est?></span></td>
                                            
                                            <!-- Crear un enlace a una página llamada verprogramado.php. -->
                                            <td>
                                                <a href="verprogramado.php?id=<?php echo $orden->id_detaord?> &auto=<?php echo $idord?>"><button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></a>
                                            </td>
                                        </tr>
                                        <?php
                                        /* Recorriendo la matriz e imprimiendo los valores. */
                                        endforeach;
                                        ?>                                                                        
                                    </tbody>        
                                </table>
                                <!-- Paginación -->
                                 <!--El código anterior es un código de paginación. --> 
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php echo $pagina<=1? 'disabled' : '' ?>">
                                                <a class="page-link" href="vercliente.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                                        </li>
                                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="vercliente.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
                                    </ul>
                                </nav> 
                            </div>
                        </div>
                    </div> 
                </div>

            </main>
            <!--FIN del cont principal-->
        </div>
    </div>
    <script src="loginvalida.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
    <script>
        /* función jQuery que se utiliza para buscar un valor específico en una tabla. */
        $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            /* Cambiar el texto a minúsculas y luego comprobar si el valor es mayor que -1. */
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>
     <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>  