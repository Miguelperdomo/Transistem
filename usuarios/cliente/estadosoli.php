<!-- /* Iniciando una sesión e incluyendo un archivo llamado validarsession.php. */ -->
<?php
    /* Iniciando una sesión e incluyendo un archivo llamado validarsession.php. */
    session_start();
    include("../../includes/validarsession.php");

    require_once("../../connections/connection.php");

    /* Obtener los valores de las variables de sesión. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

   /* Obteniendo los datos de la base de datos y almacenándolos en la variable. */
    $sql= "SELECT * FROM rol, usuarios where rol.id_rol = usuarios.id_rol and id_usu = $doc"; 
   /* Obteniendo los datos de la base de datos y almacenándolos en la variable. */
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);

   /* Obtener el rol y la foto del usuario de la base de datos. */
    $nomrol=$reg["rol"];
    $usu = $reg["foto"];

  /* Al verificar si la página está configurada y si está configurada en 1, se redirigirá a la página estadosoli.php. */
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
    $empieza=($pagina-1)*$regis;

   /* Obtener el número total de filas en la base de datos y dividirlo por el número de filas a ser
   mostrado por página. */
    $sql= 'SELECT * FROM solicitud';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

    $totalregis=$senten->rowCount();

    $paginas = $totalregis/$regis;
    $paginas = ceil($paginas);

    /* Fetching the data from the database, las solicitudes En tramite y Aprobadas */
    $regis=$base->query("SELECT * from solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
        where solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est 
        and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
        and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_usu=$doc  LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
    ?>

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
        <div class="row">
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
                    <img src="../../img/rutas.png" alt="rutas" width="100px" class="center2">
                </div>
                
                <div class="container">
                                 
                
                <div class="container">
                     <!-- Botones Reportes  -->
                    <a href="estadosolipdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                    <a href="impriestado.php" target="blank"><button type="button"  class="btn btn-info"><i class="fa-solid fa-print"></i></button></a>
                    <br> <br> 
                                       <!-- Filtro -->
                    <input class="form-control w-25" id="myInput" type="text" placeholder="Buscar...">  
                    <br> 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="contenido">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr>
                                            <th>N. Solicitud</th>
                                            <th>N. Documento</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Estado</th>
                                            <th colspan="3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="myTable">
                                     <!-- /* Un bucle foreach que recorre la matriz. */ -->
                                        <?php
                                            foreach ($regis as $solicitud):
                                                $ori=$solicitud->id_origen;
                                                
                                                $sql= "SELECT * from origen, ciudad WHERE 
                                                origen.id_ciudad=ciudad.id_ciudad and id_origen=$ori"; 
                                                $resultado=$base->prepare($sql);
                                                $resultado->execute(array());
                                                $reg=$resultado->fetch(PDO::FETCH_ASSOC);
                                                                                          
                                        ?> 
                                        <tr class="table-light" >
                                                <td><?php echo $solicitud->id_soli?></td>
                                                <td><?php echo $solicitud->id_usu?></td>
                                                <td><?php echo $solicitud->nom_usu?></td>
                                                <td><?php echo $solicitud->servi?></td>
                                                <td><?php echo $reg['ciudad']?></td>
                                                <td><?php echo $solicitud->ciudad?></td>    
                                                <td><?php echo $solicitud->tip_est;?></td>
                                                <td>
                                                <a href="ver.php?id=<?php echo $solicitud->id_soli?>"><button type="button" title="Ver" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></a>
                                            <!-- </td>
                                            <td>
                                                <a href="delete.php?id=<?php echo $solicitud->id_soli?>"><button type="button" title="Eliminar" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                            </td> -->
                                    
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
                                                <a class="page-link" href="estadosoli.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                                        </li>
                                        <?php
                                            for($i=0; $i<$paginas; $i++):?>
                                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                                    <a class="page-link" 
                                                    href="estadosoli.php?pagina=<?php echo $i+1?>">
                                                <?php echo $i+1?></a>
                                                </li>
                                                <?php endfor?>
                                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="estadosoli.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
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
            /* Toggling the text to lower case and then checking if the value is greater than -1. */
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