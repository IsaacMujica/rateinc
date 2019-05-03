<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";
require_once "../../app/Sede.php";

$empresa = new Empresa();
$sedes = new Sede();

$id = intval($_GET['id']);
$idC = intval($_GET['idC']);
$idU = intval($_GET['idU']);

$arr = array("idC" => $idC, "idE" => $id);

$dataContacto = "";//$empresa->getInfoEmpresaContacto();
$dataEmpresaContacto = $empresa->getListaContacto($arr);

$sedeusuario = $sedes->getListaSedes();

?>

<form id="formContacto" autocomplete="off" method="post">

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="txtNombre">Nombre</label>
            <input type="text" class="form-control" id="txtNombre" value="<?= $dataEmpresaContacto->nombre; ?>" name="txtNombre">
        </div>
    </div>

    <div class="form-group">
        <label for="txtCargo">Cargo</label>
        <input type="text" class="form-control" id="txtCargo" value="<?= $dataEmpresaContacto->cargo; ?>" name="txtCargo">
    </div>

    <div class="form-group">
        <label for="selectSede">Sede donde cotiza</label>
        <select class="form-control" id="selectSede" name="selectSede">
            <option value="0">Seleccione Sede</option>
            <?php 
                foreach ($sedeusuario as $clave => $valor) {
                    $selected = $dataEmpresaContacto->sucursal_id == $valor->id_sede ? 'selected' : '';
                    echo "<option value='".$valor->id_sede."' ".$selected.">".$valor->descripcion."</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" value="<?= $dataEmpresaContacto->email; ?>" name="txtEmail">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
	        <label for="txtTelefono">Teléfono</label>
	        <input type="text" class="form-control" id="txtTelefono" value="<?= $dataEmpresaContacto->telefono; ?>" name="txtTelefono">
        </div>
        <div class="form-group col-md-6">
	        <label for="txtCelular">Celular</label>
	        <input type="text" class="form-control" id="txtCelular" value="<?= $dataEmpresaContacto->celular; ?>" name="txtCelular">
        </div>
    </div>

    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="chkActivo" <?= $dataEmpresaContacto->activo == 1 ? "checked" : "" ?> name="chkActivo">
            <label class="form-check-label" for="chkActivo">Activo</label>
        </div>
    </div>

    <hr>
    <div class="form-group text-right">
        <span class="is-invalid invalid-feedback"></span>
    </div>
    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onclick="$('#modalEmpresaPersonal').modal('show');">Cerrar</button>
        <button type="submit" class="btn btn-info btn-sm" id="btnGuardar">Guardar</button>
    </div>
</form>

<!-- AJAX -->
<script>
$("#modalEmpresaPersonal").modal("hide");
$(document).ready(function() {
    $("#formContacto").validate({
        debug: true,
        rules: {
            txtNombre: {
                required: true,
                minlength: 3
            },
            selectSede: {
                required: true,
                min: 1
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtTelefono: {
                digits: true,
                minlength: 9
            },
            txtCelular: {
                digits: true,
                minlength: 9
            }
        },
        messages: {
            txtNombre: {
                required: "Debe ingresar su Nombre",
                minlength: "El Nombre debe tener mínimo 3 letras"
            },
            selectSede: {
                required: "Debe ingresar una sede.",
                min: "Debe seleccionar una sede válida"
            },
            txtEmail: {
                required: "Debe ingresar un correo",
                email: "El Correo debe contener el siguiente formato nombre@dominio.cl"
            },
            txtTelefono: {
                digits: "El Teléfono sólo puede contener dígitos",
                minlength: "El Teléfono debe tener 9 dígitos, recuerde agregar el 2 o el 9 según corresponda"
            },
            txtCelular: {
                digits: "El Celular sólo puede contener dígitos",
                minlength: "El Celular debe tener 9 dígitos, recuerde agregar el 2 o el 9 según corresponda"
            }
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {
            const answer_arr = $("#formContacto").serialize();
            $.ajax({
                url: "<?= CONTROLLERS ?>/empresa.php",
                type: "POST",
                data: "acc=3&type=<?= $idC == 0 ? 'create' : 'edit'; ?>&idE=<?= $id; ?>&idC=<?= $idC; ?>&idU=<?= $idU; ?>&"+answer_arr,
                error: function (e) {
                    $("#btnGuardar").prop("disabled", false);
                    console.info(e);
                },
                beforeSend: function () {
                    $("#btnGuardar").prop("disabled", true);
                },
                success: function (data) {
                    $("#btnGuardar").prop("disabled", false);
                    console.info(data);
                    eval(data);
                    //alert(r.mensaje);
                    if (r.resultado == "OK") {
                        loadPersonalData();
                        alertOk(r.titulo,r.mensaje);
                        $("#modalEmpresaPersonal").modal("show");
                        $("#modalEmpresa").modal("hide");
                    }
                    else
                        alertFail(r.titulo,r.mensaje);
                }
            });
        }
    });
});

function loadPersonalData ()
{
    $.ajax({
        url: "<?= CONTROLLERS ?>/empresa.php",
        type: "POST",
        data: "acc=6&idE=<?= $id; ?>",
        error: function (e) {
            console.info(e);
        },
        beforeSend: function () {
        },
        success: function (contacto) {
            eval(contacto);

            var x = JSON.parse(contacto);
            var  html = "";
            $.each(x, function(i,value){
                let activo = value.activo == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                html += "<tr>"+
                                "<td>"+activo+"</td>"+
                                "<td>"+value.nombre+"</td>"+
                                "<td>"+value.sede_name+"</td>"+
                                "<td>"+value.email+"</td>"+
                                "<td>"+value.telefono+"</td>"+
                                "<td>"+value.accion+"</td>"+
                            "<tr>";

                $(".table-contacto tbody").html(html);
            });

        }
    });
}
</script>