<?php
   /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
   session_start();
   include("../../../../includes/validarsession.php");

    ob_start();//Llenar el buffer
    

    require_once("../../../../connections/connection.php"); 

    $reg=$base->query("SELECT * from usuarios, rol, estado, tipo_cliente, ident where usuarios.id_rol=rol.id_rol and usuarios.id_est=estado.id_est and usuarios.id_tip_clien=tipo_cliente.id_tip_clien and usuarios.id_ident=ident.id_ident and usuarios.id_est=1")->fetchALL(PDO::FETCH_OBJ);

// ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Activos</title>
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
                <h4 class="text-center">Clientes Activos</h4>
                <br>
                <div class="container">
                    <div class="row">
                        
                            <div class="table-responsive" id="contenido">        
                                <table id="tablaRoles" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center ">
                                        <tr>
                                            <th>Fecha Reg.</th>
                                            <th>Tipo persona</th>
                                            <th>Tipo Ident.</th>                                      
                                            <th>Documento</th>
                                            <th>Nombre</th>               
                                            <th>Estado</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                        foreach ($reg as $usuarios):  
                                        ?> 
                                        <tr class="table-light" >
                                            <td><?php echo $usuarios->fecha_reg?></td>
                                            <td><?php echo $usuarios->tip_clien?></td>
                                            <td><?php echo $usuarios->ident?></td>
                                            <td><?php echo $usuarios->id_usu?></td>
                                            <td><?php echo $usuarios->nom_usu?></td>
                                            <td><?php echo $usuarios->tip_est?></td>
                                            <td><?php echo $usuarios->dir?></td>
                                            <td><?php echo $usuarios->tel?></td>
                                            <td><?php echo $usuarios->email?></td>
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
    
    require_once '../../../../libs/dompdf/autoload.inc.php';//Se crea un objeto
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
    $dompdf->stream("cliact.pdf", array("Attachment" => false)); //Abre el archivo, pero en el navegador(false - no descarga)
?>