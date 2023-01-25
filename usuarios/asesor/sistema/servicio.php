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

    // Inserción de los datos en la base de datos.
if(isset($_POST['insert'])){
    $id=$_POST['id'];
    $ser=$_POST['servi'];
    $tari=$_POST['tari'];
            
    $sql="INSERT INTO servicios (id_ser, servi, tarifa) values (:id, :servi, :tari)";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$id, ":servi"=>$ser, ":tari"=>$tari));

    header("Location:servicio.php");
}
/*El código de paginación */
$regis = 4;
    if(isset($_GET["pagina"])){
        if($_GET["pagina"]==1){
            header("Location:servicio.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    $empieza=($pagina-1)*$regis;

    $sql= 'SELECT * FROM servicios';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

    /* Calcular el número de páginas */    
    $totalregis=$senten->rowCount();/* cuenta el número de filas en la tabla. */
    $paginas = $totalregis/$regis;   
    $paginas = ceil($paginas); /* Redondea el número de páginas. */

  /* Obteniendo datos de la BD. */
    $regis=$base->query("SELECT * from servicios LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesor Comercial</title>
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
                    <a href="../asesorco.php"><i class="fa-solid fa-address-book"></i><span>Gestiónar Clientes </span></a>
                    <a href="../gestisoli.php"><i class="fa-solid fa-clipboard"></i><span>Gestiónar Solicitudes</span></a>
                    <a href="../sistema.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestiónar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Servicios</h3>
                    </div>
                    <br>
                    <!-- Modal Insertar -->
                
                    <div class="container">
                        <button type="button" class="btn btn-blue " data-toggle="modal" data-target="#myModal">Agregar</button>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Añadir Servicio</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    </div>
                                    <div class="modal-body">

                                        <form method="post">
                                            <div class="col-auto">
                                                <div class="input-group col">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Id</div>
                                                    </div>
                                                    <input type="number" required class="form-control" name="id" >
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-auto">
                                                <div class="input-group col ">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Servicio</div>
                                                    </div>
                                                    <input type="text" required class="form-control" name="servi" >
                                                </div>
                                            </div>

                                            <br>
                                            <div class="col-auto">
                                                <div class="input-group col ">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Tarifa</div>
                                                    </div>
                                                    <input type="text" required class="form-control" name="tari" >
                                                </div>
                                            </div>
                                            <br>                                
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <input  type="submit" class="btn btn-blue" name="insert" value="Guardar" >
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>   
                <br>  
                
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive ">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed center3" style="width:50%">
                                    <thead class="text-center ">
                                        <tr>
                                             <th>Id</th>
                                             <th>Servicio</th>
                                             <th>Tarifa</th>
                                             <th colspan="2">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                            foreach ($regis as $servicios):
                                        ?> 
                                        <tr class="table-light" >
                                            <td><?php echo $servicios->id_ser?></td>
                                            <td><?php echo $servicios->servi?></td>
                                            <td><?php echo $servicios->tarifa?></td>
                                            <td>
                                                <a href="servicio/edit.php?id=<?php echo $servicios->id_ser?> & nom=<?php echo $servicios->servi?><?php echo $servicios->tarifa?>"><button type="button" class="btn btn-sm btn-blue"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                            </td>
                                            <td>
                                                <a href="servicio/delete.php?id=<?php echo $servicios->id_ser?> & nom=<?php echo $servicios->servi?><?php echo $servicios->tarifa?>"><button type="button" class="btn btn-sm btn-danger"> <i class="fa-solid fa-trash-can"></i></button></a>
                                            </td>
                                        </tr>
                                        <?php
                                        endforeach;
                                        ?>                                                                        
                                    </tbody>        
                                </table> 
                            </div>
                        </div>
                    </div> 
                </div>
                    <!-- Paginación -->
                    <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php echo $pagina<=1? 'disabled' : '' ?>">
                                                <a class="page-link" href="servicio.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                                        </li>
                                        <?php
                                            for($i=0; $i<$paginas; $i++):?>
                                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                                    <a class="page-link" 
                                                    href="servicio.php?pagina=<?php echo $i+1?>">
                                                <?php echo $i+1?></a>
                                                </li>
                                                <?php endfor?>
                                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="servicio.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
                                    </ul>
                                </nav> 
            </main>
            <!--FIN del cont principal-->
        </div>
    </div>
          <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>