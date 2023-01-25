<?php
     /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require("../../../connections/connection.php");

       /* Obtener el valor de las variable de sesión "Globales" y asignarlo a otras variable ``. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu']; 

     
    /* Obtener la información del usuario de la base de datos. */
    $sql="SELECT  * from usuarios  where  id_usu=:id";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$doc));
    $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

    
    /*Comprobando si la imagen está vacía. */
    if(empty($_POST["imagen"])){

        echo '<script>alert("Escoja Foto");</script>';
        echo '<script>window.location= "foto.php"</script>';
    
    /* Updating the database. */
    }else{
    
        $foto = $_POST["imagen"];
           

        /* Actualización de la base de datos con la nueva imagen. */
        try{
            $sql="UPDATE usuarios SET foto=:fot  WHERE id_usu=:id";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":id"=>$doc, ":fot"=>$foto ));
            echo '<script>alert("Haz actualizado esta Foto");</script>';
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
