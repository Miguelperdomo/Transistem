
<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../../includes/validarsession.php");
    require("../../../../connections/connection.php");//conexión a la BD

   /* Comprueba si el formulario está vacío y si lo está, redirige a la página de edición. */
    $id=  $_POST["idr"];
    if (empty($_POST['idr']) || empty($_POST['rol']) || empty($_POST['nom']) || empty($_POST['est']) 
        || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['email'])){       
        
        header("Location: edit.php?id=$id");
    
    }else{
        /*  Obtiene los valores del formulario y luego los obtiene de la base de datos.. */
        $id=  $_POST["idr"];
        $rol= $_POST["rol"];
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
            echo '<script>alert("Haz actualizado este Usuario");</script>';
            echo '<script>window.location= "../users.php"</script>';
    
                $resultado->closeCursor();

         /* Un bloque try catch. Se utiliza para detectar errores. */
        }catch(Exception $e){
                //die("Error: ". $e->GetMessage());
                echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
        }finally{
                $base=null;//vaciar memoria
        }

    }
   
?>
