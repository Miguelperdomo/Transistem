<?php
session_start();
include("../../../../../includes/validarsession.php");

require_once("../../../../../connections/connection.php");


$id=$_GET["id"];

$sql= "SELECT * FROM rutas where id_origen = :ori"; 
$resultado=$base->prepare($sql);
$resultado->execute(array(":ori" => $id));
$rutas=$resultado->fetch(PDO::FETCH_ASSOC);

if($rutas){
    echo '<script>alert("No se puede eliminar este elemento. Ruta asociada.");</script>';
    echo '<script>window.location= "../creaorigen.php"</script>';
}
else{
    $sql="DELETE FROM origen WHERE id_origen=:id";
    $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
    $resultado->execute(array(":id"=>$id));//asigno las variables a los marcadores
    echo '<script>alert("Haz Eliminado este elemento.");</script>';
    echo '<script>window.location= "../creaorigen.php"</script>';
}
?>