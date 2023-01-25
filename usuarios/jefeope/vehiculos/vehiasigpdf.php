<?php

    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    ob_start();//Llenar el buffer / espacio en memoria
    require_once("../../../connections/connection.php"); 

    /* La etiqueta de cierre para PHP. */
    $reg=$base->query("SELECT * from regis_veh, vinculo, tipo_veh, modelo, marcas, carroceria, estado, estado_asig where regis_veh.id_tip_vincu=vinculo.id_tip_vincu AND regis_veh.id_tip_veh=tipo_veh.id_tip_veh AND regis_veh.id_modelo=modelo.id_modelo AND regis_veh.id_marca=marcas.id_marca and regis_veh.id_carroce=carroceria.id_carroce AND regis_veh.id_est=estado.id_est and regis_veh.id_estvehi=estado_asig.id_estvehi and regis_veh.id_estvehi=2")->fetchALL(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jefe Operaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <style>
        body {
            background: #f1f1f1;        
        }

        .barra {
            background: #084288;
            padding-top: 15px;
            padding-bottom: 15px;
            margin: 0;
        }

        .main {
            padding-top: 40px;
        }

        .main .columna {
            padding-left: 40px;
            padding-right: 40px;
        }

        table{
            text-align: center;
        }

        h4{
            text-align: center;
        }

        .barra {
            background: #084288;
            padding-top: 15px;
            padding-bottom: 15px;
            margin: 0;
        }
    </style>
</head>

<body>
    <!--Barra cabecera-->
    <!-- <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <img src="resultBase64.txt" />
                <img src="logo_blanco.png" />
            </div>
            <div class="col-4 text-right barra">
            </div>
        </div>
    </div> -->
    <div class="container-fluid">
        <div class="row">
            <!--Contenido principal-->
            <main class="main col">
                <!-- <div class="container">
                    <img src="../img/puriesturlogo.png" alt="usu" width="150px" class="center">
                </div> -->
                <br>
                <h4 class="text-center">Vehículo por Asignar</h4>
                <br>
                <div class="container">
                    <div class="row">
                        
                            <div class="table-responsive" id="contenido">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr> <!-- Crear un encabezado de tabla. -->
                                            <th>Fecha Registro</th>
                                            <th>Placa</th>
                                            <th>Vínculo</th>  
                                            <th>Tipo Vehículo</th>      
                                            <th>Capacidad</th>                                    
                                            <th>Modelo</th>
                                            <th>Estado</th>  
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="myTable">
                                        <?php
                                         /* Creando un bucle foreach que recorrerá el
                                           matriz y asigne cada valor a la variable. */
                                        foreach ($reg as $vehiculos):
                                        ?> 
                                        <tr class="table-light" >
                                            <!-- Un código PHP que se utiliza para mostrar los datos del
                                            base de datos. -->
                                            <td><?php echo $vehiculos->fech_vincu?></td>
                                            <td><?php echo $vehiculos->placa?></td>
                                            <td><?php echo $vehiculos->vinculo?></td>
                                            <td><?php echo $vehiculos->tip_veh?></td>
                                            <td><?php echo $vehiculos->capaci_pasa?></td>
                                            <td><?php echo $vehiculos->modelo?></td>
                                            <td><?php echo $vehiculos->estvehi?></td>        
                                        </tr>
                                        <!-- Cerrando el bucle foreach. -->
                                        <?php
                                        endforeach;
                                        ?>                                                                     
                                    </tbody>        
                                </table>
                            </div>
                        
                    </div> 
                </div>
            </main>
        </div>
    </div>
   
</body>
</html>
<?php
     /* Obtener el contenido del búfer y asignarlo a la variable ``. */
    $html=ob_get_clean(); //Ingresando el HTML a una variable, guardar en memoria.
    //echo $html;
    
    require_once '../../../libs/dompdf/autoload.inc.php';//Se crea un objeto
    use Dompdf\Dompdf;

    
    // instanciar y usar la clase dompdf
    $dompdf = new Dompdf(); //permitir trabajar con las funcionalidades de conversión

    
    $dompdf->loadHtml($html);

     // (Optional) Setup the paper size and orientation
    //$dompdf->setPaper('letter');
    $dompdf->setPaper('A4', 'landscape');

    // Renderizar el HTML como PDF
    $dompdf->render();

    // Salida del PDF generado al navegador
    $dompdf->stream("vehixasignar.pdf", array("Attachment" => false)); //Abre el archivo, pero en el navegador(false - no descarga)
?>