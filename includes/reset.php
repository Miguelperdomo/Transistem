<?php 
require_once("../connections/connection.php");

/*Comprobando si el email y el token están configurados, si no redirige a login.php*/
if( isset($_GET['email'])  && isset($_GET['token']) ){
    $email=$_GET['email'];
    $token=$_GET['token'];
}else{
    header("Location: ./login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <title>Recuperar Contraseña</title>
</head>
<body>
    <section id="bannerolvidopass">        
        <div class="container col-5">
            <div class="boxformpass"> 
                <div class="container col-5">
                    <img src="../img/puriesturlogo.png" alt="referen">              
                </div>
                <br>
                <!-- /* Este es el formulario que el usuario rellenará para restablecer la contraseña. */ -->
                <form form method ="POST" name = "formreg" autocomplete = "off" action ="verificartoken.php">
                    <h4 class="text-center">Restablecer contraseña</h4> <br><br>
                    <p class="text-center">Introduzca el código de confirmación:</p><br><br>
                    <input type="number" class="form-control" id="c" class="form-control text-center" name="codigo" placeholder = "Código"><br><br>
                    
                    <input type="hidden" class="form-control" id="c" name="email" value="<?php echo $email;?>">
                    <input type="hidden" class="form-control" id="c" name="token" value="<?php echo $token;?>">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Restablecer</button>
                    </div>                                                 
                </form>                                      
            </div>
        </div>                               
    </section>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Paquete JavaScript con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>