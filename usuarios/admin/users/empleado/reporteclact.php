<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../../includes/validarsession.php");    
    require_once("../../../../connections/connection.php"); //conexión a la BD
    require '../../../../vendor/autoload.php';

 /* Importar las clases necesarias para crear la hoja de cálculo.. */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $sql="SELECT * from usuarios, rol, estado, tipo_cliente, ident where usuarios.id_rol=rol.id_rol and usuarios.id_est=estado.id_est and usuarios.id_tip_clien=tipo_cliente.id_tip_clien and usuarios.id_ident=ident.id_ident and usuarios.id_est=1";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    
/* Crear una nueva hoja de cálculo y establecer la hoja activa en la primera hoja. */
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Clientes Activos");

    // Títulos fila 1
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'FECHA REG.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'TIPO PERSONA');
    $hojaActiva->getColumnDimension('C')->setWidth(20);
    $hojaActiva->setCellValue('C1', 'TIPO IDENT.');
    $hojaActiva->getColumnDimension('D')->setWidth(12);
    $hojaActiva->setCellValue('D1', 'N. DOCUMENTO');
    $hojaActiva->getColumnDimension('E')->setWidth(30);
    $hojaActiva->setCellValue('E1', 'NOMBRE');
    $hojaActiva->getColumnDimension('F')->setWidth(10);
    $hojaActiva->setCellValue('F1', 'ESTADO');
    $hojaActiva->getColumnDimension('G')->setWidth(30);
    $hojaActiva->setCellValue('G1', 'DIRECCIÓN');
    $hojaActiva->getColumnDimension('H')->setWidth(12);
    $hojaActiva->setCellValue('H1', 'TELÉFONO');
    $hojaActiva->getColumnDimension('I')->setWidth(30);
    $hojaActiva->setCellValue('I1', 'EMAIL');

    $row = 2; //Contenido empezará desde la fila 2

    while($reg=$resultado->fetch(PDO::FETCH_ASSOC)){

        $hojaActiva->setCellValue('A'.$row, $reg['fecha_reg']);
        $hojaActiva->setCellValue('B'.$row, $reg['tip_clien']);
        $hojaActiva->setCellValue('C'.$row, $reg['ident']);
        $hojaActiva->setCellValue('D'.$row, $reg['id_usu']);
        $hojaActiva->setCellValue('E'.$row, $reg['nom_usu']);
        $hojaActiva->setCellValue('F'.$row, $reg['tip_est']);
        $hojaActiva->setCellValue('G'.$row, $reg['dir']);
        $hojaActiva->setCellValue('H'.$row, $reg['tel']);
        $hojaActiva->setCellValue('I'.$row, $reg['email']);
        $row++;
    }

/* Here there will be some code where you create $spreadsheet */

// redirect output to client browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="clienAct.xls"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($excel, 'Xls');
$writer->save('php://output');
exit;
?>