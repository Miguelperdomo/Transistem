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

    /* Obtener el id de la url. */
    $busca=$_GET["id"];    


      /* Una consulta a la base de datos. */
       $sql= "SELECT * FROM rol, usuarios, tipo_cliente, ident, estado where rol.id_rol = usuarios.id_rol 
       and tipo_cliente.id_tip_clien = usuarios.id_tip_clien and ident.id_ident = usuarios.id_ident 
       and estado.id_est = usuarios.id_est and id_usu = $busca"; 
      $resultado=$base->prepare($sql);
      $resultado->execute(array());
      $regcli=$resultado->fetch(PDO::FETCH_ASSOC);

     /* Obteniendo los datos de la base de datos y almacenándolos en la variable . */
      $sql1= "SELECT * FROM usuarios, detalle_condu, turnos where usuarios.id_usu=detalle_condu.id_usu and detalle_condu.id_turno=turnos.id_turno";
      $resultado=$base->prepare($sql1);
      $resultado->execute(array());
      $turnos=$resultado->fetch(PDO::FETCH_ASSOC);
  
      $id = $regcli["id_usu"];
      $nom = $regcli["nom_usu"];
      $ro = $regcli ["rol"];
      $foto = $regcli["foto"];
      $name=$regcli["nom_usu"];
      $tipide = $regcli["ident"];
      $tipcli=$regcli["tip_clien"];
      $dire = $regcli["dir"];
      $tele=$regcli["tel"];
      $ema = $regcli["email"];
      $tipes = $regcli["tip_est"];
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
                        <h3 class="mb-0 ">Editar Conductor</h3>
                    </div>
                    <br>
                            <div class="container center4">
                                <div class="modal-body">
                                    <form method="post" action="validedit.php">
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo docu.</div>
                                                </div>
                                                <td>
                                                     <!-- Creando un menú desplegable con los valores de
                                                    la base de datos. -->
                                                    <select class="form-control" readonly name="iden" >
                                                        <?php
                                                        $sql= "SELECT * FROM ident";
                                                        $resultado=$base->prepare($sql);
                                                        $resultado->execute(array());
                                                        while($iden=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $iden['id_ident'];?>"><?php echo $iden['ident']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Documento</div>
                                                </div>
                                                <input type="text" class="form-control" readonly name="idr" value="<?php echo $id ?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rol</div>
                                                </div>
                                                <td>
                                                    <select class="form-control" readonly name="tip">
                                                        <?php
                                                         $sql= "SELECT * FROM rol WHERE id_rol =4";
                                                        $resultado=$base->prepare($sql);
                                                        $resultado->execute(array());
                                                        while($rol=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $rol['id_rol'];?>"><?php echo $rol['rol']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Cliente</div>
                                                </div>
                                                <td>
                                                    <select class="form-control" readonly name="clie" >
                                                        <?php
                                                         $sql= "SELECT * FROM tipo_cliente";
                                                        $resultado=$base->prepare($sql);
                                                        $resultado->execute(array());
                                                        while($clie=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $clie['id_tip_clien'];?>"><?php echo $clie['tip_clien']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </div>
                                         </div>                                        
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Nombre Usuario</div>
                                                </div>
                                                <input type="text" class="form-control" name="nom" value="<?php echo $nom ?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Tipo Estado</div>
                                                </div>
                                                <td>
                                                    <select class="form-control" name="est" >
                                                        <?php
                                                         $sql= "SELECT * FROM estado LIMIT 0,2";
                                                        $resultado=$base->prepare($sql);
                                                        $resultado->execute(array());
                                                        while($estado=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $estado['id_est'];?>"><?php echo $estado['tip_est']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Direccion</div>
                                                </div>
                                                <input type="text" class="form-control"  name="dir" value="<?php echo $dire ?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Telefono</div>
                                                </div>
                                                <input type="text" class="form-control"  name="tel" value="<?php echo $tele?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Email</div>
                                                </div>
                                                <input type="text" class="form-control"  name="email" value="<?php echo $ema?>">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col ">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Turno</div>
                                                </div>
                                                <td>
                                                    <select class="form-control" name="turno" >
                                                        <?php
                                                         $sql= "SELECT * FROM turnos";
                                                        $resultado=$base->prepare($sql);
                                                        $resultado->execute(array());
                                                        while($turno=$resultado->fetch(PDO::FETCH_ASSOC)){
                                                        ?>
                                                        <option value="<?php echo $turno['id_turno'];?>"><?php echo $turno['turno']?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </div>
                                         </div>
                                        <br>
                                        <div class="col-auto">
                                            <div class="input-group col">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Vigencia Licencia</div>
                                                </div>
                                                <input type="date" class="form-control"  name="vigencia" value="<?php echo $turnos['vige_lice']?>">
                                            </div>
                                        </div>
                                        
                                        <br>                           
                                        <div class="modal-footer">
                                            <a href="verconduct.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
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