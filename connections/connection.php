<?php
/* Script PHP que se conecta a una base de datos. */
$username = "root";
$password = "";
$database = "transistemxxx";
try
{
    // Ejecutamos las variables y aplicamos UTF8
    $base = new PDO('mysql:host=localhost;dbname='.$database, $username, $password);
    $base->query("set names utf8;");
    $base->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);//
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// permite manejar los errores y a la vez esconder datos que podrían ayudar a alguien a atacar la aplicación.
    $base->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch (Exception $e)
{
    echo "Error: Algo va mal con la Base de datos. " . $e->getMessage();
}
?>