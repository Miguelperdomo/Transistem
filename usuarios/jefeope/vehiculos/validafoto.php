<?php
    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require("../../../connections/connection.php");

    

     /* Obtener el valor de las variable de sesión "Globales" y asignarlo a otras variable ``. */
    $doc=$_SESSION['doc'];
    $rol=$_SESSION['rol'];
    $name=$_SESSION['nameu'];

    $placa = $_POST["placa"];
     
    /* Una consulta para obtener los datos de la base de datos. */
    $sql="SELECT  * from regis_veh  where  placa=:id";
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":id"=>$placa));
    $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

   /* Comprobando si la imagen está vacía. */
    if(empty($_POST["imagen"])){

        echo '<script>alert("Escoja Foto");</script>';
        echo '<script>window.location= "foto.php?id= echo $placa"</script>';
    
    }else{
        $foto = $_POST["imagen"];
        $pla = $usuarios["placa"];

        /* Actualización de la base de datos con la nueva imagen. */
        try{
            $sql="UPDATE regis_veh SET foto=:fot  WHERE placa=:id";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":id"=>$placa, ":fot"=>$foto ));
            echo '<script>alert("Haz actualizado esta Foto");</script>';
            echo '<script>window.location= "verregistroveh.php"</script>';

            /* Cerrando el cursor. */
            $resultado->closeCursor();
        }catch(Exception $e){
            //die("Error: ". $e->GetMessage());
            echo '<div class="alert alert-danger sm" role="alert"><strong>Ocurrio un fallo.</strong></div>';
        }finally{
            $base=null;//vaciar memoria
        }
}
?>
