<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../../includes/validarsession.php");
    
    require '../../../../vendor/autoload.php';
    require_once("../../../../connections/connection.php"); 

        /* Importar las clases necesarias para crear la hoja de cálculo.. */
    /* Importar la clase Spreadsheet de la librería PhpSpreadsheet.  */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
   /* Importar la clase IOFactory de la librería PhpSpreadsheet. */
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $sql="SELECT * from solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
    where solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est 
    and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
    and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_est=3";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    
    /* Crear una nueva hoja de cálculo y establecer la hoja activa en la primera hoja. */
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Solicitudes en Tramite");

    // Títulos fila 1
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'FECHA REG.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'SOLICITUD');
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C1', 'N. DOCUMENTO.');
    $hojaActiva->getColumnDimension('D')->setWidth(12);
    $hojaActiva->setCellValue('D1', 'NOMBRE');
    $hojaActiva->getColumnDimension('E')->setWidth(30);
    $hojaActiva->setCellValue('E1', 'SERVICIO');
    $hojaActiva->getColumnDimension('F')->setWidth(10);
    $hojaActiva->setCellValue('F1', 'DESTINO');
    $hojaActiva->getColumnDimension('G')->setWidth(30);
    $hojaActiva->setCellValue('G1', 'ESTADO');


    $row = 2; //Contenido empezará desde la fila 2

    while($reg=$resultado->fetch(PDO::FETCH_ASSOC)){

        $hojaActiva->setCellValue('A'.$row, $reg['fech_soli']);
        $hojaActiva->setCellValue('B'.$row, $reg['id_soli']);
        $hojaActiva->setCellValue('C'.$row, $reg['id_usu']);
        $hojaActiva->setCellValue('D'.$row, $reg['nom_usu']);
        $hojaActiva->setCellValue('E'.$row, $reg['servi']);
        $hojaActiva->setCellValue('F'.$row, $reg['ciudad']);
        $hojaActiva->setCellValue('G'.$row, $reg['tip_est']);
    
        $row++;
    }

// Redirigir el archivo de salida al navegador del cliente
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="soliTra.xlsx"');
    header('Cache-Control: max-age=0');

        /*  Guardar el archivo en el servidor. */
    $writer = IOFactory::createWriter($excel, 'Xlsx');// Crea la hoja 
    $writer->save('php://output');
    exit;
?>