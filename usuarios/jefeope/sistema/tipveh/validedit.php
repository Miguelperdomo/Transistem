<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transistem</title>
</head>
<body>
<?php
require("../../../../connections/connection.php");

    

    $id=                        $_POST["idr"];
    $tip=                      $_POST["tip"];
    $capa=                      $_POST["cap"];
   

try{
$sql="UPDATE tipo_veh SET  tip_veh=:tip, capaci_pasa=:cap  WHERE id_tip_veh=:id";
$resultado=$base->prepare($sql); 
$resultado->execute(array(":id"=>$id,":tip"=>$tip, ":cap"=>$capa ));
echo '<script>alert("Haz actualizado este Tipo Vehículo");</script>';
echo '<script>window.location= "../tipvehi.php"</script>';

 



$resultado->closeCursor();
}catch(Exception $e){
	//die("Error: ". $e->GetMessage());
 	echo "Ya existe este Tipo de Vehiculo " . $id;
}finally{
	$base=null;//vaciar memoria
}


?>
</body>
</html>