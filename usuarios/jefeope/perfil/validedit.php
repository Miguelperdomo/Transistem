<?php

    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require_once("../../../connections/connection.php");

    $id = $_POST["idr"];
     
   /* Obtener los datos de la base de datos para mostrarlos en el formulario. */
    $sql="SELECT  * from usuarios  where  id_usu=:id";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$id));
    $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);
    
    $identidad = $_POST["iden"];
    $cliente = $_POST["clie"];
    $nombre = $_POST["nom"];
    $direccion = $_POST["dir"];
    $telefono = $_POST["tel"];
    $email = $_POST["email"];
    $estado = 1;
    $rol = 2;  
    

    /* Actualización de la base de datos. */
    try{
        $sql="UPDATE usuarios SET  id_rol=:rol, id_tip_clien=:tip, id_ident=:ide, nom_usu=:nom, id_est=:est, dir=:di, tel=:te, email=:ema  WHERE id_usu=:id";
        $resultado=$base->prepare($sql); 
        $resultado->execute(array(":id"=>$id,":rol"=>$rol, ":tip"=>$cliente, ":ide"=>$identidad, ":nom"=>$nombre, ":est"=>$estado, ":di"=>$direccion, ":te"=>$telefono, ":ema"=>$email));
        echo '<script>alert("Haz actualizado este Usuario");</script>';
        echo '<script>window.location= "../perfil.php"</script>';

        $resultado->closeCursor();
    }catch(Exception $e){
        //die("Error: ". $e->GetMessage());
        echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
    }finally{
        $base=null;//vaciar memoria
    }
?>
