<?php
 /* Comprobando si el formulario está vacío. */
    require("../../../connections/connection.php");

    $id = $_POST["idr"];

    if (empty($_POST['idr']) || empty($_POST['nom']) 
        || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['email'])){       
        
        header("Location: edit.php?id=$id");
 
    /* El código que se ejecuta cuando el formulario no está vacío. */
    }else{
        
        $nombre = $_POST["nom"];
        $direccion = $_POST["dir"];
        $telefono = $_POST["tel"];
        $email = $_POST["email"];
        $estado = 1;

        $sql="SELECT  * from usuarios  where  id_usu=:id";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":id"=>$id));
        $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);
         
        $rol = $usuarios['id_rol']; 
        $identidad = $usuarios["id_ident"];
        $cliente = $usuarios["id_tip_clien"];
        
     /* Actualización de la información del usuario. */
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
    }
?>
