<?php
    require_once("../../connections/connection.php");

   /* Obtener la identificación de la URL y luego verificar si se ha hecho clic en el botón Insertar. */
    $docu=$_GET['id'];

    if(isset($_POST['insert'])){

    /* Comprobando si el formulario está vacío. */
        if (empty($_POST['doc']) || empty($_POST['tip']) || empty($_POST['ident']) || empty($_POST['nom']) || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['emai'])){
           
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>'; 
    
      /* Asignar los valores del formulario a las variables. */
        }else{
            $usu=$_POST['doc'];
            $rol= 5;
            $tipo=$_POST['tip'];
            $ide=$_POST['ident'];
            $nombre=$_POST['nom'];
            $estado = 2;
            $direccion=$_POST['dir'];
            $telefono=$_POST['tel'];
            $email=$_POST['emai'];           
        
             /* Insertar los datos en la base de datos. */
            $sql="INSERT INTO usuarios (id_usu, id_rol, id_tip_clien, id_ident, nom_usu, id_est, dir, tel, email) values (:id, :rol, :tip, :iden, :nom, :est, :di, :tel, :email)";
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":id"=>$usu, ":rol"=>$rol, ":tip"=>$tipo, ":iden"=>$ide, ":nom"=>$nombre, ":est"=>$estado, ":di"=>$direccion, ":tel"=>$telefono, ":email"=>$email));
            
            header("Location: soliciexter.php?id=$usu");
        }    
    }
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashuser.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/bus.png">
</head>
<body>
    <!--Barra cabecera-->
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light"><img src="../../img/logo_blanco.png" alt="logo" width="200px"></h4>
            </div>
            <div class="col-4 text-right barra">
                <ul class="navbar-nav mr-auto">
            </div>
        </div>
    </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Registrar Solicitud</h3>
                    </div>
                </div>
                <!-- Insertar cliente -->
                <div class="container center4">
                    <p class="text-center">Diligencie el siguiente formulario con sus datos de contacto:</p>
                        <form method="post" id="form" enctype="multipart/form-data" autocomplete="off">
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
                                        <div class="input-group-text">Tipo documento</div>
                                    </div>
                                    <select class="custom-select" name="ident">
                                            <option value="" >Seleccione</option>
                                            <?php
                                           /* Una consulta a la base de datos para obtener los valores de la tabla
                                            identificador */
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
                                    <input type="number" class="form-control" name="doc" id="doc" value="<?php echo $docu ?>" >
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
                                    <div class="warnings" id="warnings3"></div>
                                </div>
                                <center><small>Correo debe ser valida</small></center>
                            </div>
                            <br>                                                                                                         
                            <!-- /* El botón que redirige a la página index.html. */ -->
                            <div class="modal-footer">
                                <a href="../../index.html"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                <input  type="submit" class="btn btn-blue" name="insert" id="insert" value="Continuar" >
                            </div>
                        </form>
                    </div> 
            </main>
        </div>
    </div>
    <script src="loginvalida.js"></script>  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>