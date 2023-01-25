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
            header("Location:verregistroveh.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    
    $empieza=($pagina-1)*$regis;/* Calculating the number of records to be displayed on the page. */

    /* Obteniendo todos los datos de la tabla regis_veh. */
    $sql= 'SELECT * FROM regis_veh';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

  /* Cálculo del número de páginas. */
    $totalregis=$senten->rowCount();
    $paginas = $totalregis/$regis;   
    $paginas = ceil($paginas); /* Redondea el número de páginas. */

    /* Obteniendo datos de la BD. */
    $regis=$base->query("SELECT * from regis_veh, vinculo, tipo_veh, modelo, marcas, carroceria, estado where regis_veh.id_tip_vincu=vinculo.id_tip_vincu AND regis_veh.id_tip_veh=tipo_veh.id_tip_veh AND regis_veh.id_modelo=modelo.id_modelo AND regis_veh.id_marca=marcas.id_marca and regis_veh.id_carroce=carroceria.id_carroce AND regis_veh.id_est=estado.id_est LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
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

    <div class="container-fluid">
        <div class="row">
            <!--Barra menú lateral-->
            <div class="barra-lateral col-12 col-sm-auto">
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
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Vehículos registrados</h3>
                    </div>
                    <!--Boton Registro-->
                    <div class="col auto">
                        <a href="agregar.php"><button type="button" class="btn btn-blue">Agregar</button></a>
                    </div>
                </div>
                <br>
                <!--Tabla de usuarios Registrados-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="../vehi.php"><button type="button" class="btn btn-sm btn-primary"><img src="../../../img/turn-left.png" width="25" height="25" alt="turn-left"></button></a>
                            <!-- Botones Reportes  -->
                            <a href="reportevehiregi.php"><button class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button></a>
                            <a href="vehiregipdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                            <br> <br> 
                                            <!-- Filtro -->
                            <input class="form-control w-25" id="myInput" type="text" placeholder="Buscar...">  
                            <br>
                            <div class="table-responsive" id="contenido">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr><!-- Crear un encabezado de tabla. -->
                                            <th>Foto</th>
                                            <th>Placa</th>
                                            <th>Vinculo</th>  
                                            <th>Tipo Vehiculo</th>      
                                            <th>Capacidad</th>                                    
                                            <th>Modelo</th>
                                            <th>Estado</th>  
                                            <th colspan="4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="myTable">
                                        <?php
                                         /* Creando un bucle foreach que recorrerá el
                                           matriz y asigne cada valor a la variable. */
                                        foreach ($regis as $vehiculos):
                                        ?> 
                                        <tr class="table-light" >
                                             <!-- Un código PHP que se utiliza para mostrar los datos del
                                            base de datos. -->
                                            <td><?php echo (' <img src="../../../fotos/'.$vehiculos->foto.'"  width="50" alt="Foto vehículo"> ') ?></td>
                                            <td><?php echo $vehiculos->placa?></td>
                                            <td><?php echo $vehiculos->vinculo?></td>
                                            <td><?php echo $vehiculos->tip_veh?></td>
                                            <td><?php echo $vehiculos->capaci_pasa?></td>
                                            <td><?php echo $vehiculos->modelo?></td>
                                            <td><?php echo $vehiculos->tip_est?></td>                                            
                                            <td>
                                               <!-- Crear un enlace a la página ver.php y pasar el
                                               id del vehículo como parámetro. -->
                                                <a href="ver.php?id=<?php echo $vehiculos->placa?>"><button type="button" title="Ver" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></a>
                                            </td>
                                            <td>
                                                <!-- Creando un enlace a la página foto.php y pasando el
                                                id del vehículo como parámetro. -->
                                                <a href="foto.php?id=<?php echo $vehiculos->placa?>"><button type="button" title="Cambiar Foto" class="btn btn-sm btn-primary"><i class="fa-sharp fa-solid fa-image"></i></button></a>
                                            </td>
                                            <td>
                                                <!-- Crear un enlace a la página editar.php y pasar
                                                los valores de placa y vinculo como parametros. -->
                                                <a href="editar.php?id=<?php echo $vehiculos->placa?> & vin=<?php echo $vehiculos->vinculo?>"><button type="button" title="Editar" class="btn btn-sm btn-blue"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                            </td>
                                            <td>
                                                <!-- Crear un enlace a la página eliminar.php y pasar
                                                los valores de id y vin a la página. -->
                                                <a href="eliminar.php?id=<?php echo $vehiculos->placa?> & vin=<?php echo $vehiculos->vinculo?>"><button type="button" title="Eliminar" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
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
                                        <!-- Comprobando si la página es menor o igual a 1, si lo es,
                                        deshabilitará el botón anterior. Si no es así, será
                                        habilitar el botón anterior. -->
                                        <li class="page-item <?php echo $pagina<=1? 'disabled' : '' ?>">
                                                <a class="page-link" href="verregistroveh.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                                        </li>
                                        <?php
                                            /* Creación de un sistema de paginación para la tabla. */
                                            for($i=0; $i<$paginas; $i++):?>
                                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                                    <a class="page-link" 
                                                    href="verregistroveh.php?pagina=<?php echo $i+1?>">
                                                <?php echo $i+1?></a>
                                                </li>
                                                <?php endfor?>
                                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="verregistroveh.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
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
    <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    
</body>

</html>