<?php 
    session_start();
    include("../../../../../includes/validarsession.php");

    require_once("../../../../../connections/connection.php");
     
    $depa=$_POST['de'];

/*****************************************  CONSULTA DE LOS DATOS ***************************************/
    $sql= "SELECT * FROM departa, ciudad WHERE ciudad.id_depart = departa.id_depart AND ciudad.id_depart = $depa"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array());

	$cadena="<div class='form-group'>
                <div class='input-group col'>
                    <div class='input-group-prepend'>
                        <div class='input-group-text'>Ciudad</div>
                    </div>
                    <select class='custom-select' required name='ci' id='ci'>";

    while($regi=$resultado->fetch(PDO::FETCH_ASSOC)) {
		$cadena=$cadena.'<option value='.$regi[1].'>'.utf8_encode($regi[6]).'</option>';
	}

	echo  $cadena."</select>
                </div>  
            </div>";
	

?>