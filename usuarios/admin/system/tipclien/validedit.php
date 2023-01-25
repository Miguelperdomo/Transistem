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
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../../includes/validarsession.php");
    require("../../../../connections/connection.php");//conexión a la BD

    $id=  $_POST["idr"];
    $tip= $_POST["tip"];
   

try{
    $sql="UPDATE tipo_cliente SET  tip_clien=:tip WHERE id_tip_clien=:id";
    $resultado=$base->prepare($sql); 
    $resultado->execute(array(":id"=>$id,":tip"=>$tip ));
    echo '<script>alert("Haz actualizado este Tipo Cliente");</script>';
    echo '<script>window.location= "../tipcli.php"</script>';

    $resultado->closeCursor();
    
}catch(Exception $e){
	//die("Error: ". $e->GetMessage());
 	echo "Ya existe este Tipo de Cliente" . $id;
}finally{
	$base=null;//vaciar memoria
}


?>
</body>
</html>