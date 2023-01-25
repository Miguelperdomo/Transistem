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

    $id=$_POST["id"];
    $mode=$_POST["mode"];

    try{  
        /* Actualización de la tabla con los valores de las variables. */
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