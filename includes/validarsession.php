<?php

/* Comprueba si las variables de sesión están establecidas. Si no lo están, redirige a la página index.html.. */
if(!isset($_SESSION['doc']) || !isset ($_SESSION ['rol']))
{
    header('Location: ../index.html');
    exit();
}

?>  