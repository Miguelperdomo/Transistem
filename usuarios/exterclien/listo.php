<?php

    require_once("../../connections/connection.php");

    $id=$_GET['id'];

  /* Un comentario. */
    /* Una consulta a la base de datos. */
    $regis=$base->query("SELECT * from solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
        where solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est 
        and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
        and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_usu = $id")->fetchALL(PDO::FETCH_OBJ);

        if ($regis)
        {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
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
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!--Contenido principal-->
            <main class="main col">
                <div class="container">
                    <img src="../../img/rutas.png" alt="usu" width="150px" class="center">
                </div>
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="contenido">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr>
                                            <th>N. Solicitud</th>
                                            <th>N. Documento</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Estado</th>
                                            <th colspan="3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                         /* Un ciclo que va a través de los resultados de la consulta y
                                           luego está haciendo otra consulta para obtener el nombre de la ciudad.
                                           </código> */
                                            foreach ($regis as $solicitud):
                                                $ori=$solicitud->id_origen;
                                                
                                                $sql= "SELECT * from origen, ciudad WHERE 
                                                origen.id_ciudad=ciudad.id_ciudad and id_origen=$ori"; 
                                                $resultado=$base->prepare($sql);
                                                $resultado->execute(array());
                                                $reg=$resultado->fetch(PDO::FETCH_ASSOC);
                                                                                          
                                        ?> 
                                        <!-- /* Una fila de tabla. */ -->
                                        <tr class="table-light" >
                                            <td><?php echo $solicitud->id_soli?></td>
                                            <td><?php echo $solicitud->id_usu?></td>
                                            <td><?php echo $solicitud->nom_usu?></td>
                                            <td><?php echo $solicitud->servi?></td>
                                            <td>
                                                <?php echo $reg['ciudad']?>
                                            </td>
                                            <td>
                                                <?php echo $solicitud->ciudad?>       
                                            </td>

                                            <td><?php echo $solicitud->tip_est;?></td>
                                            <td>
                                                <a href="ver.php?id=<?php echo $solicitud->id_soli?>"><button type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button></a>
                                            </td>
                                        </tr>
                                        <?php
                                        endforeach;
                                        ?>                                                                     
                                    </tbody>        
                                </table>
                                <div class="modal-footer">
                                    <a href="../../index.html"><button type="button" class="btn btn-secondary">Volver</button></a>
                               </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script>
</body>
<?php
        }

     /*  Una sentencia else. */
        else
        {
            echo '<script>alert("No hay solitud asosciada. Por favor verificar.");</script>';
            echo '<script>window.location= "../../index.html"</script>';
        }
?>
</html>
