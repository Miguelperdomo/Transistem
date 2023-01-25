<?php
   /* El código que se está utilizando para generar el PDF. */
    session_start();
    include("../../includes/validarsession.php");

    ob_start();//Llenar el buffer memoria
    
    $doc=$_SESSION['doc'];

    require_once("../../connections/connection.php"); 

  /* Una consulta a la base de datos. */
    $regis=$base->query("SELECT * from solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
    where solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est 
    and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
    and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_usu=$doc")->fetchALL(PDO::FETCH_OBJ);


 ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Solicitudes</title>
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
                <h4 class="text-center">Estado de Solicitudes</h4>
                <br>
                <div class="container">
                    <div class="row">
                        
                            <div class="table-responsive" id="contenido">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr>
                                            <th>N° Solicitud</th>
                                            <th>N° Documento</th>
                                            <th>Nombre</th>                                      
                                            <th>Tipo de Servicio</th>
                                            <th>Origen</th>               
                                            <th>Destino</th>
                                            <th>Estado</th>                                        
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                        foreach ($regis as $solicitud):  

                                            $ori=$solicitud->id_origen;
                                         /* Una consulta a la base de datos. */
                                            $sql= "SELECT * from origen, ciudad WHERE 
                                            origen.id_ciudad=ciudad.id_ciudad and id_origen=$ori"; 
                                            $resultado=$base->prepare($sql);
                                            $resultado->execute(array());
                                            $reg=$resultado->fetch(PDO::FETCH_ASSOC);

                                        ?> 
                                     /* Un código PHP que se utiliza para generar el PDF. */
                                        <tr class="table-light" >
                                            <td><?php echo $solicitud->id_soli?></td>
                                            <td><?php echo $solicitud->id_usu?></td>
                                            <td><?php echo $solicitud->nom_usu?></td>
                                            <td><?php echo $solicitud->servi?></td>
                                            <td><?php echo $reg['ciudad']?></td>
                                            <td><?php echo $solicitud->ciudad?></td>
                                            <td><?php echo $solicitud->tip_est?></td>
                                           
                                        </tr>
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
    /* Getting the content of the buffer and assigning it to the variable ``. */
    $html=ob_get_clean(); //Ingresando el HTML a una variable, guardar en memoria.
    //echo $html;
    
    require_once '../../libs/dompdf/autoload.inc.php';//Se crea un objeto
    use Dompdf\Dompdf;

    
    // instantiate and use the dompdf class
    $dompdf = new Dompdf(); //permitir trabajar con las funcionalidades de conversión

    
    $dompdf->loadHtml($html);

     // (Optional) Setup the paper size and orientation
    //$dompdf->setPaper('letter');
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream("clisoli.pdf", array("Attachment" => false)); //Abre el archivo, pero en el navegador(false - no descarga)
?>