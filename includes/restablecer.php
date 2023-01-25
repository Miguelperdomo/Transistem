<?php
    require_once("../connections/connection.php");
    
   /* Comprobación de si el correo electrónico existe en la base de datos y, en caso afirmativo, enviará un correo electrónico al usuario
   con un enlace para restablecer la contraseña. */
    if (isset($_POST["email"])) 
    {
        $docu=$_POST['doc'];
        $email = $_POST['email'];

        $sql= "SELECT * FROM usuarios WHERE id_usu = :doc and email = :est";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":doc"=>$docu, ":est"=>$email));
        $regi=$resultado->fetch(PDO::FETCH_ASSOC);

        if(!$regi){
            echo "<script>alert ('No es un correo válido')</script>";
            echo "<script>window.location='../recupepass.html'</script>";

        }else{
            $usu = $regi['id_usu'];
            $bytes = random_bytes(5);
            $token =bin2hex($bytes); 
            
            include "mail_reset.php";

            if($enviado){
                $sql="INSERT INTO changepass (id_usu, email, token, codigo) values (:idu, :em, :tok, :cod)";
                $resultado=$base->prepare($sql);
                $resultado->execute(array(":idu"=>$usu, ":em"=>$email, ":tok"=>$token, ":cod"=>$codigo));

                echo "<script>alert ('Verifique su email para restablecer la cuenta.')</script>";
                echo "<script>window.location='../login.php'</script>";
            }

        }
    }


?>