<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="../../libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashuser.css">
    <link rel="stylesheet" href="../../css/stylecusto.css">
    <link rel="icon" href="../../img/bus.png">
</head>
<body>
    <!--Barra cabecera-->
    <div class="container-fluid">
        <div class="row justify-content-center align-content-center">
            <div class="col-8 barra">
                <h4 class="text-light"><img src="../../img/logo_blanco.png" alt="logo" width="200px"></h4>
            </div>
            <div class="col-4 text-right barra">
                
                <ul class="navbar-nav mr-auto">
            </div>
        </div>
    </div>
        <!--Contenido principal-->
    <main class="main col">
        <div class="row justify-content-center align-content-center text-center">
            <div class="col-sm-12" id="title">
                <img src="../../img/puriesturlogo.png" class="img-fluid" alt="logo" width="180px"><br><br>
                <h3 class="mb-0">Consultar Estado de Solicitud</h3><br>
            </div>
        </div>
        <!--Un contenedor que se utiliza para contener el formulario que el usuario llenará para consultar el
       estado de la solicitud. */
       /* El formulario que llenará el usuario para consultar el estado de la solicitud. */-->
        <div class="container col-6">
            <div class="modal-body">
                <form method="POST" action="validar.php" id="form">
                    <div class="col-auto">
                        <center>
                        <p>Ingresa el Número de Documento.</p>
                        </center> 
                        <div class="input-group col">
                            <div class="input-group-prepend">
                                <div class="input-group-text">N. Documento</div>
                            </div>
                            <input type="number" class="form-control bus" name="documento" id="doc">
                        </div>
                        <div class="warnings" id="warnings1"></div>
                        <center><small>El documento debe tener mas 7 números</small></center>
                    </div>
                    <br>
                     <!--Un botón que redirige a la página index.html.-->
                    <div class="modal-footer">
                        <a href="../../index.html"><button type="button" class="btn btn-secondary">Volver</button></a>
                        <input type="submit" class="btn btn-gold" name="insert" id="insert" value="Consultar">
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!--A script that is used to make the page more interactive.-->
    <!-- <script src="loginvalida.js"></script>  -->
    <script src="docu.js"></script> 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <!-- <script src="https://kit.fontawesome.com/aa5df8ccf1.js" crossorigin="anonymous"></script> -->
</body>

</html>