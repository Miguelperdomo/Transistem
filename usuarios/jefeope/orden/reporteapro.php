<?php
    /* El código que se utiliza para conectarse a la base de datos. */
    session_start();
    include("../../../includes/validarsession.php");
    require '../../../vendor/autoload.php';/* Cargando el cargador automático para la biblioteca PHPExcel. */
    require_once("../../../connections/connection.php"); 

    /* Cargando la biblioteca PHPExcel. */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    /* Esta es una consulta a la base de datos. */
    $sql="SELECT * from solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad 
    where solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_est = estado.id_est 
    and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino 
    and destino.id_ciudad=ciudad.id_ciudad and solicitud.id_est=5";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    

    /* Esto es crear una nueva hoja de cálculo y configurar la hoja activa como la primera hoja. */
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Solicitudes Aprobadas");

   // Títulos fila 1
    /* Esto establece el ancho de las columnas y los valores de la primera fila. */
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'FECHA REG.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'SOLICITUD');
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C1', 'N. DOCUMENTO.');
    $hojaActiva->getColumnDimension('D')->setWidth(30);
    $hojaActiva->setCellValue('D1', 'NOMBRE');
    $hojaActiva->getColumnDimension('E')->setWidth(30);
    $hojaActiva->setCellValue('E1', 'SERVICIO');
    $hojaActiva->getColumnDimension('F')->setWidth(10);
    $hojaActiva->setCellValue('F1', 'DESTINO');
    $hojaActiva->getColumnDimension('G')->setWidth(30);
    $hojaActiva->setCellValue('G1', 'ESTADO');


    $row = 2; //Contenido empezará desde la fila 2

   /* Este es un bucle while que recorre la base de datos y obtiene los valores de las columnas. */
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

   /* Aquí habrá un código donde creas $hoja de cálculo */
    // redirigir la salida al navegador del cliente
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="soliTra.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($excel, 'Xlsx');// Crea la hoja 
    $writer->save('php://output');
    exit;
?>