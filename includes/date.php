<?php
/**
 * Devuelve la fecha actual en el formato: "dd de mes de aaaa"
 * 
 * retorna la fecha en el formato "d de M de Y"
 */
date_default_timezone_set('America/Bogota');
function fecha(){

	$mes=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return date('d') . " de " . $mes[date('n')] . " de " . date('Y');
}

?>