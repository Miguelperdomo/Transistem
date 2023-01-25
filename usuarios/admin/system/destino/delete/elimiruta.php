<?php
/* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../../../includes/validarsession.php");

    require_once("../../../../../connections/connection.php");


    $id=$_GET["id"];

    $sql= "SELECT * FROM solicitud where id_ruta = :de"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":de" => $id));
    $rutas=$resultado->fetch(PDO::FETCH_ASSOC);
// Si existe ruta asociada a alguna solicitud u orden no permitirá eliminarla.
    if($rutas){
        echo '<script>alert("No se puede eliminar este elemento. Ruta asociada a solicitud.");</script>';
        echo '<script>window.location= "../rutas.php"</script>';
    }else{

        $sql="DELETE FROM rutas WHERE id_ruta=:id";
        $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
        $resultado->execute(array(":id"=>$id));//asigno las variables a los marcadores
        echo '<script>alert("Haz Eliminado este elemento.");</script>';
        echo '<script>window.location= "../rutas.php"</script>';
}

?>