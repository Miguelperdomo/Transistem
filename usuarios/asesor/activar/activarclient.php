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



    $regis = 4;
    if(isset($_GET["pagina"])){
        if($_GET["pagina"]==1){
            header("Location:activarclient.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    $empieza=($pagina-1)*$regis;

    $sql= 'SELECT * FROM usuarios';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

    $totalregis=$senten->rowCount();

    $paginas = $totalregis/$regis;
    $paginas = ceil($paginas);

    /* Fetching the data from the database. */
    $regis=$base->query("SELECT * from usuarios, rol, estado where usuarios.id_rol=rol.id_rol and usuarios.id_est=estado.id_est and usuarios.id_rol=5 and usuarios.id_est=2 LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
    // $regis=$base->query("SELECT * from usuarios where usuarios.id_rol=5 and usuarios.id_est=2 LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesor Comercial</title>
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
                    <a href="../aseso.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../asesorco.php"><i class="fa-solid fa-address-book"></i><span>Gestiónar Clientes</span></a>
                    <a href="../gestisoli.php"><i class="fa-solid fa-clipboard"></i><span>Gestiónar Solicitud</span></a>
                    <a href="../sistema.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestiónar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Clientes Registrados Inactivos</h3>
                    </div>
                </div>
                <br>
                <div class="container">
                    <a href="../asesorco.php"><button type="button" class="btn btn-sm btn-primary"><img src="../../../img/turn-left.png" width="25" height="25" alt="turn-left"></button></a>
                     <!-- Botones Reportes  -->
                    <a href="reporteclienina.php"><button class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button></a>
                    <a href="clieninapdf.php" target="blank"><button class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i></button></a>
                    <a href="impriacti.php"><button type="button"  class="btn btn-info"><i class="fa-solid fa-print"></i></button></a>
                    <!-- <a href=""><button class="btn btn-info"><i class="fa-solid fa-print"></i></button></a> -->
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
                                            <th>Foto</th>
                                            <th>Documento</th>
                                            <th>Nombre</th>
                                            <th>Rol</th>                                            
                                            <th>Estado</th>
                                            <th colspan="4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="myTable">
                                        <?php
                                            foreach ($regis as $usuarios):
                                            
                                        ?> 
                                        <tr class="table-light" >
                                        <td><?php echo (' <img src="../../../fotos/'.$usuarios->foto.'"  width="50" alt="Foto perfil"> ') ?></td>
                                            <td><?php echo $usuarios->id_usu?></td>
                                            <td><?php echo $usuarios->nom_usu?></td>
                                            <td><?php echo $usuarios->rol;?></td>
                                            <td><span class="status"><?php echo $usuarios->tip_est?></span></td>
                                            
                                            <td>
                                                <a href="ver.php?id=<?php echo $usuarios->id_usu?> & nom=<?php echo $usuarios->id_rol?>"><button type="button" title="Ver" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></a>
                                            </td>
                                            <td>
                                                <a href="activa.php?id=<?php echo $usuarios->id_usu?> & email=<?php echo $usuarios->email?>"><button type="button" title="Activar" class="btn btn-sm btn-primary"><i class="fa-sharp fa-solid fa-circle-check"></i></button></a>
                                            </td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $usuarios->id_usu?> & nom=<?php echo $usuarios->id_rol?>"><button type="button" title="Editar" class="btn btn-sm btn-blue"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                            </td>
                                            <td>
                                                <a href="delete.php?id=<?php echo $usuarios->id_usu?> & nom=<?php echo $usuarios->id_rol?>"><button type="button" title="Eliminar" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
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
                                                <a class="page-link" href="activarclient.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                                        </li>
                                        <?php
                                            for($i=0; $i<$paginas; $i++):?>
                                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                                    <a class="page-link" 
                                                    href="activarclient.php?pagina=<?php echo $i+1?>">
                                                <?php echo $i+1?></a>
                                                </li>
                                                <?php endfor?>
                                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="activarclient.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
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
        <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    
</body>

</html>