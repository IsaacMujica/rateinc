<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";

$empresa = new Empresa();

$id = intval($_GET['id']);
$idU = intval($_GET['idU']);

$dataPersonal = $empresa->getListaPersonal($id);
$dataTipoPersona = $empresa->getListaPersonalTipo();
//echo $id . "<br><br>";
//
/*
echo "<pre>";
echo "idE ";
print_r($id);
echo "</pre>";
echo "<pre>";
echo "idU ";
print_r($idU);
echo "</pre>";
echo "<pre>";
echo "SESSION";
print_r($_SESSION);
echo "</pre>";
echo "<pre>";
echo "dataPersonal";
print_r($dataPersonal);
echo "</pre>";
*/
?>

<form id="formEmpresa" autocomplete="off" method="post">

    <div class="form-group">
        <label for="cmbTipoPersonal">Tipo de Personal</label>
        <select id="cmbTipoPersonal" class="form-control" name="cmbTipoPersonal">
            <option value="" selected="">Seleccione tipo de personal</option>
        <?php
        foreach ($dataTipoPersona as $key => $value) {
            //$key++;
            //$selected = $dataTipoPersona == $key ? 'selected' : '';
            echo '<option value="' . $value->id . '">' . $value->nombre . '</option>';
        } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="txtNombre">Nombre</label>
        <input type="text" class="form-control" id="txtNombre" value="" name="txtNombre">
    </div>

    <div class="form-group">
        <label for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" value="" name="txtEmail">
    </div>

    <div class="form-group">
        <label for="txtTelefono">Teléfono</label>
        <input type="text" class="form-control" id="txtTelefono" value="" name="txtTelefono">
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

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Tipo de Personal</th>
			<th>Nombre</th><!-- 
			<th>RUT</th> -->
			<th>Correo</th>
			<th>Teléfono</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if (count($dataPersonal) == 0)
			echo '<tr><td align="center" colspan="3"><b>No tiene personal asociado</b></td></tr>';
		foreach ($dataPersonal as $key => $value) {
			/*echo $key;
			echo "<br>";
			var_dump( $value);
			echo "<br>";*/
			echo "<tr>";
				echo "<td>".$value->personal_tipo_nombre."</td>";
				echo "<td>".$value->nombre."</td>";/*
				echo "<td>".$value->rut."</td>";*/
				echo "<td>".$value->email."</td>";
				echo "<td>".$value->telefono."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
</table>

<!-- AJAX -->
<script>
$(document).ready(function() {
    $("#txtRut").Rut({
        format_on: 'keyup'
    }); 
    $("#formEmpresa").validate({
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
            const answer_arr = $("#formEmpresa").serialize();
            $.ajax({
                url: "<?= CONTROLLERS ?>/empresa.php",
                type: "POST",
                data: "acc=4&idE=<?= $id; ?>&idU=<?= $idU; ?>&"+answer_arr,
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
                    alert(r.mensaje);
                    if (r.resultado == "OK") {
                        tblcampania.ajax.reload();
                    	loadPersonalData();
                    }
                }
            });
        }
    });
});
var todo_personal;
function loadPersonalData ()
{
	$.ajax({
        url: "<?= CONTROLLERS ?>/empresa.php",
        type: "POST",
        data: "acc=5&idE=<?= $id; ?>&json=true",
        error: function (e) {
            console.info(e);
        },
        beforeSend: function () {
        },
        success: function (personal) {
            eval(personal);
            console.info(personal);
            todo_personal = personal;
            //alert(r.mensaje);
        	$.each(personal, function(i,value){
        		var html = "<tr>"+
        						"<td>"+value.personal_tipo_nombre+"</td>"+
        						"<td>"+value.nombre+"</td>"+
        						"<td>"+value.email+"</td>"+
        						"<td>"+value.telefono+"</td>"+
        					"<tr>";

        		$("table.table tbody").html(html);
        	});
        }
    });
}
</script>