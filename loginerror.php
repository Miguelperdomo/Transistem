<?php
    require_once("connections/connection.php");

    if(isset($_POST['insert'])){

        if (empty($_POST['doc']) || empty($_POST['tip']) || empty($_POST['ident']) || empty($_POST['nom']) || empty($_POST['pass']) || empty($_POST['dir']) || empty($_POST['tel']) || empty($_POST['emai'])){
       
            echo '<script>alert ("Campos vacios. Por favor diligencie todos los campos.");</script>'; 
    
        }else{
            $usu=$_POST['doc'];
            $rol = 5;
            $tipo = $_POST['tip'];
            $ide = $_POST['ident'];
            $nombre = $_POST['nom'];
            $clave = $_POST['cla'];
            $pass_cifrado = password_hash($clave,PASSWORD_DEFAULT,array("cost"=>12));//encripta lo que hay en la variable clave
            $estado = 2;
            $direccion = $_POST['dir'];
            $telefono = $_POST['tel'];
            $email = $_POST['emai'];
        
            $sql= "SELECT * FROM usuarios where id_usu = :id"; 
            $resultado=$base->prepare($sql);
            $resultado->execute(array(":id"=>$usu));
            $regi=$resultado->fetch(PDO::FETCH_ASSOC);

            if($regi){
                echo "<script>alert ('Ya existe el usuario')</script>";
                echo "<script>window.location='login.php'</script>";
            }else{

                $sql="INSERT INTO usuarios (id_usu, id_rol, id_tip_clien, id_ident, nom_usu, pass, id_est, dir, tel, email) values (:id, :rol, :tip, :iden, :nom, :pas, :est, :di, :tel, :email)";
                $resultado=$base->prepare($sql);
                $resultado->execute(array(":id"=>$usu, ":rol"=>$rol, ":tip"=>$tipo, ":iden"=>$ide, ":nom"=>$nombre, ":pas"=>$pass_cifrado, ":est"=>$estado, ":di"=>$direccion, ":tel"=>$telefono, ":email"=>$email));
                
                echo "<script>alert ('Registro exitoso. Por favor espere aviso de confirmación en su correo electrónico.')</script>";
                echo "<script>window.location='login.php'</script>";
            }
        }  
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/stylelogin.css">
  <!-- <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="icon" href="img/bus.png">
</head>

<body>


<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form method="POST" id="form" autocomplete="off">
			<h2>Crear cuenta</h2>
            <div class="colum">
                <input class="radio" type="radio" name="tip" value="1"><label for="html">Persona natural</label>
            </div>
            <div class="colum">
                <input class="radio" type="radio" name="tip" value="2"><label for="html">Persona jurídica</label>
            </div>
            <select name="ident" >
                    <?php
                    $sql= "SELECT * FROM ident"; 
                    $resultado=$base->prepare($sql);
                    $resultado->execute(array());
                    while($ident=$resultado->fetch(PDO::FETCH_ASSOC)){
                    ?>
                <option value="<?php echo $ident['id_ident'];?>"><?php echo $ident['ident'];?></option>
                    <?php
                    }
                    ?> 
            </select>
            <input type="number" name="doc" id="doc" placeholder="Documento o NIT" />
            <div class="warnings" id="warnings1"></div>
			<input type="text" name="nom" placeholder="Nombre" />
            <input type="varchar" name="dir" placeholder="Dirección" />
            <input type="number" name="tel" id="tel" placeholder="Teléfono" />
            <div class="warnings" id="warnings2"></div>
			<input type="email" name="text" id="email" placeholder="Email" />
            <div class="warnings" id="warnings4"></div>
            <input type="password" name="cla" id="clave" placeholder="Clave" />
            <div class="warnings" id="warnings3"></div>
            <input  type="submit" class="btn btn-blue" name="insert" value="Solicitar">
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form method ="POST" name=formlog action="includes/inicio.php" id="segundo">
            <img src="img/puriesturlogo.png" alt="logo" width="120px">
            <br>
			<h1>Iniciar sesión</h1>
            <br>
			<input type="number" class="red" name="id" id="doc" placeholder="Documento" />
            <div class="warnings" id="warnings5"></div>
			<input type="password" class="red" id="clave" name="pass" placeholder="Clave" />
            <div class="warnings" id="warnings6"></div>            
            <br>
			<input  type="submit" class="btn btn-blue" name="ingreso" value="Ingresar" >
            <input type="hidden" name="login" value="formlog">
            
            <a href="recupepass.html">¿Olvidaste tu contraseña?</a>
            <a href="index.html"><button type="button">Volver</button></a>       
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>¿Ya tienes cuenta?</h1>
				<p>Inicie sesión aquí.</p>
				<button class="ghost" id="signIn">Iniciar sesión</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>¿No tienes cuenta?</h1>
				<p>Si no tiene cuenta ingrese aquí.</p>
				<button class="ghost" id="signUp">Registrar</button>
			</div>
		</div>
	</div>
</div>
<script src="js/loginvalida.js" charset="utf-8"></script>
<script src="js/valiiniciar.js"></script>
<script src="js/loginmovi.js" charset="utf-8"></script>
</body>

</html>