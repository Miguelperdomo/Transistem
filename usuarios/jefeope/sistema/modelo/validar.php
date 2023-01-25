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

    $id=$_POST["id"];
    $mode=$_POST["mode"];

    try{  
        $sql="UPDATE modelo SET modelo=:mo  WHERE id_modelo=:id";
        $resultado=$base->prepare($sql); 
        $resultado->execute(array(":id"=>$id,":mo"=>$mode ));
        
        echo '<script>alert("Haz actualizado este Modelo");</script>';
        echo '<script>window.location= "../modelo.php"</script>';

        $resultado->closeCursor();

    }catch(Exception $e){
        //die("Error: ". $e->GetMessage());
        echo "No se actualizó correctamente este modelo".$id;
    }finally{
        $base=null;//vaciar memoria
    }
?>
</body>
</html>