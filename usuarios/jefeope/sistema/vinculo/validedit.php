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

        $id= $_POST["idr"];
        $vinculo=$_POST["vin"];
    try{
        $sql="UPDATE vinculo SET  vinculo=:vin  WHERE id_tip_vincu=:id";
        $resultado=$base->prepare($sql); 
        $resultado->execute(array(":id"=>$id,":vin"=>$vinculo ));
        echo '<script>alert("Haz actualizado este Vínculo");</script>';
        echo '<script>window.location= "../vinculo.php"</script>';

            $resultado->closeCursor();
    }catch(Exception $e){
            //die("Error: ". $e->GetMessage());
        echo "Ya existe este Vínculo " . $id;
    }finally{
        $base=null;//vaciar memoria
    }
?>
</body>
</html>