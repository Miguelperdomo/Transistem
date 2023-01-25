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

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
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
                            <?php echo (' <img src="../../../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                       
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="../../perfil.php?id=<?php echo $doc ?>">
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
                        <h3 class="mb-0 ">Editar Vinculos</h3>
                    </div>
                    <br>
                    <?php
                
                $busca=$_GET["id"];


                    try{
                    $base=new PDO("mysql:host=localhost;dbname=transistem", "root", "");//pdo es la clase
                    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//muestra el tipo de error
                    $base->exec("set character set utf8");
                    //echo "Conexión exitosa";
                    $sql="SELECT  * from vinculo  where  id_tip_vincu=:id";//consulta con marcador, el marcador es :codigo

                    $resultado=$base->prepare($sql);//el objeto $base llama al metodo prepare que recibe por parametro la instrucción sql, el metodo prepare devuelve un objeto de tipo PDO que se almacena en la variable resultado
                    $resultado->execute(array(":id"=>$busca));

                        if($vinculo=$resultado->fetch(PDO::FETCH_ASSOC)){
                            
                            ?>
                            
                            <div class="container center4">
                                <div class="modal-body">
                                    <form method="post" action="validedit.php">
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Identificador</div>
                                                </div>
                                                <input type="text" class="form-control" readonly name="idr" value="<?php echo $vinculo['id_tip_vincu']?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Vinculo</div>
                                                </div>
                                                <input type="text" class="form-control"  name="vin" value="<?php echo $vinculo['vinculo']?>">
                                            </div>
                                         </div>
                                        <br>                                
                                        <div class="modal-footer">
                                            <a href="../vinculo.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                            <input  type="submit" class="btn btn-blue" name="edita" value="Guardar" >
                                        </div>
                                    </form>
                                </div>
                            </div>

                    <?php
                        }else{
                            echo "No existe este Vinculo $busca";
                        }

                        



                    $resultado->closeCursor();

                    }catch(Exception $e){
                        die("Error: ". $e->GetMessage());

                    }finally{
                        $base=null;//vaciar memoria
                    }


                    ?>



                     </div>
                    </div>

            </main>
     
           

                



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>