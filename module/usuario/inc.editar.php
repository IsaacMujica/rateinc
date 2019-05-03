<?php
require_once "../../config/app.php";
require_once "../../app/Usuario.php";
require_once "../../app/Localidad.php";
require_once "../../app/Sede.php";

$tipoUsuario = array (
    'Admin',
    'Jefe de Sucursal',
    'Coordinador',
    'Asistente de Capacitación',
    'Asistente Administrativo',
    'Instructor',
    'Inspector',
    'Call Center'
);

$usuario = new Usuario();
$localidad = new Localidad();
$sedes = new Sede();

$id = intval($_GET['id']);

$dataUsuario = $usuario->getInfoUsuario($id);
$sedeusuario = $sedes->getListaSedes();
$tipoUsuario = $usuario->getListaTipoUsuario();

$regiones = $localidad->getRegiones();
$comunas = [];

if ($dataUsuario->comuna_id != "")
    $comunas = $localidad->getComunas($dataUsuario->region_id);
/*
echo "<pre>";
echo $regiones['cant_reg_activas'];
echo "</pre>";
*/
?>

<form id="formUsuario" autocomplete="off" method="post">
    <div class="form-group">
        <label for="cmbTipoUsuario">Tipo Usuario</label>
        <select id="cmbTipoUsuario" class="form-control" name="cmbTipoUsuario">
            <option value="">Seleccione tipo de usuario</option>
        <?php
        foreach ($tipoUsuario as $key => $value) {

            $key++;
            $selected = $dataUsuario->tipo_id == $value->id ? 'selected' : '';
            echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->descripcion . '</option>';
        } ?>
        </select>
    </div>

    <div class="form-row">
        <div class="form-group col-12">
            <label for="txtNombre">Nombre</label>
            <input type="text" class="form-control" id="txtNombre" value="<?=$dataUsuario->nombre?>" name="txtNombre">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="txtApellidoPaterno">Apellido Paterno</label>
            <input type="text" class="form-control" id="txtApellidoPaterno" value="<?=$dataUsuario->apellido_paterno?>" name="txtApellidoPaterno">
        </div>
        <div class="form-group col-md-6">
            <label for="txtApellidoMaterno">Apellido Materno</label>
            <input type="text" class="form-control" id="txtApellidoMaterno" value="<?=$dataUsuario->apellido_materno?>" name="txtApellidoMaterno">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="txtRut">RUT</label>
            <input type="text" class="form-control" id="txtRut" value="<?=$dataUsuario->rut?>" name="txtRut">
        </div>
        <div class="form-group col-md-6">
            <label for="txtEmail">Email</label>
            <input type="email" class="form-control" id="txtEmail" value="<?=$dataUsuario->email?>" name="txtEmail">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-12">
            <label for="txtProfesion">Cargo</label>
            <input type="text" class="form-control" id="txtProfesion" value="<?=$dataUsuario->profesion?>" name="txtProfesion">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="txtCelular">Celular</label>
            <input type="text" class="form-control" id="txtCelular" value="<?=$dataUsuario->celular?>" name="txtCelular">
        </div>
        <div class="form-group col-md-6">
            <label for="txtTelefono">Teléfono</label>
            <input type="text" class="form-control" id="txtTelefono" value="<?=$dataUsuario->telefono?>" name="txtTelefono">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-12">
            <label for="cmbSede">Sede</label>
            <select id="cmbSede" name="cmbSede" class="form-control" >
                <option value="">Seleccione sede</option>
                <?php 
                    foreach ($sedeusuario as $clave => $valor) {
                        $selected = $dataUsuario->sede_id == $valor->id_sede ? 'selected' : '';
                        echo "<option value='".$valor->id_sede."' ".$selected.">".$valor->descripcion."</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <!--<div class="form-row">
        <div class="form-group col-md-6">
            <label for="cmbRegion">Región</label>
            <select id="cmbRegion" class="form-control" name="cmbRegion">
                <option value="">Seleccionar Región</option>
                <?php
                foreach ($regiones as $clave => $valor) {
                    $selected = $dataUsuario->region_id == $valor->id ? "selected" : "";
                    if ($clave != "cant_reg_activas")
                        echo "<option value='$valor->id' $selected> $valor->descripcion </option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="cmbComuna">Comuna</label>
            <select id="cmbComuna" class="form-control" name="cmbComuna">
                <option value="">Seleccionar Comuna</option>
                <?php
                foreach ($comunas as $clave => $valor) {
                    $selected = $dataUsuario->comuna_id == $valor->id ? "selected" : "";
                    echo "<option value='$valor->id' $selected> $valor->descripcion </option>";
                }
                ?>
            </select>
        </div>
    </div>-->

    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="chkActivo" <?= ($dataUsuario->activo == 1 || is_null($dataUsuario) ? "checked" : "") ?> name="chkActivo" value="1">
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
cant_reg_activas = parseInt("<?= $regiones['cant_reg_activas']; ?>");
$(document).ready(function() {
    $("#txtRut").Rut({
        format_on: 'keyup'
    }); 
    $("#formUsuario").validate({
        debug: true,
        rules: {
            cmbTipoUsuario: {
                required: true,
                digits: true
            },
            txtNombre: {
                required: true,
                minlength: 3
            },
            txtApellidoPaterno: {
                required: true
            },
            txtRut: {
                required: true,
                rut: true
            },
            txtEmail: {
                required: true,
                email: true
            },
            txtProfesion: {
                required: true
            },
            txtTelefono: {
                required: true,
                digits: true
            },
            cmbSede: {
                required: true,
                digits: true
            }
        },
        messages: {
            cmbTipoUsuario: {
                required: "Debe seleccionar el tipo de usuario",
                digits: "Debe seleccionar el tipo de usuario"
            },
            txtNombre: {
                required: "Debe ingresar su nombre",
                minlength: "El nombre debe contener minimo 3 caracteres"
            },
            txtApellidoPaterno: {
                required: "Debe ingresar su apellido"
            },
            txtRut: {
                required: "Debe ingresar un rut",
                rut: "Debe ingresar un rut válido"
            },
            txtEmail: {
                required: "Debe ingresar un email",
                email: "Debe ingresar un email válido"
            },
            txtProfesion: {
                required: "Debe ingresar un cargo"
            },
            txtTelefono: {
                required: "Debe ingresar un teléfono",
                digits: "El teléfono solo debe contener dígitos"
            },
            cmbSede: {
                required: "Debe seleccionar la sede",
                digits: "Debe seleccionar una sede válida"
            }
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {
            const formData = $("#formUsuario").serialize();
            console.info({form,formData});

            $.ajax({
                url: "<?= CONTROLLERS ?>/usuario.php",
                type: "POST",
                data: "acc=2&idU=<?=$id?>&"+formData,
                error: function (e) {
                    $("#btnGuardar").prop("disabled", false);
                    console.info(e);
                },
                beforeSend: function () {
                    $("#btnGuardar").prop("disabled", true);
                },
                success: function (data) {
                    $("#btnGuardar").prop("disabled", false);
                    //eval(data);
                    $.globalEval(data);
                    console.info(data)
                    if (response.respuesta == "OK") {
                        alertOk("Correcto",response.mensaje);
                        $('#modalUsuario').modal('hide');
                        tblUsuario.ajax.reload();
                    }else{
                        alertFail("Error",response.mensaje);
                    }

                }
            });
        }
    });
});

$(document).ready(function() {
    $("#cmbRegion").on("change",function(){
        const idR = parseInt($("#cmbRegion").val());
        console.info(idR);
        if (isNaN(idR) || idR <= 0 || idR > <?= $regiones['cant_reg_activas']; ?>) {
            $("#cmbComuna").html('<option value="">Seleccionar Comuna</option>');
            alertFail("Error","Selecciona una Región válida");
            return false;
        }
        $.ajax({
            url: "<?= CONTROLLERS ?>/localidad.php",
            type: "POST",
            data: {
                acc  : 1,
                idR  : idR,
                ajax : true
            },
            error: function (e) {
                console.info(e);
            },
            beforeSend: function () {},
            success: function (data) {
                eval(data);
                if (r.resultado == "OK") {
                    var comunas_load = ['<option value="">Seleccionar Comuna</option>'];
                    $.each(comunas, function(key,value) {
                        comunas_load.push('<option value="' + value.id + '">' + value.descripcion + '</option>')
                    });
                    //$("#cmbComuna").html(comunas_load);
                }
            }
        });
        
    });
});
</script>