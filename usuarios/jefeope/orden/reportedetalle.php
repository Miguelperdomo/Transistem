<?php
   /* El código que se conecta a la base de datos. */ 
    session_start();
    include("../../../../includes/validarsession.php");
    require '../../../../vendor/autoload.php';/* Cargando el cargador automático para la biblioteca PHPExcel. */
    require_once("../../../../connections/connection.php"); 

    /* Importación de la clase de hoja de cálculo de la biblioteca PhpSpreadsheet. */
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
   /* Importación de la clase IOFactory de la biblioteca PhpSpreadsheet. */
    use PhpOffice\PhpSpreadsheet\IOFactory;

    /* Una consulta a la base de datos. */
    $sql="SELECT * from detalle_ord, orden_ser, solicitud, usuarios, servicios, estado, rutas, origen, destino, ciudad, detalle_vehi where detalle_ord.id_soli=orden_ser.id_soli and detalle_ord.id_est=estado.id_est and orden_ser.id_soli=solicitud.id_soli and solicitud.id_usu=usuarios.id_usu and solicitud.id_ser=servicios.id_ser and solicitud.id_ruta = rutas.id_ruta and rutas.id_origen=origen.id_origen and rutas.id_destino=destino.id_destino and destino.id_ciudad=ciudad.id_ciudad and detalle_ord.id_detave=detalle_vehi.id_detave and orden_ser.id_soli = $busca";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    $solicitud=$resultado->fetch(PDO::FETCH_ASSOC);

    $detavehi=$solicitud['id_detave']; 

    /* Una consulta a la base de datos. */
    $sql="SELECT * from detalle_ord, detalle_vehi, solicitud, regis_veh, marcas, tipo_veh, usuarios where detalle_ord.id_detave=detalle_vehi.id_detave and detalle_ord.id_soli=solicitud.id_soli and detalle_vehi.placa=regis_veh.placa and regis_veh.id_marca=marcas.id_marca and regis_veh.id_tip_veh=tipo_veh.id_tip_veh and detalle_vehi.id_usu=usuarios.id_usu and detalle_ord.id_detave=$detavehi";
    $resultado=$base->prepare($sql);
    $resultado->execute(array());
    

   /* Creando una nueva hoja de cálculo y configurando la hoja activa como la primera hoja. */
    $excel = new Spreadsheet() ;
    $hojaActiva = $excel-> getActiveSheet();
    $hojaActiva->setTitle("Detalle de la Orden");

    // Títulos fila 1
    /* Establecer el ancho de las columnas. */
    $hojaActiva->getColumnDimension('A')->setWidth(19);
    $hojaActiva->setCellValue('A1', 'N.');
    $hojaActiva->getColumnDimension('B')->setWidth(17);
    $hojaActiva->setCellValue('B1', 'SOLICITUD'); 
    $hojaActiva->getColumnDimension('C')->setWidth(30);
    $hojaActiva->setCellValue('C1', 'CONDUCTOR');
    $hojaActiva->getColumnDimension('D')->setWidth(30);
    $hojaActiva->setCellValue('D1', 'VEHÍCULO');
    $hojaActiva->getColumnDimension('E')->setWidth(30);
    $hojaActiva->setCellValue('E1', 'CAPACIDAD');



    $row = 2; //Contenido empezará desde la fila 2

    /* Un ciclo que revisa los resultados de la consulta y los escribe en la hoja de cálculo. */
    while($reg=$resultado->fetch(PDO::FETCH_ASSOC)){

        $hojaActiva->setCellValue('A'.$row, $reg['id_detave']);
        $hojaActiva->setCellValue('B'.$row, $reg['id_soli']);
        $hojaActiva->setCellValue('C'.$row, $reg['nom_usu']);
        $hojaActiva->setCellValue('D'.$row, $reg['tip_veh']);
        $hojaActiva->setCellValue('E'.$row, $reg['capaci_pas']);
    
        $row++;
    }

    /* Aquí habrá un código donde creas $hoja de cálculo */
    // redirigir la salida al navegador del cliente
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="detalle.xlsx"');
    header('Cache-Control: max-age=0');

    /* Crear el archivo y guardarlo en la salida. */
    $writer = IOFactory::createWriter($excel, 'Xlsx');// Crea la hoja 
    $writer->save('php://output');
    exit;
?>