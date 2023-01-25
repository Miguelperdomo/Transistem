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
 
    /* El código anterior está comprobando si se hace clic en el botón Insertar. */
     if(isset($_POST['insert'])){

        /* El código anterior está comprobando si los campos están vacíos. */
        if (empty($_POST['placa']) || empty($_POST['vincu']) || empty($_POST['vehi']) || empty($_POST['marca']) || empty($_POST['model']) || empty($_POST['carro']) || empty($_POST['chasis']) || empty($_POST['motor']) || empty($_POST['inter']) || empty($_POST['ope']) || empty($_POST['soat']) || empty($_POST['tecno']) || empty($_POST['est'])){
       
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>'; 
    
       /* Asignación de los valores del formulario a las variables. */
        }else{
            $placa=$_POST['placa'];
            $vincu=$_POST['vincu'];
            $tipove=$_POST['vehi'];
            $marca=$_POST['marca'];
            $model=$_POST['model'];
            $carro=$_POST['carro'];          
            $chasis=$_POST['chasis'];
            $motor=$_POST['motor'];
            $inter=$_POST['inter'];
            $ope=$_POST['ope'];
            $soat=$_POST['soat'];
            $tecno=$_POST['tecno'];
            $est=$_POST['est'];
            $estAsig=2;

            /* Obtener los datos de la base de datos y almacenarlos en la variable. */
            $sql= "SELECT * FROM regis_veh where placa = :id"; 
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":id"=>$placa));
            $regi=$resultado->fetch(PDO::FETCH_ASSOC);

            /* Comprobando si el usuario existe en la base de datos. Si lo hace, alertará al usuario de que el
            usuario ya existe y redirigirlo a la página de inicio de sesión. */
            if($regi){
                echo "<script>alert ('Ya existe el vehículo.')</script>";
                echo "<script>window.location='agregar.php'</script>";
            }else{

                /*Inserción de datos en la base de datos. */
                $sql="INSERT INTO regis_veh (placa, id_tip_vincu, id_tip_veh, id_marca, id_modelo, id_carroce, chasis, motor, n_inter, id_est, id_estvehi, vige_to, vige_soat, vige_tecno) 
                values (:pl, :idtp, :tveh, :marc, :model, :carr, :chas, :mot, :inter, :esta, :asig, :vito, :soat, :tec)";
                $resultado=$base->prepare($sql);
                $resultado->execute(array(":pl"=>$placa, ":idtp"=>$vincu, ":tveh"=>$tipove, ":marc"=>$marca, ":model"=>$model, ":carr"=>$carro, ":chas"=>$chasis, ":mot"=>$motor, "inter"=>$inter, ":esta"=>$est, ":asig"=>$estAsig, ":vito"=>$ope, ":soat"=>$soat, ":tec"=>$tecno));
                
                echo "<script>alert ('Registro exitoso.')</script>";
                echo "<script>window.location='verregistroveh.php'</script>";

            }    
        }
    }
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
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Registrar Vehiculos</h3>
                    </div>
                    <br>
                    <!-- Formulario de registro -->                
                    <div class="container center4">
                    <form method="post" action="" id="form" autocomplete="off">
                            <br>
                            <div class="col-auto">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Placa</div>
                                    </div>
                                    <input type="varchar" class="form-control" name="placa" id="placa">
                                    <div class="warnings" id="warnings1"></div>                                    
                                </div>
                                <center><small>El número de placa debe contener 6 caracteres válidos</small></center>
                            </div> 
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Tipo vínculo</div>
                                    </div>
                                    <!-- Creación de una lista desplegable de valores de una base de datos. -->
                                    <select class="custom-select" name="vincu">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            $sql= "SELECT * FROM vinculo"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($vin=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $vin['id_tip_vincu'];?>"><?php echo $vin['vinculo'];?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Tipo vehículo</div>
                                    </div>
                                     <!-- Creación de una lista desplegable de valores de una base de datos. -->
                                    <select class="custom-select" name="vehi">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            $sql= "SELECT * FROM tipo_veh"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($vehi=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $vehi['id_tip_veh'];?>"><?php echo $vehi['tip_veh'];?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Marca</div>
                                    </div>
                                     <!-- Creación de una lista desplegable de valores de una base de datos. -->
                                    <select class="custom-select" name="marca">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            $sql= "SELECT * FROM marcas"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($mar=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $mar['id_marca'];?>"><?php echo $mar['marca'];?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Modelo</div>
                                    </div>
                                     <!-- Creación de una lista desplegable de valores de una base de datos. -->
                                    <select class="custom-select" name="model">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            $sql= "SELECT * FROM modelo"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($mod=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $mod['id_modelo'];?>"><?php echo $mod['modelo'];?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Carrocería</div>
                                    </div>
                                     <!-- Creación de una lista desplegable de valores de una base de datos. -->
                                    <select class="custom-select" name="carro">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            $sql= "SELECT * FROM carroceria"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($car=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $car['id_carroce'];?>"><?php echo $car['carroceria'];?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">N. chasis</div>
                                    </div>
                                    <input type="text" class="form-control" name="chasis" id="chasis">
                                    <div class="warnings" id="warnings2"></div>
                                </div>
                                <center><small>El número de Chasis debe contener 17 caracteres de números y letras.</small></center>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">N. motor</div>
                                    </div>
                                    <input type="text" class="form-control"  name="motor" id="motor">
                                    <div class="warnings" id="warnings3"></div>
                                </div>
                                <center><small>El número de Motor debe contener 17 caracteres de números y letras.</small></center>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">N. interno</div>
                                    </div>
                                    <input type="text" class="form-control" name="inter" id="interno">
                                    <div class="warnings" id="warnings4"></div>
                                </div>
                                <center><small>El número de Interno debe contener 17 caracteres de números y letras.</small></center>
                            </div>
                            <br>
                            <div class="col">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Vigencia tarjeta op.</span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="Username"  name="ope"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <br>
                            <div class="col">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Vigencia SOAT</span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="Username"  name="soat"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <br>
                            <div class="col">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Vigencia Tecno.</span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="Username"  name="tecno"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <br>                           
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Estado</div>
                                    </div>
                                     <!-- Creación de una lista desplegable de valores de una base de datos. -->
                                    <select class="custom-select" name="est">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            $sql= "SELECT * FROM estado where id_est>=6"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($estados=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $estados['id_est'];?>"><?php echo $estados['tip_est'];?></option>
                                                <?php
                                                }
                                                ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <!-- El código anterior es un código PHP que se utiliza para insertar datos en el
                            base de datos. y devolver a vehi.php-->
                            <div class="modal-footer">
                                <a href="../vehi.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                <input type="submit" class="btn btn-blue" name="insert" id="insert" value="Guardar" >
                            </div>
                        </form>
                    </div>  
                </div>   
                <br> 
            </main> 
            <!--FIN del cont principal-->
        </div>
    </div>
     <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="regisvalida.js" charset="utf-8"></script>
    <script src="../../../js/eliminar.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>