
<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require("../../../connections/connection.php");

    $id=  $_POST["idr"];
    /* Comprobando si alguno de los campos está vacío. */
    if (empty($_POST['idr']) || empty($_POST['nom']) || empty($_POST['est']) 
        || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['email']) || empty($_POST['turno']) || empty($_POST['vigencia'])){       
        
        header("Location: editar.php?id=$id");
    
    }else{
        $id=  $_POST["idr"];
        $nombre= $_POST["nom"];        
        $estado= $_POST["est"];
        $direccion= $_POST["dir"];
        $telefono= $_POST["tel"];
        $email= $_POST["email"];
        $turno= $_POST["turno"];
        $vigencia= $_POST["vigencia"];
    
        /* Una consulta que se utiliza para seleccionar los datos de la tabla usuarios. */
        $sql="SELECT  * from usuarios  where  id_usu=:id";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":id"=>$id));
        $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);
    
        $identidad= $usuarios["id_ident"];
        $clave= $usuarios["pass"];
        $cliente= $usuarios["id_tip_clien"];
        $rol= $usuarios["id_rol"];
    
        /* Actualización de la tabla `usuarios` con los valores de las variables. */
        try{
            $sql="UPDATE usuarios SET  id_rol=:rol, id_tip_clien=:tip, id_ident=:ide, nom_usu=:nom, pass=:pa, id_est=:est, dir=:di, tel=:te, email=:ema WHERE id_usu=:id";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":id"=>$id,":rol"=>$rol, ":tip"=>$cliente, ":ide"=>$identidad, ":nom"=>$nombre, ":pa"=>$clave, ":est"=>$estado, ":di"=>$direccion, ":te"=>$telefono, ":ema"=>$email));

            /* Actualización de la tabla `detalle_condu` con los valores de las variables. */
            $sql1="UPDATE detalle_condu SET id_usu=:id, id_turno=:tur, vige_lice=:vige";
            $resultado=$base->prepare($sql1); 
            $resultado->execute(array(":id"=>$id,":tur"=>$turno, ":vige"=>$vigencia));

            echo '<script>alert("Haz actualizado este Conductor");</script>';
            echo '<script>window.location= "verconduct.php"</script>';
    
                $resultado->closeCursor();
        }/* Captura de una excepción. */
        catch(Exception $e){
                //die("Error: ". $e->GetMessage());
                echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
        }finally{
                $base=null;//vaciar memoria
        }

    }
    
   
?>
