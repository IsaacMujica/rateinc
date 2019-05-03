<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";

$empresa = new Empresa();

$id = intval($_GET['id']);
$idP = intval($_GET['idP']);
$idU = intval($_GET['idU']);

$arr = array("idP" => $idP, "idE" => $id);

//$dataPersonal = $empresa->getListaPersonal($arr);
$dataPersonal = $empresa->getListaPersonal($arr);
$dataTipoPersona = $empresa->getListaPersonalTipo();
//echo $id . "<br><br>";
//
/*
echo "<pre>";
echo "idE ";
print_r($id);
echo "</pre>";
echo "<pre>";
echo "idP ";
print_r($idP);
echo "</pre>";
echo "<pre>";
echo "idU ";
print_r($idU);
echo "</pre>";
echo "<pre>";
echo "dataPersonal";
print_r($dataPersonal);
echo "</pre>";
*/

?>

<form id="formPersonal" autocomplete="off" method="post">

    <div class="form-group">
        <h2 for=""><?= $dataPersonal->nombre; ?></h2>
    </div>

    <div class="form-group">
        <label for="cmbTipoPersonal">Tipo de Personal</label>
        <select id="cmbTipoPersonal" class="form-control" name="cmbTipoPersonal">
            <option value="" selected="">Seleccione tipo de personal</option>
        <?php
        foreach ($dataTipoPersona as $key => $value) {
            //$key++;
            
            $selected = $dataPersonal->personal_tipo_id == $value->id ? 'selected' : '';
            echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->nombre . '</option>';
        } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="txtNombre">Nombre</label>
        <input type="text" class="form-control" id="txtNombre" value="<?= $dataPersonal->nombre; ?>" name="txtNombre">
    </div>

    <div class="form-group">
        <label for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" value="<?= $dataPersonal->email; ?>" name="txtEmail">
    </div>

    <div class="form-group">
        <label for="txtTelefono">Teléfono</label>
        <input type="text" class="form-control" id="txtTelefono" value="<?= $dataPersonal->telefono; ?>" name="txtTelefono">
    </div>

    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="chkActivo" <?= $dataPersonal->activo == 1 ? "checked" : "" ?> name="chkActivo">
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
    $("#formPersonal").validate({
        debug: true,
        rules: {
            cmbTipoPersonal: {
                required: true
            },
            txtNombre: {
                required: true,
                minlength: 3
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtTelefono: {
                digits: true,
                minlength: 9
            }
        },
        messages: {
            cmbTipoPersonal: {
                required: "Debe seleccionar un tipo de personal válido"
            },
            txtNombre: {
                required: "Debe ingresar su Nombre",
                minlength: "El Nombre debe tener mínimo 3 letras"
            },
            txtEmail: {
                required: "Debe ingresar un correo",
                email: "El Correo debe contener el siguiente formato nombre@dominio.cl"
            },
            txtTelefono: {
                digits: "El Teléfono sólo puede contener dígitos",
                minlength: "El Teléfono debe tener 9 dígitos, recuerde agregar el 2 o el 9 según corresponda"
            }
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {
            const answer_arr = $("#formPersonal").serialize();
            $.ajax({
                url: "<?= CONTROLLERS ?>/empresa.php",
                type: "POST",
                data: "acc=4&type=<?= $idP == 0 ? 'create' : 'edit'; ?>&idE=<?= $id; ?>&idP=<?= $idP; ?>&idU=<?= $idU; ?>&"+answer_arr,
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
                        $("#modalEmpresaPersonal").modal("show");
                        $("#modalEmpresa").modal("hide");
                        loadPersonalData();
                        alertOk(r.titulo,r.mensaje);
                    }
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
        data: "acc=5&idE=<?= $id; ?>",
        error: function (e) {
            console.info(e);
        },
        beforeSend: function () {
        },
        success: function (personal) {
            eval(personal);

            var x = JSON.parse(personal);
            var  html = "";
        	$.each(x, function(i,value){
                let activo = value.activo == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
        		html += "<tr>"+
                                "<td>"+activo+"</td>"+
        						"<td>"+value.personal_tipo_nombre+"</td>"+
        						"<td>"+value.nombre+"</td>"+
        						"<td>"+value.email+"</td>"+
        						"<td>"+value.telefono+"</td>"+
                                "<td>"+value.accion+"</td>"+
        					"<tr>";

        		$(".table-personal tbody").html(html);
        	});

        }
    });
}
</script>