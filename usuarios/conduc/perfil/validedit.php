<?php
   /* Incluyendo el archivo `connection.php` que se encuentra en la carpeta `connections` */
    require("../../../connections/connection.php");

   /* Obtener el valor del campo de entrada oculto con el nombre de idr. */
    $id = $_POST["idr"];
     
   /*Obtener los datos de la base de datos para mostrarlos en el formulario. */
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
    $rol = 1;  
    

    /* El código que se ejecuta cuando se envía el formulario. */
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
