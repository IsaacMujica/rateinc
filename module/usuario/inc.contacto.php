<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";

$empresa = new Empresa();

$id = intval($_GET['id']);
$idU = intval($_GET['idU']);

$dataContacto = "";//$empresa->getInfoEmpresaContacto();
$dataEmpresaContacto = $empresa->getListaContacto($id);
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
echo "dataEmpresaContacto";
print_r($dataEmpresaContacto);
echo "</pre>";
*/
?>

<form id="formEmpresa" autocomplete="off" method="post">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="txtNombre">Nombre</label>
            <input type="text" class="form-control" id="txtNombre" value="" name="txtNombre">
        </div>
        <div class="form-group col-md-6">
            <label for="txtRut">RUT</label>
            <input type="text" class="form-control" id="txtRut" value="" name="txtRut">
        </div>
    </div>

    <div class="form-group">
        <label for="txtCargo">Cargo</label>
        <input type="text" class="form-control" id="txtCargo" value="" name="txtCargo">
    </div>

    <div class="form-group">
        <label for="txtEmail">Email</label>
        <input type="email" class="form-control" id="txtEmail" value="" name="txtEmail">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
	        <label for="txtTelefono">Teléfono</label>
	        <input type="text" class="form-control" id="txtTelefono" value="" name="txtTelefono">
        </div>
        <div class="form-group col-md-6">
	        <label for="txtCelular">Celular</label>
	        <input type="text" class="form-control" id="txtCelular" value="" name="txtCelular">
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

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Nombre</th><!-- 
			<th>RUT</th> -->
			<th>Correo</th>
			<th>Teléfono</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if (count($dataEmpresaContacto) == 0)
			echo '<tr><td align="center" colspan="3"><b>No tiene contactos asociados</b></td></tr>';
		foreach ($dataEmpresaContacto as $key => $value)
		{
			/*echo $key;
			echo "<br>";
			var_dump( $value);
			echo "<br>";*/
			echo "<tr>";
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
            txtNombre: {
                required: true,
                minlength: 3
            },
            txtRut: {
                required: true,
                minlength: 8
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
            txtRut: {
                required: "Debe ingresar un RUT correcto",
                minlength: "El RUT ingresado debe tener mínimo 8 dígitos"
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
            const answer_arr = $("#formEmpresa").serialize();
            $.ajax({
                url: "<?= CONTROLLERS ?>/empresa.php",
                type: "POST",
                data: "acc=3&idE=<?= $id; ?>&idU=<?= $idU; ?>&"+answer_arr,
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
                    if (r.resultado == "OK")
                        tblcampania.ajax.reload();
                }
            });
        }
    });
});
</script>