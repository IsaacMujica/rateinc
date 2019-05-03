<?php include_once "config/app.php"; ?>
<!doctype html>
<html lang="es">
<head>
    <title>RateInc</title>
    <?php require_once "shared/meta.php"; ?>
</head>
<body class="bg-login-section">
<div class="container">
    <div class="row mt-5">
        <div class="col-xs col-md-4 offset-md-4">
            <div class="text-center" style="margin-bottom: 40px;">
                <img src="public/images/logo-rateinc.png" class="img-responsive"
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
                <div class="form-group">
                    <label for="txtUsuario">Usuario:</label>
                    <input type="text" class="form-control" id="txtUsuario"
                           name="txtUsuario">
                </div>
                <div class="form-group">
                    <label for="txtPassword">Contraseña:</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword"></div>
                <br>
                <div class="form-group text-center">
                    <input type="submit" id="btnLogin" value="INGRESAR" class="btn btn-success">
                </div>
                <!-- <div class="form-group">
                    <div class="text-center">
                        <a href="#" class="btn-link" data-toggle="modal" data-target="#modalRecuperaClave">Recuperar contraseña</a>
                    </div>
                </div> -->
            </form>
        </div>
    </div>
    <br>

    <div class="modal fade" id="modalRecuperaClave" tabindex="-1" role="dialog" aria-labelledby="modalRecuperaClaveLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalRecuperaClaveLabel">Recuperación de Contraseña</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formRecuperaClave" autocomplete="off" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="txtEmail">E-mail</label>
                                <input type="email" id="txtEmail" name="txtEmail" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-info btn-sm" id="btnGuardar">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="text-center text-secondary">
            <p class="no-margin"> © 2019 rateinc_test Todos los derechos reservados.</p>
        </div>
    </footer>

</div>

<?php require_once "shared/js.php"; ?>

<script>
    $(document).ready(function () {

        localStorage.menuDash = 0;
        localStorage.menuComNCot = 0;
        localStorage.menuComCot = 0;
        localStorage.menuComEP = 0;
        localStorage.menuComServ = 0;
        localStorage.menuComEmp = 0;
        localStorage.menuAdmSed = 0;
        localStorage.menuAdmUsu = 0;


        $("#formLogin").validate({
            rules: {
                txtUsuario: {
                    required: true
                },
                txtPassword: {
                    required: true
                }
            },
            messages: {
                txtUsuario: {
                    required: "Debe ingresar su usuario (e-mail)"
                },
                txtPassword: {
                    required: "Debe ingresar su contraseña",
                }
            },
            errorElement: 'span',
            errorClass: 'is-invalid invalid-feedback',
            highlight: function (element) {
                $(element).addClass('has_error is-invalid');
            },
            submitHandler: function (form) {

                var usuario = $("#txtUsuario").val();
                var password = $("#txtPassword").val();

                $.ajax({
                    url: "controller/login.php",
                    type: "POST",
                    data: {
                        acc: 1,
                        txtEmail: usuario,
                        txtPasswd: password
                    },
                    error: function (e) {
                        alert("En desarrollo... " + e.responseText);
                    },
                    beforeSend: function () {
                        //$("#btnGuardar").prop("disabled", true);
                    },
                    success: function (data) {
                        $.globalEval(data);
                        if (r.resultado == "OK") {
                            alertOk("Acceso Correcto", r.mensaje);
                            setTimeout(function () {
                                location.href = r.irURL;
                            }, 1500);
                        } else {
                            alertFail("Datos Incorrectos", r.mensaje);
                        }
                    }
                });
            }
        });

        $("#formRecuperaClave").validate({
            rules: {
                txtEmail: {
                    required: true,
                    email: true
                }
            },
            messages: {
                txtEmail: {
                    required: "Debe ingresar un e-mail válido.",
                    email: "Debe ingresar un e-mail válido."
                }
            },
            errorElement: 'span',
            errorClass: 'is-invalid invalid-feedback',
            highlight: function (element) {
                $(element).addClass('has_error is-invalid');
            },
            submitHandler: function (form) {

                var txtEmail = $("#txtEmail").val();

                $.ajax({
                    url: "controller/login.php",
                    type: "POST",
                    data: {
                        acc: 4,
                        txtEmail: txtEmail
                    },
                    error: function (e) {
                        alert("En desarrollo... " + e.responseText);
                    },
                    beforeSend: function () {
                        //$("#btnGuardar").prop("disabled", true);
                    },
                    success: function (data) {
                        $.globalEval(data);
                        if (response.respuesta == "OK") {
                            alertOk("Correcto", response.mensaje, function () {
                                $('#modalRecuperaClave').modal('hide');
                            });
                        } else {
                            alertFail("Error", response.mensaje);
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