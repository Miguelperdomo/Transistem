<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales y la libreria de excel */
    session_start();
    include("../../../includes/validarsession.php");
    require '../../../vendor/autoload.php';
    require_once("../../../connections/connection.php"); 

    /* Importación de las clases que se utilizarán en el código. */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    /* Una consulta para obtener datos de la base de datos.. */
    $sql="SELECT * FROM `orden_ser` 
    INNER JOIN solicitud ON orden_ser.id_soli=solicitud.id_soli
    INNER JOIN servicios ON solicitud.id_ser = servicios.id_ser
    INNER JOIN estado ON solicitud.id_est = estado.id_est
    INNER JOIN rutas ON solicitud.id_ruta =rutas.id_ruta 
    INNER JOIN origen ON rutas.id_origen = origen.id_origen 
    INNER JOIN destino ON rutas.id_destino = destino.id_destino
    INNER JOIN ciudad ON destino.id_ciudad = ciudad.id_ciudad";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    

    /* Crear una nueva hoja de cálculo y establecer la hoja activa en la primera hoja. */
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Historial Servicios Realizados");

    // Títulos fila 1
   /* Configuración del ancho de las columnas.*/
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'ORDEN N.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'SOLICITUD');
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C1', 'N. DÍAS');
    $hojaActiva->getColumnDimension('D')->setWidth(12);
    $hojaActiva->setCellValue('D1', 'N. PASAJEROS');
    $hojaActiva->getColumnDimension('E')->setWidth(30);
    $hojaActiva->setCellValue('E1', 'SERVICIO');
    $hojaActiva->getColumnDimension('F')->setWidth(50);
    $hojaActiva->setCellValue('F1', 'FECHA INICIO SERVICIO');
    $hojaActiva->getColumnDimension('G')->setWidth(50);
    $hojaActiva->setCellValue('G1', 'FECHA FIN SERVICIO');


    $row = 2; //Contenido empezará desde la fila 2

    /* Este es un ciclo que iterará sobre los resultados de la consulta. */
    while($reg=$resultado->fetch(PDO::FETCH_ASSOC)){

        $hojaActiva->setCellValue('A'.$row, $reg['id_auto']);
        $hojaActiva->setCellValue('B'.$row, $reg['id_soli']);
        $hojaActiva->setCellValue('C'.$row, $reg['n_dias']);
        $hojaActiva->setCellValue('D'.$row, $reg['n_pasa']);
        $hojaActiva->setCellValue('E'.$row, $reg['servi']);
        $hojaActiva->setCellValue('F'.$row, $reg['fecha_ini_real']);
        $hojaActiva->setCellValue('G'.$row, $reg['fecha_fin_real']);
    
        $row++;
    }

   /* Aquí habrá un código donde creas $hoja de cálculo */
    // redirigir la salida al navegador del cliente
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ordenpro.xlsx"');
    header('Cache-Control: max-age=0');

    /* Crear el archivo y guardarlo en la salida. */
    $writer = IOFactory::createWriter($excel, 'Xlsx');// Crea la hoja 
    $writer->save('php://output');
    exit;
?>