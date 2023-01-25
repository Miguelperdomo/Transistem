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

    /* Obtener la identificación de la url. */
    $busca=$_GET["id"];    


       /*Una consulta a la base de datos. */
       $sql="SELECT * FROM `regis_veh` 
       INNER JOIN vinculo ON regis_veh.id_tip_vincu = vinculo.id_tip_vincu 
       INNER JOIN tipo_veh ON regis_veh.id_tip_veh = tipo_veh.id_tip_veh
       INNER JOIN modelo ON regis_veh.id_modelo = modelo.id_modelo
       INNER JOIN marcas ON regis_veh.id_marca =marcas.id_marca
       INNER JOIN carroceria ON regis_veh.id_carroce = carroceria.id_carroce 
       INNER JOIN estado ON regis_veh.id_est = estado.id_est
        AND placa = '$busca' "; 
        $resultado=$base->prepare($sql);
        $resultado->execute(array());
        $regveh=$resultado->fetch(PDO::FETCH_ASSOC);
  
        /* Asignación de los valores de la base de datos a las variables. */
        $placa = $regveh["placa"];
        $vinculo = $regveh["vinculo"];
        $fecha = $regveh ["fech_vincu"];
        $tpvehi = $regveh["tip_veh"];
        $marca=$regveh["marca"];
        $modelo = $regveh["modelo"];
        $carroceria=$regveh["carroceria"];
        $chasis = $regveh["chasis"];
        $motor=$regveh["motor"];
        $interno = $regveh["n_inter"];
        $estado = $regveh["tip_est"];
        $vigenciatar = $regveh["vige_to"];
        $soat = $regveh["vige_soat"];
        $soat = $regveh["vige_soat"];
        $tecno = $regveh["vige_tecno"];
        $foto = $regveh["foto"];
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
                        <h3 class="mb-0 ">Editar Vehiculos</h3>
                    </div>
                    <br>
                    <!-- Un formulario que se utiliza para editar un registro en una base de datos. -->
                    <div class="container center4">
                                <div class="modal-body">
                                    <form method="post" action="validaedita.php">
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Placa</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center" readonly  name="placa" value="<?php echo $placa?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Vinculo</div>
                                                </div>
                                                <input type="text" class="form-control text-center" readonly  name="vinculo" value="<?php echo $vinculo?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Fecha Vinculo</div>
                                                </div>
                                                <input type="date" class="form-control text-center"  name="fecha" value="<?php echo $fecha?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Vehiculo</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center" readonly name="tpvehi" value="<?php echo $tpvehi?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Marca</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center" readonly name="marca" value="<?php echo $marca?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Modelo</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center" readonly name="modelo" value="<?php echo $modelo?>">
                                                </td>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Carroceria</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center" readonly name="carroceria" value="<?php echo $carroceria?>">
                                                </td>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">N° Chasis</div>
                                                </div>
                                                <input type="text" class="form-control text-center"  name="chasis" value="<?php echo $chasis?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">N° Motor</div>
                                                </div>
                                                <input type="text" class="form-control text-center"  name="motor" value="<?php echo $motor?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text ">N° Interno</div>
                                                </div>
                                                <td>
                                                    <input type="text" class="form-control text-center"   name="interno" value="<?php echo $interno?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text ">Estado</div>
                                                </div>
                                                <td>
                                                <input type="text" class="form-control text-center" readonly name="estado" value="<?php echo $estado?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text ">Vigencia Tarjeta OP</div>
                                                </div>
                                                <td>
                                                    <input type="date" class="form-control text-center"   name="tarjeta" value="<?php echo $vigenciatar?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text ">Vigenica SOAT</div>
                                                </div>
                                                <td>
                                                    <input type="date" class="form-control text-center"   name="soat" value="<?php echo $soat?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text ">Tecnomecanica</div>
                                                </div>
                                                <td>
                                                    <input type="date" class="form-control text-center" name="tecno" value="<?php echo $tecno?>">
                                                </td>
                                            </div>
                                         </div>
                                        <br>                            
                                        <!-- Un boton que se envia -->
                                        <div class="modal-footer">
                                            <a href="verregistroveh.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                            <input  type="submit" class="btn btn-blue" name="edita" value="Guardar" >
                                        </div>
                                    </form>
                                </div>
                            </div>
                     </div>
                    </div>

            </main>
    <!-- script que se utiliza para hacer que la página sea más interactiva. -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>