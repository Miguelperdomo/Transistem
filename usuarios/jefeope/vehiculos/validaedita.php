
<?php

    /* Traemos las conexiones con la base de datos y la session star para la validacion de que se loguie y traiga las variables globales */
    session_start();
    include("../../../includes/validarsession.php");
    require("../../../connections/connection.php");

    $placa=  $_POST["placa"];
    /* Comprobando si alguno de los campos está vacío. */
    if (empty($_POST['fecha']) || empty($_POST['chasis']) || empty($_POST['motor']) || empty($_POST['interno']) || empty($_POST['tarjeta']) || empty($_POST['soat']) || empty($_POST['tecno'])){       
        
        header("Location: editar.php?id=$placa");
    
    }else{    
        $fecha= $_POST["fecha"];
        $chasis= $_POST["chasis"];
        $motor= $_POST["motor"];
        $interno= $_POST["interno"];
        $tarjeta= $_POST["tarjeta"];
        $soat= $_POST["soat"];
        $tecno= $_POST["tecno"];
    
        /* Obteniendo los datos de la base de datos. */
        $sql="SELECT  * from regis_veh  where  placa=:pla";
        $resultado=$base->prepare($sql);
        $resultado->execute(array(":pla"=>$placa));
        $regisveh=$resultado->fetch(PDO::FETCH_ASSOC);
        
        /* Asignar los valores de la matriz a las variables. */
        $placa= $regisveh["placa"];
        $tpveh= $regisveh["id_tip_veh"];
        $marca= $regisveh["id_marca"];
        $modelo= $regisveh["id_modelo"];
        $estado= $regisveh["id_est"];
        $vinculo= $regisveh["id_tip_vincu"];
        $carroceria= $regisveh["id_carroce"];

        try{
           /*Actualización de la base de datos con los nuevos valores. */
            $sql="UPDATE regis_veh  SET  id_tip_vincu=:vincu, fech_vincu=:fech, id_tip_veh=:ivh, id_marca=:mar, id_modelo=:mode, id_carroce=:carr, chasis=:cha, motor=:mot, n_inter=:inter, id_est=:est, vige_to=:vig, vige_soat=:soat, vige_tecno=:tec  WHERE placa=:pla";
            $resultado=$base->prepare($sql); 
            $resultado->execute(array(":pla"=>$placa,":vincu"=>$vinculo, ":fech"=>$fecha, ":ivh"=>$tpveh, ":mar"=>$marca, ":mode"=>$modelo, ":carr"=>$carroceria, ":cha"=>$chasis, ":mot"=>$motor, ":inter"=>$interno, ":est"=>$estado, ":vig"=>$tarjeta, ":soat"=>$soat, ":tec"=>$tecno ));

            echo '<script>alert("Haz actualizado este Vehiculo");</script>';
            echo '<script>window.location= "verregistroveh.php"</script>';
    
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
