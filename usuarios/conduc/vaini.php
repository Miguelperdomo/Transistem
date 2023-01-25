<?php
 session_start();
 include("../../includes/validarsession.php");
 include("date.php");
 require_once("../../connections/connection.php");


$ord=$_POST['id_auto'];
/* Comprobando si se ha pulsado el botón "programar".*/
if(isset($_POST['programar'])){
       
     $fecha= date("Y-m-d H:i:s"); 

     $sql="UPDATE  orden_ser SET fecha_ini_real=:fec WHERE id_auto=:id";
     $resultado=$base->prepare($sql);  //$base guarda la conexión a la base de datos
     $resultado->execute(array(":id"=>$ord, ":fec"=>$fecha));//asigno las variables a los marcadores
     echo '<script>alert("Ha iniciado el viaje.");</script>';//Imprime un mensaje de que el viaje a iniciado
     echo '<script>window.location= "verprogra.php"</script>';//Regresa a verprograma despues de escuchar el boton
     }


?>