<?php
    session_start();
    include("../connections/connection.php"); //se conecta
    
    if($_POST["ingreso"]){

        if (empty($_POST['id']) || empty($_POST['pass']))  {
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>';
            echo '<script>window.location="../login.php"</script>'; 
        }else{

            try{
                $login=htmlentities(addslashes($_POST["id"]));
                $password=htmlentities(addslashes($_POST["pass"]));
                
                $status = 1;
                $sql="SELECT * FROM usuarios WHERE id_usu = :doc and id_est = :est";
                $resultado=$base->prepare($sql);
                $resultado->execute(array(":doc"=>$login, ":est"=>$status));//marcador login se corresponde con lo que el usuario introdujo en login
                
                if ($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                                      
                    $active = $registro['id_est'];

                    if(password_verify($password, $registro['pass'])){

            
                        $_SESSION['doc']=$registro['id_usu'];
                        $_SESSION['rol']=$registro['id_rol'];
                        $_SESSION['nameu']=$registro['nom_usu'];
                    }
                }
                if ($registro && $password && $active){   

                    if($_SESSION ['rol'] == 1){
                        header("Location: ../usuarios/admin/admin.php");
                        exit();
                        
                    }elseif ($_SESSION ['rol'] == 2){
                        header("Location: ../usuarios/jefeope/jefeope.php");
                        exit();                 
                    }elseif ($_SESSION ['rol'] == 3){
                        header("Location: ../usuarios/asesor/aseso.php");
                        exit();
                    }elseif ($_SESSION ['rol'] == 4){
                        header("Location: ../usuarios/conduc/conduc.php");
                        exit();                
                        
                    }elseif ($_SESSION ['rol'] == 5){
                        header("Location: ../usuarios/cliente/cliente.php");
                        exit();                 
                    }else{
                        header("Location: ../loginerror.php");
                        exit();
                    }
                }else{
                    echo "<script>alert ('Usuario no encontrado o Inactivo. Verifique los datos de ingreso.')</script>";
                    echo "<script>window.location='../login.php'</script>";
                }
                $resultado->closecursor();
                $base->exec("set character set utf8");

            }catch(Exception $e){
                die("error" . $e->getMessage());
        
            }
        }
    }
?>

