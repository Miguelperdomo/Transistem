<?php
/* El código que se conecta a la base de datos y obtiene los datos y tare variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require '../../../vendor/autoload.php';/* Cargando el cargador automático para la biblioteca PhpSpreadsheet. */
    require_once("../../../connections/connection.php"); 

    /* Cargando la biblioteca PhpSpreadsheet. */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;

     /* Esta es una consulta para obtener datos de la base de datos. */
    $sql="SELECT * from regis_veh, vinculo, tipo_veh, modelo, marcas, carroceria, estado, estado_asig where regis_veh.id_tip_vincu=vinculo.id_tip_vincu AND regis_veh.id_tip_veh=tipo_veh.id_tip_veh AND regis_veh.id_modelo=modelo.id_modelo AND regis_veh.id_marca=marcas.id_marca and regis_veh.id_carroce=carroceria.id_carroce AND regis_veh.id_est=estado.id_est and regis_veh.id_estvehi=estado_asig.id_estvehi and regis_veh.id_estvehi=2";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
 
    /* Esto es crear una nueva hoja de cálculo y establecer la hoja activa en la primera hoja.*/
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Vehículo por Asignar");

     // Títulos fila 1
    /* Configuración del ancho de las columnas. */
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'FECHA REG.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'PLACA');
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C1', 'VÍNCULO');
    $hojaActiva->getColumnDimension('D')->setWidth(12);
    $hojaActiva->setCellValue('D1', 'TIPO VEHÍCULO');
    $hojaActiva->getColumnDimension('E')->setWidth(11);
    $hojaActiva->setCellValue('E1', 'CAPACIDAD');
    $hojaActiva->getColumnDimension('F')->setWidth(10);
    $hojaActiva->setCellValue('F1', 'MODELO');
    $hojaActiva->getColumnDimension('G')->setWidth(30);
    $hojaActiva->setCellValue('G1', 'ESTADO');

    $row = 2; //Contenido empezará desde la fila 2

     /* Este es un ciclo que iterará sobre los resultados de la consulta. */
    while($reg=$resultado->fetch(PDO::FETCH_ASSOC)){

        $hojaActiva->setCellValue('A'.$row, $reg['fech_vincu']);
        $hojaActiva->setCellValue('B'.$row, $reg['placa']);
        $hojaActiva->setCellValue('C'.$row, $reg['vinculo']);
        $hojaActiva->setCellValue('D'.$row, $reg['tip_veh']);
        $hojaActiva->setCellValue('E'.$row, $reg['capaci_pasa']);
        $hojaActiva->setCellValue('F'.$row, $reg['modelo']);
        $hojaActiva->setCellValue('G'.$row, $reg['estvehi']);
        $row++;
    }

/* Aquí habrá un código donde creas $ hoja de cálculo */

// redirigir la salida al navegador del cliente
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="vehixasignar.xls"');
header('Cache-Control: max-age=0');

/* Este es el código que generará el archivo de Excel. */
$writer = IOFactory::createWriter($excel, 'Xls');
$writer->save('php://output');
exit;
?>