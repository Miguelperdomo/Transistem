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
    $mar=$_POST["mar"];

    try{  
        $sql="UPDATE estado_asig SET estvehi=:ma  WHERE id_estvehi=:id";
        $resultado=$base->prepare($sql); 
        $resultado->execute(array(":id"=>$id,":ma"=>$mar ));
        echo '<script>alert("Haz actualizado este elemento");</script>';
        echo '<script>window.location= "../estadoveh.php"</script>';

        $resultado->closeCursor();

    }catch(Exception $e){
        //die("Error: ". $e->GetMessage());
        echo "No se actualizó correctamente";
    }finally{
        $base=null;//vaciar memoria
    }
?>
</body>
</html>