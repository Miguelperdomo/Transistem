<?php

    require_once("../connections/connection.php");

    $email =$_POST['email'];
    $token =$_POST['token'];
    $codigo =$_POST['codigo'];

    /* Selecting the code from the database and comparing it with the code that the user has entered. */
    $sql= "SELECT * FROM changepass where codigo = :tok"; 
    $resultado=$base->prepare($sql);
    $resultado->execute(array(":tok"=>$codigo));
    $regi=$resultado->fetch(PDO::FETCH_ASSOC);
    
    $correcto=$regi['codigo'];
    
    if($correcto){
        //formato unix
        $fecha = strtotime($regi['fecha']);
        // $fecha_actual = date("Y-m-d h:m:s");
        $fecha_actual = time();
    
        $time = $fecha_actual - $fecha;
       /**
        * It takes a number of seconds and returns the number of minutes
        * 
        * @param tiempo_en_segundos The time in seconds that you want to convert.
        * 
        * @return the minutes.
        */
        function conversor($tiempo_en_segundos) {
            $horas = floor($tiempo_en_segundos / 3600);
            $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
        
            return $minutos;
        }
    
        if(conversor($time) > 10)
        {
            echo '<script>alert ("Código vencido. Genere un nuevo código.");</script>';
            echo '<script>window.close();</script>';
        }
        else
        {
            echo '<div class="alert alert-success sm" role="alert"><strong>Código Válido.</strong></div>'; 
            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Cambiar password </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <section id="bannerolvidopass">
        <div class="container col-5">
            <div class="boxformpass"> 
                <div class="container col-5">
                    <img src="../img/puriesturlogo.png" alt="referen">              
                </div>
                <br>
                <form form method ="POST" name = "formreg" id="form" autocomplete = "off" action ="cambiar.php">
                    <h4 class="text-center">Restablecer contraseña</h4><br>
                    <div class="mb-3">
                        <label for="c" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="nueva" name = "nueva">
                        <div class="warnings" id="warnings1"></div>
                    </div><br>
                    <div class="mb-3">
                        <label for="c" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="nuevarepe" name = "nuevarepe">
                        <div class="warnings" id="warnings2"></div>
                    </div><br>
                    <input type="hidden" class="form-control" id="c" name="email" value="<?php echo $email;?>">
                    <input type="hidden" class="form-control" id="c" name="token" value="<?php echo $token;?>">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Cambiar</button>
                        <a href="../index.html"><button type="button" class="btn btn-secondary">Volver</button></a>
                    </div>                                                 
                </form>                                      
            </div>
        </div>                               
    </section>
    <script src="../js/validapass.js" charset="utf-8"></script>         
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
<?php 
                            
        }
    }else{
        echo "<script>alert ('Código invalido.')</script>";
        echo "<script>window.close();</script>";
    } 
?>