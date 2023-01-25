<?php

require_once("../../connections/connection.php");

  /* Comprobando si el campo de entrada está vacío. Si está vacío, mostrará una alerta y redirigirá al
   misma página. */
    if (empty($_POST['doc'])) {
        echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>';
        echo '<script>window.location="buscarsoli.php"</script>'; 

    /* Comprobando si el usuario existe en la base de datos. */
    }else{
        $docu=$_POST['doc'];

        $sql="SELECT * from usuarios where id_usu = $docu";
        $resultado=$base->prepare($sql);
        $resultado->execute(array());
        $usuarios=$resultado->fetch(PDO::FETCH_ASSOC);

        $veri=$usuarios['id_usu'];

      /* Redireccionando a la pagina soliciexter.php si el usuario existe en la base de datos, y a la pagina
       clieexterno.php si el usuario no existe en la base de datos. */
        if($veri){
            header("Location:soliciexter.php?id=$docu"); 
        }else{
            header("Location:clieexterno.php?id=$docu");
        }
    }

?>

    
        
    
        
    