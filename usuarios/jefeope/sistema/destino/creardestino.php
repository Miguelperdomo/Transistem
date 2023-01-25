<?php
session_start();
include("../../../../includes/validarsession.php");

require_once("../../../../connections/connection.php");

    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

    /* A query to the database. */
    $sql= "SELECT * FROM rol, usuarios where rol.id_rol = usuarios.id_rol and id_usu = $doc"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);

    $nomrol=$reg["rol"];
    $usu = $reg["foto"];

 
    if(isset($_POST['destino'])){

        $idc=$_POST['ci'];
        $depa=$_POST['de'];

        $sql= "SELECT * FROM destino where id_ciudad= :deci"; 
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":deci" => $idc));
        $dest=$resultado->fetch(PDO::FETCH_ASSOC);

        $sql= "SELECT * FROM destino where id_depart = :de"; 
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":de" => $depa));
        $dest1=$resultado->fetch(PDO::FETCH_ASSOC);

        if($dest && $dest1){
            echo '<script>alert("El Destino ya existe.");</script>';
            echo '<script>window.location= "creardestino.php"</script>';
        }
        elseif ($idc == 0 && $depa == 0) {
            echo '<script>alert("No ha seleccionado ningun elemento.");</script>';
            echo '<script>window.location= "creardestino.php"</script>';
        }
        else{
                 
         $sql="INSERT INTO destino (id_depart, id_ciudad) values (:idd, :idc)";
         $resultado=$base->prepare($sql);
         $resultado->execute(array(":idd"=>$depa, ":idc"=>$idc));
 
         header("Location:creardestino.php");
        }
    }

   $regis = 2;
    if(isset($_GET["pagina"])){
        if($_GET["pagina"]==1){
            header("Location:creardestino.php");
        }else{
            $pagina=$_GET["pagina"];
        }
    }else{
        $pagina=1;//muestra página en la que estamos cuando se carga por primera vez
    }
    $empieza=($pagina-1)*$regis;

    $sql= 'SELECT * FROM destino';
    $senten=$base->prepare($sql);
    $senten->execute();
    $registros=$senten->fetchALL();

    $totalregis=$senten->rowCount();

    $paginas = $totalregis/$regis;
    $paginas = ceil($paginas);

    /* Fetching the data from the database. */
    $list=$base->query("SELECT * from destino, departa, ciudad where destino.id_ciudad=ciudad.id_ciudad and destino.id_depart=departa.id_depart LIMIT $empieza, $regis")->fetchALL(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino</title>
    <link rel="stylesheet" href="../../../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../css/dashuser.css">
    <link rel="stylesheet" href="../../../../css/style.css">
    <link rel="icon" href="../../../../img/bus.png">

    <script src="select/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {  
       
            function getAll(){
            
                $.ajax
                ({
                    url: 'select/getCiudad.php',
                    data: 'action=showAll',
                    cache: false,
                    success: function(r)
                    {
                        $("#display").html(r);
                    }
                });   
            }
            getAll();
            
            $("#getCiudades").change(function()
            {    
                var id = $(this).find(":selected").val();

                var dataString = 'action='+ id;
                    
                $.ajax
                ({
                    url: 'select/getCiudad.php',
                    data: dataString,
                    cache: false,
                    success: function(r)
                    {
                        $("#display").html(r);
                    } 
                });
            })
            // code to get all records from table via select box
        });
    </script>
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
                            <?php echo (' <img src="../../../../fotos/'.$usu.'" width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
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
                    <a href="../../jefeope.php"><i class="fa-solid fa-house"></i><span>Inicio</span></a>
                    <a href="../../ordenes.php"><i class="fa-solid fa-bus"></i><span>Ordenes de Servicio</span></a>
                    <a href="../../servicios.php"><i class="fa-sharp fa-solid fa-id-card"></i></i><span>Historial Servicio</span></a>
                    <a href="../../conduc.php"><i class="fa-solid fa-user-tie"></i><span>Gestionar Conductor</span></a>
                    <a href="../../vehi.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Vehiculos</span></a>
                    <a href="../../system.php"><i class="fa-solid fa-screwdriver-wrench"></i><span>Gestionar Sistema</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Destinos</h3>
                    </div>
                    <br>
                    <div class="container">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="card card">
                                    <div class="card-body">
                                        <form method="POST" id="formulario" autocomplete="off">
                                            <div class="form-group">
                                                <div class="input-group col">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Departamento</div>
                                                    </div>
                                                    <select class="custom-select" name="de" id="getCiudades">
                                                        <option value="showAll" selected="selected">Seleccionar: </option>
                                                        <?php
                                                        $sql= "SELECT * from departa"; 
                                                        $resultado=$base->prepare($sql);
                                                        $resultado->execute(array());
                                                        while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $registro['id_depart'];?>"><?php echo $registro['departa']?></option>
                                                        <?php
                                                        }	
                                                        ?>
                                                    </select>
                                                </div>  
                                            </div>
                                            <div class="" id="display">
                                                 
                                            </div>
                                            <br>
                                            <div class="col-10">
                                                <input type="submit" class="btn btn-blue" name="destino" value="Agregar">
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
                <div class="container">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Departamento</th>
                                <th>Ciudad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>  
                        <?php
                            foreach($list as $destino):
                        ?>          
                        <tbody class="table-light text-center" id="myTable">
                            <tr>
                                <td>
                                    <?php echo $destino->id_destino; ?>
                                </td>
                                <td>
                                    <?php echo $destino->departa; ?>
                                </td>
                                <td>
                                    <?php echo $destino->ciudad; ?>       
                                </td>
                                <td>
                                    <a href="delete/elimidestino.php?id=<?php echo $destino->id_destino?>"><button type="button" class="btn btn-sm btn-danger"> <i class="fa-solid fa-trash-can"></i></button></a>
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
                            <a class="page-link" href="creardestino.php?pagina=<?php echo $pagina-1 ?>">Anterior</a>
                        </li>
                        <?php
                            for($i=0; $i<$paginas; $i++):?>
                                <li class="page-item <?php echo $pagina==$i+1? 'active': ''?>">
                                    <a class="page-link" 
                                    href="creardestino.php?pagina=<?php echo $i+1?>">
                                <?php echo $i+1?></a>
                                </li>
                                <?php endfor?>
                        <li class="page-item <?php  echo $pagina>=$paginas? 'disabled' : '' ?> "><a class="page-link" href="creardestino.php?pagina=<?php echo $pagina+1 ?>">Siguiente</a></li>
                    </ul>
                </nav>
            </main>              
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>