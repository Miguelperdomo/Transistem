<?php
    require_once("../connections/connection.php"); //requiere que se conecte a...
    session_start();    

    /* Un script PHP que se ejecuta cuando el usuario hace clic en el botón "Cambiar contraseña". */
    $email =$_POST['email'];
    $p1 =$_POST['nueva'];
    $p2 =$_POST['nuevarepe'];

    $pass_cifrado=password_hash($p1,PASSWORD_DEFAULT,array("cost"=>12));

    /* Comprobación de si la nueva contraseña es la misma que la contraseña repetida. Si lo es, actualizará la
    contraseña en la base de datos. */
    if($p1 == $p2){
        $sql= "UPDATE usuarios SET pass = :pas WHERE email =:em";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":pas"=>$pass_cifrado, ":em" => $email));
        
        echo '<script>alert ("Cambio exitoso. Ingrese nuevamente.");</script>';
        echo '<script>window.location= "../login.php" </script>';
    }
    else
    {  
        echo '<script>alert ("Las contraseñas no coinciden.");</script>';
        echo '<script>window.close();</script>'; 
    }
    
?>

