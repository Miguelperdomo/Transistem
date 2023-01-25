<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../../includes/validarsession.php");
    require("../../../../connections/connection.php");//conexión a la BD

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
    
    /* Comprueba si la ruta ya existe en la base de datos. Si lo hace, alertará al usuario de que
    la ruta ya existe. Si no es así, insertará la ruta en la base de datos. */
    if(isset($_POST['ruta'])){

        $ori=$_POST['ori'];
        $des=$_POST['des'];

        $sql= "SELECT * FROM rutas where id_destino = :de"; 
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":de" => $des));
        $ruta1=$resultado->fetch(PDO::FETCH_ASSOC);

     /* Comprobación de si la ruta ya existe.. */
        if($ruta1){
            echo '<script>alert("La Ruta ya existe.");</script>';
            echo '<script>window.location= "rutas.php"</script>';
        }
 /* Comprobando si la variable es igual a 0. Si lo es, mostrará una alerta y redirigirá al
 usuario a la página rutas.php.. */
        elseif ($des == 0) {
            echo '<script>alert("No ha seleccionado ningun elemento.");</script>';
            echo '<script>window.location= "rutas.php"</script>';
        }
        else{   
/* Insertar los valores de las variables y en la base de datos. */
            $sql="INSERT INTO rutas (id_origen, id_destino) values (:ido, :idd)";
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":ido"=>$ori, ":idd"=>$des));
    
            header("Location:rutas.php");
        }
     }

/* The pagination code. */
   $regis = 2;
    if(isset($_GET["pagina"])){
        if($_GET["pagina"]==1){
            header("Location:rutas.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    $empieza=($pagina-1)*$regis;/* Calculating the number of records to be displayed on the page. */

    $sql= 'SELECT * FROM rutas';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

    /* Calculating the number of pages. */
    $totalregis=$senten->rowCount();
    $paginas = $totalregis/$regis;   
    $paginas = ceil($paginas); /* Redondea el número de páginas. */


    /* Fetching the data from the database. */
    $list=$base->query("SELECT * from rutas, origen, destino, ciudad 
    where rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
    and destino.id_ciudad=ciudad.id_ciudad LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../css/dashboard.css">
    <link rel="stylesheet" href="../../../../css/style.css">
    <link rel="icon" href="../../../../img/bus.png">


</head>

<body>
    <!--Barra cabecera-->
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light"><img src="../../../../img/logo_blanco.png" alt="logo" width="200px"></h4>
            </div>
            <div class="col-4 text-right barra">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../../../fotos/'.$usu.'" width="40" height="40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="../../perfil.php?id=<?php echo $doc?>">
                                <i class="fas fa-user m-1"></i>Perfil</a>
                            <a class="dropdown-item menuperfil cerrar" href="../../../../includes/close.php">
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
                    <a href="../../admin.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="../../users.php"><i class="fa-solid fa-address-book"></i><span>Gestión Usuarios</span></a>
                    <a href="../../system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestión Sistema</span></a>
                    
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Rutas</h3>
                    </div>
                    <br>
                      <!--Formulario de registro de rutas-->
                    <div class="container">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="card card">
                                    <div class="card-body">
                                        <form method="POST" id="formulario" autocomplete="off">
                                            <div class="form-group">
                                                <div class="input-group col">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Origen</div>
                                                    </div>
                                                    <?php
                                                    $sql= "SELECT * FROM origen, ciudad WHERE origen.id_ciudad = ciudad.id_ciudad"; 
                                                    $resultado=$base->prepare($sql);
                                                    $resultado->execute(array());
                                                    $regi2=$resultado->fetch(PDO::FETCH_ASSOC);                                                               
                                                    ?> 
                                                    <input type="text" value="<?php echo $regi2['ciudad'];?>" class="form-control" readonly>
                                                    <input type="hidden" name="ori" value="<?php echo $regi2['id_origen'];?>"class="form-control" readonly>
                                                </div>  
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group col">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Destino</div>
                                                    </div>
                                                    <select class="custom-select" name="des" id="des">
                                                        <option value="0">Seleccionar:</option>
                                                            <?php
                                                            $sql= "SELECT * FROM destino, ciudad WHERE destino.id_ciudad = ciudad.id_ciudad"; 
                                                            $resultado=$base->prepare($sql);
                                                            $resultado->execute(array());
                                                            while($regi3=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                            ?>    
                                                        <option value="<?php echo $regi3['id_destino'];?>"><?php echo $regi3['ciudad'];?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>  
                                            </div>
                                            <div class="col-10">
                                                <input type="submit" class="btn btn-blue" name="ruta" value="Agregar">
                                                <input type="hidden"  name="insert" class="btn btn-success" value="Agregar">
                                                <a href="../crearuta.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                                            </div>
                                        </form>
                                    </div>       
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>
                <br>
                  <!--Tabla de Rutas Registradas-->
                <div class="container">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Acción</th>
                            </tr>
                        </thead>  
                        <?php
                            /* Un bucle foreach que recorre el array.  */
                            foreach($list as $rutas):

                                /* Obtención de los datos de la base de datos.  */
                                $ori=$rutas->id_origen;
                                                
                                $sql= "SELECT * from origen, ciudad WHERE 
                                origen.id_ciudad=ciudad.id_ciudad and id_origen=$ori"; 
                                $resultado=$base->prepare($sql);
                                $resultado->execute(array());
                                $reg=$resultado->fetch(PDO::FETCH_ASSOC);

                        ?>          
                        <tbody class="table-light text-center" id="myTable">
                            <tr>
                                <td>
                                    <?php echo $rutas->id_ruta; ?>
                                </td>
                                <td>
                                    <?php echo $reg['ciudad'];?>
                                </td>
                                <td>
                                    <?php echo $rutas->ciudad;?>       
                                </td>
                                <td>
                                    <a href="delete/elimiruta.php?id=<?php echo $rutas->id_ruta?>"><button type="button" class="btn btn-sm btn-danger"> <i class="fa-solid fa-trash-can"></i></button></a>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                    <!-- Paginación -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $pagina<=1? 'disabled' : '' ?>">
                            <a class="page-link" href="rutas.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                        </li>
                        <?php
                            for($i=0; $i<$paginas; $i++):?>
                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                    <a class="page-link" 
                                    href="rutas.php?pagina=<?php echo $i+1?>">
                                <?php echo $i+1?></a>
                                </li>
                                <?php endfor?>
                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="rutas.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
                    </ul>
                </nav>
            </main>              
        </div>
    </div>
     <!-- /* scripts que se utiliza para hacer la página más interactiva */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>