<?php
    session_start();
    include("../../../includes/validarsession.php");
    
    require '../../../vendor/autoload.php';
    require_once("../../../connections/connection.php"); 

     /* Importar las clases necesarias para crear la hoja de cálculo.. */
    /* Importar la clase Spreadsheet de la librería PhpSpreadsheet.  */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
   /* Importar la clase IOFactory de la librería PhpSpreadsheet. */
    use PhpOffice\PhpSpreadsheet\IOFactory;

    $sql="SELECT * from usuarios, rol, estado, tipo_cliente, ident where usuarios.id_rol=rol.id_rol and usuarios.id_est=estado.id_est and usuarios.id_tip_clien=tipo_cliente.id_tip_clien and usuarios.id_ident=ident.id_ident and usuarios.id_rol=5 and usuarios.id_est=1";
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

// Redirigir el archivo de salida al navegador del cliente
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="clientesAct.xlsx"');
    header('Cache-Control: max-age=0');
        /*  Guardar el archivo en el servidor. */      
    $writer = IOFactory::createWriter($excel, 'Xlsx');// Crea la hoja 
    $writer->save('php://output');
    exit;
?>