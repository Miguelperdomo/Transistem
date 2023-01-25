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
 
    /* Insertar datos en la base de datos. */
     if(isset($_POST['insert'])){

        /* Comprobando si los campos están vacíos. */
        if (empty($_POST['doc']) || empty($_POST['tip']) || empty($_POST['ident']) || empty($_POST['nom']) || empty($_POST['cla']) || empty($_POST['est']) || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['emai']) || empty($_POST['turno']) || empty($_POST['vigencia'])){
       
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>'; 
    
        }else{
            $usu=$_POST['doc'];
            $rol=$_POST['rol'];
            $tipo=$_POST['tip'];
            $ide=$_POST['ident'];
            $nombre=$_POST['nom'];
            $clave=$_POST['cla'];
            $pass_cifrado=password_hash($clave,PASSWORD_DEFAULT,array("cost"=>12));//encripta lo que hay en la variable password
            $estado=$_POST['est'];
            $direccion=$_POST['dir'];
            $telefono=$_POST['tel'];
            $email=$_POST['emai'];
            $turno=$_POST['turno'];
            $vigencia=$_POST['vigencia'];    

            /* Proceso de Guardar Imagen */
            $foto = $_FILES['imagen'] ['name'];
            $ruta = $_FILES['imagen'] ['tmp_name'];
            $tamano = $_FILES['imagen'] ['size'];
            $ext = $_FILES['imagen'] ['type'];
            $destino = "../../../fotos/".$foto;
            copy($ruta,$destino);

            /* Selección del usuario de la base de datos. */
            $sql= "SELECT * FROM usuarios where id_usu = :id"; 
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":id"=>$usu));
            $regi=$resultado->fetch(PDO::FETCH_ASSOC);

            /* Comprobando si el usuario existe en la base de datos. Si lo hace, alertará al usuario de que el
            usuario ya existe y redirigirlo a la página de inicio de sesión. */
            if($regi){
                echo "<script>alert ('Ya existe el Cliente')</script>";
                echo "<script>window.location='agregar.php'</script>";
            }else{

                /* Insertar los datos en la base de datos. */
                $sql="INSERT INTO usuarios (id_usu, id_rol, id_tip_clien, id_ident, nom_usu, pass, id_est, dir, tel, email, foto) values (:id, :rol, :tip, :iden, :nom, :pas, :est, :di, :tel, :email, :foto)";
                $resultado=$base->prepare($sql);
                $resultado->execute(array(":id"=>$usu, ":rol"=>$rol, ":tip"=>$tipo, ":iden"=>$ide, ":nom"=>$nombre, ":pas"=>$pass_cifrado, ":est"=>$estado, ":di"=>$direccion, ":tel"=>$telefono, ":email"=>$email, ":foto"=>$foto));

                $sql1="INSERT INTO detalle_condu (id_usu, id_turno, vige_lice) values (:id, :tur, :vig)";
                $resultado=$base->prepare($sql1);
                $resultado->execute(array(":id"=>$usu, ":tur"=>$turno, ":vig"=>$vigencia));

                $estAsig=2;

                /* Actualización de la tabla "usuarios" con los valores de las variables y . */
                $sql="UPDATE usuarios  SET  id_estvehi=:asi WHERE id_usu=:con";
                $resultado=$base->prepare($sql); 
                $resultado->execute(array(":con"=>$usu,":asi"=>$estAsig));
                
                echo "<script>alert ('Registro exitoso.')</script>";
                echo "<script>window.location='verconduct.php'</script>";

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
                        <h3 class="mb-0 ">Registrar Conductor</h3>
                    </div>
                    <br>
                    <!-- Formulario de registro -->                
                    <div class="container center4">
                    <form method="post" action="" enctype="multipart/form-data" id="form" autocomplete="off">
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rol</div>
                                    </div>
                                    <select class="custom-select" name="rol">
                                        <?php
                                        /* Obteniendo los datos de la base de datos y mostrándolos en el
                                        desplegable. */
                                        $sql= "SELECT * FROM rol where id_rol=4"; 
                                        $resultado=$base->prepare($sql);
                                        $resultado->execute(array());
                                        while($roless=$resultado->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option value="<?php echo $roless['id_rol'];?>"><?php echo $roless['rol'];?></option>
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
                                        <div class="input-group-text">Tipo documento</div>
                                    </div>
                                    <select class="custom-select" name="ident">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            /* Obteniendo los datos de la base de datos y almacenándolos en
                                            La variable . */
                                            $sql= "SELECT * FROM ident"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($ident=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $ident['id_ident'];?>"><?php echo $ident['ident'];?></option>
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
                                        <div class="input-group-text">Documento</div>
                                    </div>
                                    <input type="number" class="form-control" name="doc" id="doc">
                                    <div class="warnings" id="warnings1"></div>
                                </div>
                                <center><small>El documento debe tener mas 7 números</small></center>
                            </div>
                            <br>               
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Nombre completo</div>
                                    </div>
                                    <input type="text" class="form-control" name="nom">
                                </div>
                            </div>
                            <br>
                            
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Tipo</div>
                                    </div>
                                    <select class="custom-select" name="tip">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            /* Obteniendo los datos de la base de datos y almacenándolos en el
                                           variable . */
                                            $sql= "SELECT * FROM tipo_cliente"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($tipos=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $tipos['id_tip_clien'];?>"><?php echo $tipos['tip_clien'];?></option>
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
                                        <div class="input-group-text">Dirección</div>
                                    </div>
                                    <input type="text" class="form-control" name="dir">
                                </div>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Telefono</div>
                                    </div>
                                    <input type="number" class="form-control" name="tel" id="tel">
                                    <div class="warnings" id="warnings2"></div>
                                </div>
                                <center><small>El Telefono debe tener mas de 7 números </small></center>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Email</div>
                                    </div>
                                    <input type="text" class="form-control" name="emai" id="email">
                                    <div class="warnings" id="warnings4"></div>
                                </div>
                                <center><small>Correo debe ser valida</small></center>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Clave</div>
                                    </div>
                                    <input type="password" class="form-control" name="cla" id="clave">
                                    <div class="warnings" id="warnings3"></div>
                                </div>
                                <center><small>Clave debe tener mínimo 8 caracteres entre minúsculas, mayúsculas, símbolos y números</small></center>
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Estado</div>
                                    </div>
                                    <select class="custom-select" name="est">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            /* Obteniendo los datos de la base de datos y almacenándolos en
                                            La variable . */
                                            $sql= "SELECT * FROM estado LIMIT 2"; 
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
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Foto</div>
                                    </div>
                                   <!-- Llama previamente la función cuando el archivo/foto cambia. -->
                                    <input type="file" class="form-control" name="imagen" id="icon-image" onchange="preview(event)" >
                                    <img class="img-thumbnail" id="img-preview">
                                    <span id="icon-cerrar"></span>
                                </div>
                                <center><small>Solamente permite imagenes jpg, jpge, png</small></center> 
                            </div>
                            <br>
                            <div class="col-auto">
                                <div class="input-group col ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Turno</div>
                                    </div>
                                    <select class="custom-select" name="turno">
                                            <option value="" >Seleccione</option>
                                            <?php
                                            /* Obteniendo los datos de la base de datos y almacenándolos en
                                            La variable . */
                                            $sql= "SELECT * FROM turnos LIMIT 2"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($turno=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $turno['id_turno'];?>"><?php echo $turno['turno'];?></option>
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
                                        <div class="input-group-text">Vigencia Licencia</div>
                                    </div>
                                   <!-- Llama previamente la función cuando el archivo/foto cambia. -->
                                    <input type="date" class="form-control" name="vigencia" id="vigencia">
                                    <img class="img-thumbnail" id="img-preview">
                                    <span id="icon-cerrar"></span>
                                </div>
                            </div>
                            <br>                                                                                                                                    
                            <div class="modal-footer">
                                <a href="verconduct.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                <input  type="submit" class="btn btn-blue" name="insert" id="insert" value="Guardar" >
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
    <script src="loginvalida.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>