<?php
    require_once("../../connections/connection.php");
/* Obtener la identificación de la URL y luego usarla para consultar la base de datos. */

    $docu=$_GET['id'];
    
    $sql="SELECT * from usuarios where id_usu=:id";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$docu));
    $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

  /* Comprobando si los campos están vacíos. */
    if(isset($_POST['insert'])){

        if (empty($_POST['servicio']) || empty($_POST['ruta']) || empty($_POST['fechaini']) || empty($_POST['hora']) || empty($_POST['pasajeros']) || empty($_POST['reco']) ){
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>'; 
      /* Calculando la diferencia entre dos fechas. */
        }else{

            $fechainicial=$_POST['fechaini'];
            $fechafinal=$_POST['fechafin'];
            $segundosTranscurridos =strtotime($fechafinal) - strtotime($fechainicial);
            $minutosTranscurridos =$segundosTranscurridos / 60;
            $horas = $minutosTranscurridos / 60;
            $dias = $horas / 24;
            $diasRedondiados =floor($dias);   
        
          /* Obtener los valores del formulario y almacenarlos en variables. */
            $docu=$_POST['docu'];
            $servicio=$_POST['servicio'];
            $ruta=$_POST['ruta'];
            
            $fechainicial=$_POST['fechaini'];
            $fechafinal=$_POST['fechafin'];
            $hora=$_POST['hora'];
            $pasajero=$_POST['pasajeros'];
            $recomendado=$_POST['reco'];
            $estado = 3;
           /* Comprobando si el valor de es 0. Si lo es, mostrará una alerta y redirigirá el
           usuario a la página solicitud.php. */
            if ($ruta == 0) {
                echo '<script>alert("No ha seleccionado un destino.");</script>';
                echo '<script>window.location= "solicitud.php"</script>';
            }
           /* Insertar los datos en la base de datos. */
            else{

                $sql="INSERT INTO solicitud (id_usu, id_ser, id_ruta, fech_ini, fech_fin, hora_ini, n_dias, n_pasa, recomend, id_est) values (:usu, :ser, :ruta, :fechini, :fechfn, :hora, :dia, :pasa, :recomen, :est)";
                $resultado=$base->prepare($sql);
                $resultado->execute(array( ":usu"=>$docu, ":ser"=>$servicio, ":ruta"=>$ruta, ":fechini"=>$fechainicial, ":fechfn"=>$fechafinal, ":hora"=>$hora, ":dia"=>$diasRedondiados, ":pasa"=>$pasajero, ":recomen"=>$recomendado, ":est"=>$estado));
                
              /* El código anterior está enviando un correo electrónico al usuario con la información que tiene
              ingresado en el formulario. */
                echo '<script>alert("Se ha enviado su solicitud con Exito.");</script>';
                echo '<script>window.location= "../../index.html"</script>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashuser.css">
    <link rel="stylesheet" href="../../css/stylecusto.css">
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
            </div>
        </div>
    </div>
    <div class="container-fluid">
        
            <!--Contenido principal-->
            <main class="main col">
                <div class="row justify-content-center align-content-center text-center">
                    <div class="col-sm-12" id="title">
                        <h3 class="mb-0 ">Solicitar servicio</h3>
                    </div>
                </div>
                <div class="container center4">
                    <!-- <div class="row">
                       <div class="col">
                            <a href="calendario.php"><button class="btn btn-primary">Verificar disponibilidad</button></a>
                        </div> 
                    </div> -->
                    <br>
                    <form method="POST" action="" id="form" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong> N. Documento</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly name="docu" value="<?php echo $usuarios['id_usu'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Nombre</strong></span>
                                    </div>
                                    <input type="text" class="form-control" readonly value="<?php echo $usuarios['nom_usu'] ?>" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5>Datos del servicio</h5>
                        
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> <strong>Servicio</strong> </span>
                                    </div>
                                    <select class="custom-select" name="servicio">
                                        <option value="" >Seleccione</option>
                                        <?php
                                        $sql= "SELECT * FROM servicios"; 
                                        $resultado=$base->prepare($sql);
                                        $resultado->execute(array());
                                        while($servicio=$resultado->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                            <option value="<?php echo $servicio['id_ser'];?>"><?php echo $servicio['servi'];?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Origen</strong></span>
                                    </div>
                                        <?php
                                        $sql= "SELECT * FROM origen, ciudad where origen.id_ciudad = ciudad.id_ciudad"; 
                                        $resultado=$base->prepare($sql);
                                        $resultado->execute(array());
                                        $orig=$resultado->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                    <input type="text" class="form-control" readonly value="<?php echo $orig['ciudad'];?>">                           
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Destino</strong></span>
                                    </div>
                                    <select class="custom-select" name="ruta" id="des">
                                        <option value="0">Seleccionar</option>
                                            <?php
                                            $sql= "SELECT * FROM rutas, destino, ciudad 
                                            where destino.id_ciudad = ciudad.id_ciudad and rutas.id_destino = destino.id_destino "; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            while($regi3=$resultado->fetch(PDO::FETCH_ASSOC)){
                                            ?>    
                                        <option value="<?php echo $regi3['id_ruta'];?>"><?php echo $regi3['ciudad'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>                            
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Fecha Inicio</strong></span>
                                    </div>
                                    <input type="date"   class="form-control" aria-label="Username" min="2022-10-30" max="2025-01-1" name="fechaini"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Fecha Final</strong></span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="Username" name="fechafin"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Hora Inicial</strong></span>
                                    </div>
                                    <input type="time" class="form-control"  aria-label="Username" name="hora"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><strong>Número Pasajeros</strong></span>
                                    </div>
                                    <input type="number" class="form-control" name="pasajeros" id="pas"  aria-label="Username"
                                        aria-describedby="basic-addon1">
                                        <div class="warnings" id="warnings1"></div>   
                                </div>
                                <center><small>El numero de pasajeros debe ser minimo 9 maximo 100</small></center>
                            </div>
                        </div>
                        <br>
                        <h5>Escriba recomendaciones adicionales</h5>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Dirección punto de encuentro, llegada, solicitudes especiales de pasajeros, entre otros...</label>
                            <textarea class="form-control" name="reco" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <!-- <div class="input-group input-group">
                            <input type="text" name="reco" class="form-control fs-5" aria-label="Large" placeholder="Dirección punto de encuentro, solicitudes especiales de pasajeros, ..." aria-describedby="inputGroup-sizing-sm ">
                        </div> -->
                        <div class="modal-footer">
                            <a href="buscarusu.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                            <input  type="submit" class="btn btn-blue" name="insert" id="insert" value="Enviar" >
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="validasoli.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>

</html>