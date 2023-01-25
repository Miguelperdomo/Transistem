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


if(isset($_POST['insert'])){

    if (empty($_POST['doc']) || empty($_POST['rol']) || empty($_POST['tip']) || empty($_POST['ident']) || empty($_POST['nom']) || empty($_POST['cla']) || empty($_POST['est']) || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['emai'])){
       
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
        
        $sql="INSERT INTO usuarios (id_usu, id_rol, id_tip_clien, id_ident, nom_usu, pass, id_est, dir, tel, email) values (:id, :rol, :tip, :iden, :nom, :pas, :est, :di, :tel, :email)";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":id"=>$usu, ":rol"=>$rol, ":tip"=>$tipo, ":iden"=>$ide, ":nom"=>$nombre, ":pas"=>$pass_cifrado, ":est"=>$estado, ":di"=>$direccion, ":tel"=>$telefono, ":email"=>$email));

        echo '<script>alert("Cliente Registrado con exito.");</script>';
        echo '<script>window.location= "../asesorco.php"</script>';
    }    
}

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
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Registrar Cliente</h3>
                    </div>
                    <br>
                    <!-- Insertar cliente -->
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
                                            $sql= "SELECT * FROM rol where id_rol = 5"; 
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
                            <div class="modal-footer">
                                <a href="../asesorco.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                <input  type="submit" class="btn btn-blue" name="insert" id="insert" value="Guardar" >
                            </div>
                        </form>
                    </div>  
                </div> 
            </main>
        </div>
    </div>
    <script src="loginvalida.js"></script>                                                                        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
    <script src="eliminar.js"></script>
</body>

</html>