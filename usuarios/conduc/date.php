
<?php
//Devuelve la fecha y hora actual en el siguiente formato: AAAAMMDDHH:MM:SS.
date_default_timezone_set('America/Bogota');
function fecha(){

	$mes=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return date('Y') . "" . $mes[date('n')] . "" . date('d') . "" . date('H:i:s');

}

?>