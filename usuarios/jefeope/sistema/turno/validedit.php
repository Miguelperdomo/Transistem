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
    $turno=                      $_POST["turn"];
   

try{
$sql="UPDATE turnos SET  turno=:tur  WHERE id_turno=:id";
$resultado=$base->prepare($sql); 
$resultado->execute(array(":id"=>$id,":tur"=>$turno ));
echo '<script>alert("Haz actualizado este Turno");</script>';
echo '<script>window.location= "../../turno.php"</script>';

 



$resultado->closeCursor();
}catch(Exception $e){
	//die("Error: ". $e->GetMessage());
 	echo "Ya existe este Turno " . $id;
}finally{
	$base=null;//vaciar memoria
}


?>
</body>
</html>