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
        <div class="col-12">
            <form method="post" id="encuesta">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <h2>En una escala de 1 a 10: ¿Qué le pareció el proceso de selección de RateInc?</h2>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_1" class="custom-label">1</label><input id="question_1_1" type="radio" name="question_1" value="1"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_2" class="custom-label">2</label><input id="question_1_2" type="radio" name="question_1" value="2"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_3" class="custom-label">3</label><input id="question_1_3" type="radio" name="question_1" value="3"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_4" class="custom-label">4</label><input id="question_1_4" type="radio" name="question_1" value="4"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_5" class="custom-label">5</label><input checked id="question_1_5" type="radio" name="question_1" value="5"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_6" class="custom-label">6</label><input id="question_1_6" type="radio" name="question_1" value="6"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_7" class="custom-label">7</label><input id="question_1_7" type="radio" name="question_1" value="7"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_8" class="custom-label">8</label><input id="question_1_8" type="radio" name="question_1" value="8"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_9" class="custom-label">9</label><input id="question_1_9" type="radio" name="question_1" value="9"></div>
                        <div class="col-6 col-md-4 col-xl-2"><label for="question_1_10" class="custom-label">10</label><input id="question_1_10" type="radio" name="question_1" value="10"></div>
                    </div>
                </div>
                <div class="form-group" id="section-2">
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <h2 id="section-2-title">Descriptive Text</h2>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 text-center">
                            <textarea name="comentary" id="section-2-comentary" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row text-center">
                    <input type="submit" id="btnLogin" value="Enviar" class="btn btn-success">
                </div>
            </form>
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

        //localStorage.menuDash = 0;
        //localStorage.menuComNCot = 0;
        //localStorage.menuComCot = 0;
        //localStorage.menuComEP = 0;
        //localStorage.menuComServ = 0;
        //localStorage.menuComEmp = 0;
        //localStorage.menuAdmSed = 0;
        //localStorage.menuAdmUsu = 0;

        $("#encuesta").validate({
            rules: {
                question_1: {
                    required: true
                },
                comentary: {
                    required: true
                }
            },
            messages: {
                question_1: {
                    required: "Debe seleccionar una escala"
                },
                comentary: {
                    required: "Debe escribir su comentario",
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
                    url: "controller/usuario.php",
                    type: "POST",
                    data: {
                        acc: 9,
                        question_1: question_1,
                        comentary: comentary
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

    });

    /*function cerrarSesion() {
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
    }*/
</script>

</body>
</html>