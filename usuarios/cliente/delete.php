<!-- /* Iniciando una sesión e incluyendo un archivo llamado validarsession.php. */ -->
<?php
    session_start();
    include("../../includes/validarsession.php");
    
    require_once("../../connections/connection.php");

   /* Obtener las variables de sesión. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

   /* Esta es una consulta para obtener el rol del usuario. */
    $sql= "SELECT * FROM rol, usuarios where rol.id_rol = usuarios.id_rol and id_usu = $doc"; 
   /* Una consulta para obtener el rol del usuario. */
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $reg=$resultado->fetch(PDO::FETCH_ASSOC);

   /* Obtener el id de la url y asignarlo a la variable . */
    $nomrol=$reg["rol"];
    $usu = $reg["foto"];
    
    $busca=$_GET["id"];
    
   /* Una consulta para obtener la información del usuario. */
    $sql="SELECT * FROM `solicitud` 
    INNER JOIN usuarios ON solicitud.id_usu = usuarios.id_usu 
    INNER JOIN servicios ON solicitud.id_ser = servicios.id_ser
    INNER JOIN estado ON solicitud.id_est = estado.id_est
    INNER JOIN rutas ON solicitud.id_ruta =rutas.id_ruta 
    INNER JOIN origen ON rutas.id_origen = origen.id_origen 
    INNER JOIN destino ON rutas.id_destino = destino.id_destino
    INNER JOIN ciudad ON destino.id_ciudad = ciudad.id_ciudad AND id_soli = $busca";
   /* Una consulta para obtener la información del usuario. */
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $solicitud=$resultado->fetch(PDO::FETCH_ASSOC);

   /* Asignando el valor de la variable al valor de la variable. */
    $ori=$solicitud['id_origen'];
    
  /* Esta es una consulta para obtener el origen de la ruta. */
    $sql="SELECT  * from origen, ciudad where origen.id_ciudad = ciudad.id_ciudad and id_origen = $ori";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $origen=$resultado->fetch(PDO::FETCH_ASSOC); 

    
?>

/* El código HTML de la página. */
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
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
                    <li>
                        <h5 class="navbar-brand rol usuario" ><?php echo $nomrol ?></h5>
                        <h5 class="navbar-brand rol usuario" ><?php echo $name ?></h5>
                        <a class="px-3 text-light perfil dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo (' <img src="../../fotos/'.$usu.'"  width="40" height=40" class="mr-3 rounded-circle img-thumbnail shadow-sm"> ')?></a>
                        
                        <div class="dropdown-menu" aria-labelledby="navbar-dropdown">
                            <a class="dropdown-item menuperfil cerrar" href="perfil.php?id=<?php echo $doc ?>">
                                <i class="fas fa-user m-1"></i>Perfil</a>
                            <a class="dropdown-item menuperfil cerrar" href="../../includes/close.php">
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
                <a href="cliente.php"><i class="fa-sharp fa-solid fa-bus"></i><span>Inicio</span></a>
                    <a href="solicitud.php"><i class="fa-solid fa-address-book"></i><span>Solicitar Servicio</span></a>
                    <a href="estadosoli.php"><i class="fa-solid fa-clipboard"></i><span>Estado de Solicitudes</span></a>
                    <a href="contrato.php"><i class="fa-solid fa-clipboard"></i><span>Contratos Generados</span></a>
                </nav>
            </div>
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-9" id="title">
                        <h3 class="mb-0 ">Eliminar Solicitud</h3>
                    </div>
                    <?php
	                $busca=$_GET["id"];
        
                    try{
                        $sql="SELECT  * from solicitud where id_soli=:id";
                        $resultado=$base->prepare($sql);//el objeto $base llama al metodo prepare que recibe por parametro la instrucción sql, el metodo prepare devuelve un objeto de tipo PDO que se almacena en la variable resultado
                        $resultado->execute(array(":id"=>$busca));

                        if($soli=$resultado->fetch(PDO::FETCH_ASSOC)){

                            if(isset($_POST['eliminar'])){

                                $id=$soli['id_soli'];
                        
                                $sql="DELETE FROM solicitud WHERE id_soli=:id";
                                $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
                                $resultado->execute(array(":id"=>$id));//asigno las variables a los marcadores
                                echo '<script>alert("Haz Eliminado esta Solicitud.");</script>';
                                echo '<script>window.location= "estadosoli.php"</script>';
                            }
                        
			        ?>
                    <br>
                    <!-- /* Un formulario que se utiliza para eliminar un registro de la base de datos. */ -->
                    <div class="container center4">
                        <div class="modal-body">
                            <form method="post">
                            <div class="col-auto">
                                    <div class="input-group col">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Solicitud</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="soli" value="<?php echo $solicitud['id_soli']?>">
                                    </div>
                                </div>
                                <br>
                              -->
                                <div class="col-auto">
                                    <div class="input-group col">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Documento</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="idr" value="<?php echo $solicitud['id_usu']?>">
                                    </div>
                                </div>
                                <br>
                   
                                <div class="col-auto">
                                    <div class="input-group col ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Tipo de Servicio</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="ser" value="<?php echo $solicitud['servi']?>">
                                    </div>
                                </div>
                                <br>
                                <div class="col-auto">
                                    <div class="input-group col ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Ruta</div>
                                        </div>
                                        <input type="text" class="form-control" readonly name="ruta" value="<?php echo $origen['ciudad']?> - <?php echo $solicitud['ciudad']?>">
                                    </div>
                                </div>
                                <br>                                
                                <div class="modal-footer">
                                    <a href="estadosoli.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                    <input  type="submit" class="btn btn-blue" name="eliminar" value="Eliminar" >
                                </div>
                            </form>
                        </div>
                </div>
                <?php
    
                     /* Esta es una declaración condicional que se usa para mostrar un mensaje si el
                      registro no existe. */
                        }else{
                            echo "No existe $busca";
                        }
                    $resultado->closeCursor();

                    }catch(Exception $e){
                          /* Mensaje que se muestra cuando el usuario intenta borrar un registro que está
                        está siendo utilizado en otra tabla. */
	                    die('<br><div class="alert alert-danger center4"> Solo se pueden eliminar solicitudes "En Tramite". Consulte al Asesor comercial para eliminar.
                            </div><br>
                            <div class="container">
                            <a href="estadosoli.php"><button type="button" class="btn btn-secondary">Volver</button></a>
                            </div>');
                    }finally{
	                    $base=null;//vaciar memoria
                    }

                    ?>
            </main>
    <!-- /* Este es un script que se utiliza para cargar la biblioteca de arranque. */ -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
</html>