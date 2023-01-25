<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales*/
    session_start();
    include("../../../includes/validarsession.php");
    require("../../../connections/connection.php");

    /*Variables globales */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];
    
     /* Comprobar si la imagen está vacía. */
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
               
           /* Atrapar una excepción y mostrar un mensaje de error.. */
            }catch(Exception $e){
                die('<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>');
                //echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
            }finally{
                /* Closing the connection to the database. */
                $base=null;
            }
    }
?>
