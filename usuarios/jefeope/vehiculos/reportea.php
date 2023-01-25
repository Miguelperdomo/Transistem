<?php
   /* El código que se conecta a la base de datos y obtiene los datos y tare variables globales */
    session_start();
    include("../../../includes/validarsession.php");
/* Cargando el cargador automático para la biblioteca PhpSpreadsheet. */
    require '../../../vendor/autoload.php';
    require_once("../../../connections/connection.php"); 

    /* Cargando la biblioteca PhpSpreadsheet. */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    /* Esta es una consulta para obtener datos de la base de datos. */
    $sql="SELECT * from detalle_vehi, tipo_veh, usuarios, regis_veh, estado_asig where regis_veh.id_tip_veh=tipo_veh.id_tip_veh and detalle_vehi.placa=regis_veh.placa and detalle_vehi.id_usu=usuarios.id_usu and regis_veh.id_estvehi=estado_asig.id_estvehi and regis_veh.id_estvehi=1";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    
    /* Esto es crear una nueva hoja de cálculo y establecer la hoja activa en la primera hoja.*/
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Vehículos Asignados");

    // Títulos fila 1
    /* Configuración del ancho de las columnas. */
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'FECHA ASIG.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'PLACA');
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C1', 'TIPO VEHÍCULO');
    $hojaActiva->getColumnDimension('D')->setWidth(11);
    $hojaActiva->setCellValue('D1', 'CAPACIDAD');
    $hojaActiva->getColumnDimension('E')->setWidth(40);
    $hojaActiva->setCellValue('E1', 'CONDUCTOR');
    $hojaActiva->getColumnDimension('F')->setWidth(20);
    $hojaActiva->setCellValue('F1', 'ESTADO');

    $row = 2; //Contenido empezará desde la fila 2

    /* Este es un ciclo que iterará sobre los resultados de la consulta. */
    while($reg=$resultado->fetch(PDO::FETCH_ASSOC)){

        $hojaActiva->setCellValue('A'.$row, $reg['fecha']);
        $hojaActiva->setCellValue('B'.$row, $reg['placa']);
        $hojaActiva->setCellValue('C'.$row, $reg['tip_veh']);
        $hojaActiva->setCellValue('D'.$row, $reg['capaci_pasa']);
        $hojaActiva->setCellValue('E'.$row, $reg['nom_usu']);
        $hojaActiva->setCellValue('F'.$row, $reg['estvehi']);
        $row++;
    }

/* Aquí habrá un código donde creas $ hoja de cálculo */

// redirigir la salida al navegador del cliente
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="vehiasig.xls"');
header('Cache-Control: max-age=0');

/* Este es el código que generará el archivo de Excel. */
$writer = IOFactory::createWriter($excel, 'Xls');
$writer->save('php://output');
exit;
?>