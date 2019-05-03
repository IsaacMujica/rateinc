<?php include_once "config/app.php"; ?>
<!doctype html>
<html lang="es">
<head>
    <title>Recuperar Clave - CETI Intranet</title>
    <?php require_once "shared/meta.php"; ?>
</head>
<body class="bg-login-section">
<div class="container">
    <div class="row mt-5">
        <div class="col-xs col-md-4 offset-md-4">
            <div class="text-center" style="margin-bottom: 40px;">
                <img src="public/images/logo-ceti-color.png" class="img-responsive"
                     style="display: inline-block; max-width: 280px;" alt="Logo">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form id="formLogin" method="post">
                <div class="form-group">
                    <div>
                        <p class="text-center loginTxtBienvenido">BIENVENIDO</p>
                        <p class="text-center loginTxtIngrese">Ingrese su credenciales para acceder al
                            sistema</p>
                    </div>
                </div>
                <div class="form-group text-white">
                    <label for="txtUsuario">Usuario:</label>
                    <input type="text" class="form-control" id="txtUsuario"
                           name="txtUsuario">
                </div>
                <!-- <div class="form-group text-white">
                    <label for="txtPassword">Contraseña:</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                </div> -->
                <br>
                <div class="form-group text-center">
                    <input type="submit" id="btnLogin" value="RECUPERAR" class="btn btn-success">
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <a href="index_desarrollo.php" class="btn-link">Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <footer>
        <div class="text-center text-secondary"><p class="no-margin">OTEC Online - Gestión web para Organismos Técnicos de Capacitación</p>
            <p class="no-margin"> © 2018 CETI.CL Todos los derechos reservados. </p>
        </div>
    </footer>

</div>

<?php require_once "shared/js.php"; ?>

<script>
    $(document).ready(function () {
        $("#formLogin").validate({
            rules: {
                txtUsuario: {
                    required: true,
                    email: true
                }
            },
            messages: {
                txtUsuario: {
                    required: "Debe ingresar su usuario (e-mail)",
                    email: "Debe ingresar un correo válido"
                }
            },
            errorElement: 'span',
            errorClass: 'is-invalid invalid-feedback',
            highlight: function (element) {
                $(element).addClass('has_error is-invalid');
            },
            submitHandler: function (form) {
                $('#btnLogin').prop('disabled', true);

                var usuario = $("#txtUsuario").val();
                var password = $("#txtPassword").val();

                $.ajax({
                    url: "controller/login_desarrollo.php",
                    type: "POST",
                    data: {
                        acc: 4,
                        txtEmail: usuario
                    },
                    error: function (e) {
                        $('#btnLogin').prop('disabled', false);
                        alert("En desarrollo... " + e.responseText);
                    },
                    beforeSend: function () {
                        //$("#btnGuardar").prop("disabled", true);
                    },
                    success: function (data) {
                        $('#btnLogin').prop('disabled', false);
                        eval(data);
                        console.info(data);
                        if (r.resultado == "OK") {
                            alertOk(r.titulo, r.mensaje);
                            /*setTimeout(function () {
                                location.href = r.irURL;
                            }, 4000);*/
                        } else {
                            alertFail(r.titulo, r.mensaje);
                        }
                    }
                });
            }
        });
    });

    function cerrarSesion() {
        $.ajax({
            url: "login_ajax.php",
            type: "POST",
            data: {
                acc: 2
            },
            error: function (e) {
                alert("error " + e.responseText);
            },
            beforeSend: function () {
                //$("#btnGuardar").prop("disabled", true);
            },
            success: function (data) {
                $.globalEval(data);
                if (r.resultado == "OK") {
                    Messenger().post({message: r.mensaje, type: "info"});
                    setTimeout(function () {
                        location.href = r.irURL;
                    }, 1000);
                }
            }
        });
    }
</script>

</body>
</html>