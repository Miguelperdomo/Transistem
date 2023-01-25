<!-- /* Iniciando una sesión e incluyendo un archivo llamado validarsession.php. */ -->
<?php
    session_start();
    include("../../includes/validarsession.php");

    require_once("../../connections/connection.php");

    /* Obtener las variables de sesión. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

    /* Una consulta para obtener el rol y la foto del usuario. */
    $sql= "SELECT * FROM rol, usuarios where rol.id_rol = usuarios.id_rol and id_usu = $doc"; 
     /* Preparando la consulta a ejecutar. */
    $resultado=$base->prepare($sql);
     /* Ejecutando la consulta. */
    $resultado->execute(array());
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);

    /* Asignar los valores de las columnas "rol" y "foto" a las variables y . */
    $nomrol=$reg["rol"];
    $usu = $reg["foto"];

   /* Comprobando si la variable pagina está configurada. Si está configurado, comprueba si el valor es 1. Si es 1,
    redirige a estadosoli.php. Si no es 1, establece el valor de pagina al valor de la
    página variable. Si la variable pagina no está configurada, establece el valor de pagina en 1. */
    $regis = 4;
    if(isset($_GET["pagina"])){
        if($_GET["pagina"]==1){
            header("Location:estadosoli.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    /* Establecer la variable al valor de la página actual menos 1 multiplicado por el número
    de registros por página. */
    $empieza=($pagina-1)*$regis;

    /* Obteniendo el número total de filas en la tabla y dividiéndolo por el número de filas a ser
    mostrado por página. */
    $sql= 'SELECT * FROM orden_ser';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

    $totalregis=$senten->rowCount();
    $paginas = $totalregis/$regis;
    $paginas = ceil($paginas);


    /* Fetching the data from the database. */
    $regis=$base->query("SELECT * from orden_ser, solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
    where orden_ser.id_soli=solicitud.id_soli and solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_usu=$doc LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
?>


<!-- /* El código para el encabezado de la página. */ -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashuser.css">
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
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
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
        <div class="row ">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
                <nav class="menu d-flex d-sm-block justify-content-center flex-wrap" >
                    <a href="cliente.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="solicitud.php"><i class="fa-solid fa-address-book"></i><span>Solicitar Servicio</span></a>
                    <a href="estadosoli.php"><i class="fa-solid fa-clipboard"></i><span>Estado de Solicitudes</span></a>
                    <a href="contrato.php"><i class="fa-solid fa-clipboard"></i><span>Contratos Generados</span></a>
                </nav>
            </div>
            <!--Contenido principal-->

            <main class="main col">
                <div class="container">
                    <img src="../../img/contract.png" alt="contract" width="90px" class="center2">
                    <h4></h4>
                </div>
                <br>
                <div class="container">
                                      
                <br>
                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-12">
                            <div class="table-responsive" id="contenido">
                               
                                 <!-- Botones Reportes  -->
                                <a href="contratopdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                                <a href="impricontra.php" target="blank"><button type="button"  class="btn btn-info"><i class="fa-solid fa-print"></i></button></a>
                                <!-- <a href=""><button class="btn btn-info"><i class="fa-solid fa-print"></i></button></a> -->
                                <br><br>
                                 <!-- Filtro -->
                                <input class="form-control w-25" id="myInput" type="text" placeholder="Buscar...">  
                                <br>    
                                <!-- /* Creando una tabla con el id de tablaRoles. */ -->
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr>
                                            <th>Orden N.</th>
                                            <th>Solicitud</th>
                                            <th>Documento</th>
                                            <th>Nombre</th>
                                            <th>Servicio</th>   
                                            <th>Ruta</th>                                         
                                            <th>Estado</th>                                            
                                            <th colspan="3">Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">
                                    <!-- /* Un código PHP que obtiene datos de una base de datos. */ -->
                                        <?php
                                            foreach ($regis as $orden):

                                                $sql= "SELECT * FROM detalle_ord, orden_ser, estado where detalle_ord.id_soli=orden_ser.id_soli and detalle_ord.id_est=estado.id_est"; 
                                                $resultado=$base->prepare($sql);
                                                $resultado->execute(array());
                                                $regi=$resultado->fetch(PDO::FETCH_ASSOC);
                                            
                                                $est=$regi['tip_est'];

                                        ?> 
                                       <!-- /* El código anterior es un código PHP que se usa para mostrar los datos
                                       de la base de datos */ -->
                                        <tr class="table-light" >
                                            <td><?php echo $orden->id_auto ?></td>
                                            <td><?php echo $orden->id_soli ?></td>
                                            <td><?php echo $orden->id_usu?></td>
                                            <td><?php echo $orden->nom_usu?></td>
                                            <td><?php echo $orden->servi?></td>
                                            <td><?php echo $orden->ciudad?></td>
                                            <td><span class="status"><?php echo $est?></span></td>
                                            
                                            <td>
                                                <a href="verordpro.php?id=<?php echo $orden->id_soli?> & auto=<?php echo $orden->id_auto?>"><button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></a>
                                            </td>
                                            <td>
                                               
                                            </td>
                                        </tr>
                                        <?php
                                        endforeach;
                                        ?>                                                                        
                                    </tbody>        
                                </table>
                                <!-- Paginación -->
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php echo $pagina<=1? 'disabled' : '' ?>">
                                                <a class="page-link" href="contrato.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                                        </li>
                                        <?php
                                            for($i=0; $i<$paginas; $i++):?>
                                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                                    <a class="page-link" 
                                                    href="contrato.php?pagina=<?php echo $i+1?>">
                                                <?php echo $i+1?></a>
                                                </li>
                                                <?php endfor?>
                                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="contrato.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
                                    </ul>
                                </nav> 
                            </div>
                        </div>
                    </div> 
                </div>
                
                    
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
    <script>
        /* función jQuery que se utiliza para buscar un valor específico en una tabla. */
        $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
           /* Cambiar el texto a minúsculas y luego verificar si el valor es mayor que -1. */
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>