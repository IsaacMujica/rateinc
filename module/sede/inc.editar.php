<?php
require_once "../../config/app.php";
require_once "../../app/Sede.php";
require_once "../../app/Usuario.php";

$sede = new Sede();

$usuario = new Usuario();

$id = intval($_GET['id']);

$dataSede = $sede->getInfoSede($id);

$tipoUsuario = array(1, 2);
$dataUsuario = $usuario->getUsuarioCmb($tipoUsuario);

?>

<form id="formSede" autocomplete="off" method="post">
    <div class="form-group">
        <label for="cmbEncargado">Encargado</label>
        <select id="cmbEncargado" class="form-control" name="cmbEncargado">
            <option value="">Seleccione encargado</option>
            <?php
            for($i = 0; $i < count($dataUsuario); $i++){
                $selected = $dataUsuario[$i]->id == $dataSede->encargado_id ? 'selected' : '';
                echo '<option value="' . $dataUsuario[$i]->id . '" ' . $selected . '>' . $dataUsuario[$i]->nombre . ' ' . $dataUsuario[$i]->paterno . ' ' . $dataUsuario[$i]->materno . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="txtDescripcion">Descripción</label>
            <input type="text" class="form-control" id="txtDescripcion" value="<?=$dataSede->descripcion?>" name="txtDescripcion">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="txtDireccion">Dirección</label>
            <input type="text" class="form-control" id="txtDireccion" value="<?=$dataSede->direccion?>" name="txtDireccion">
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" 
            id="chkActivo" <?= ($dataSede->activo == 1 || is_null($dataSede) ? "checked" : "") ?> name="chkActivo">
            <label class="form-check-label" for="chkActivo">Activo</label>
        </div>
    </div>
    <hr>
    <div class="form-group text-right">
        <span class="is-invalid invalid-feedback"></span>
    </div>
    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info btn-sm" id="btnGuardar">Guardar</button>
    </div>
</form>

<!-- AJAX -->
<script>
$(document).ready(function() {
    $("#formSede").validate({
        debug: true,
        rules: {
            txtDescripcion: {
                required: true,
            },
            cmbEncargado: {
                required: true,
            },
            txtDireccion: {
                required: true,
            }
        },
        messages: {
            cmbEncargado: {
                required: "Debe seleccionar Encargado",
            },
            txtDescripcion: {
                required: "Debe ingresar Descrición",
                minlength: "La Descripción debe tener mínimo 3 letras"
            },
            txtDireccion: {
                required: "Debe ingresar la Dirección",
                minlength: "La Dirección debe tener mínimo 3 letras"
            },
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {
            const answer_arr = $("#formSede").serialize();
            console.info({form,answer_arr});

            $.ajax({
                url: "<?= CONTROLLERS ?>/sede.php",
                type: "POST",
                data: "acc=2&type=<?= $id == 0 ? 'create' : 'edit'; ?>&idS=<?= $id; ?>&"+answer_arr,
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

                    if (r.resultado == "OK") {
                        alertOk("Correcto",r.mensaje);
                        $("#modalSede").modal("hide");
                        tblSede.ajax.reload();
                    }else{
                        alertFail("Error",r.mensaje);
                    }
                }
            });
        }
    });
});
</script>