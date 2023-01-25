
<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../includes/validarsession.php");

    require_once("../../../connections/connection.php"); 
        
    $id=  $_POST["idr"];
     /* Comprobar si el formulario está vacío. */
    if (empty($_POST['idr']) || empty($_POST['nom']) || empty($_POST['est']) 
        || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['email'])){       
        
        header("Location: edit.php?id=$id");
    
    }else{
        $id=  $_POST["idr"];
        $rol= 5;        
        
        $nombre= $_POST["nom"];        
        $estado= $_POST["est"];
        $direccion= $_POST["dir"];
        $telefono= $_POST["tel"];
        $email= $_POST["email"];

        $sql="SELECT  * from usuarios  where  id_usu=:id";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":id"=>$id));
        $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

        $identidad= $usuarios["id_ident"];
        $clave= $usuarios["pass"];
        $cliente= $usuarios["id_tip_clien"];

        try{
                /* Actualización de la base de datos con los nuevos valores. */
            $sql="UPDATE usuarios SET  id_rol=:rol, id_tip_clien=:tip, id_ident=:ide, nom_usu=:nom, pass=:pa, id_est=:est, dir=:di, tel=:te, email=:ema WHERE id_usu=:id";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":id"=>$id,":rol"=>$rol, ":tip"=>$cliente, ":ide"=>$identidad, ":nom"=>$nombre, ":pa"=>$clave, ":est"=>$estado, ":di"=>$direccion, ":te"=>$telefono, ":ema"=>$email));
            echo '<script>alert("Haz actualizado este Cliente");</script>';
            echo '<script>window.location= "activarclient.php"</script>';

            $resultado->closeCursor();

        }catch(Exception $e){
            //die("Error: ". $e->GetMessage());
            echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
        }finally{
            $base=null;//vaciar memoria
        }
    }
?>
