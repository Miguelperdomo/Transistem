<?php

    session_start();
    require("../../../connections/connection.php");

    include("../../../includes/validarsession.php");

    /*Variables globales */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];
    
   /* Comprobando si la imagen está vacía. Si está vacío, alertará al usuario para que elija una imagen. Si se
   no está vacío, asignará la imagen a la variable. */
    if(empty($_POST["imagen"])){

        echo '<script>alert("Escoja Foto");</script>';
        echo '<script>window.location= "foto.php"</script>';
    
    }else{
        
        $foto=$_POST["imagen"];
        
     /* Actualización de la imagen en la base de datos. */
        try{
            $sql="UPDATE usuarios SET foto=:fot  WHERE id_usu=:id";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":id"=>$doc, ":fot"=>$foto ));
            echo '<script>alert("Haz actualizado esta Foto");</script>';
            echo '<script>window.location= "../perfil.php"</script>';

            $resultado->closeCursor();
        }catch(Exception $e){
           //muere("Error: ". $e->GetMessage());
            echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
        }finally{
            /* Cerrando la conexión a la base de datos. */
            $base=null;
        }
    }
?>
