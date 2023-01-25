<?php

require_once("../../connections/connection.php");

/* Comprobando si el formulario está vacío. */
    if (empty($_POST['documento'])) {
        echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>';
        echo '<script>window.location="buscarsoli.php"</script>'; 
    }
    
  /* Comprobando si el formulario está vacío. */
    if($_POST['documento']){

        $docu=$_POST['documento'];
        
        $veri=$docu;

        if(!$veri){
                            
            header("Location:listo.php?id=$veri"); 
            
        }else{
            header("Location:listo.php?id=$veri"); 
        }
    }

?>



    
        
    
        
    