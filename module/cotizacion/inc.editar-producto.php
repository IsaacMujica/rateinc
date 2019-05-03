<?php
require_once "../../config/app.php";
require_once "../../app/Producto.php";

$producto = new Producto();
$dataProducto = $producto->getInfoProducto($_GET['id']);
$id = intval($_GET['id']);

/*
echo "<pre>";
print_r($dataEmpresa);
echo "</pre>";
*/
?>

<form id="formProducto" autocomplete="off">
    <div class="form-group">
        <label for="cmbReferencia">Referenciaa</label>
        <select id="cmbReferencia" name="cmbReferencia" class="form-control">
            <option value="">Seleccione referencia</option>
            <option value="1" <?=$dataProducto->tipo_id == 1 ? 'selected' : ''?> >Capacitación</option>
            <option value="8" <?=$dataProducto->tipo_id == 8 ? 'selected' : ''?> >Inspecciones</option>
        </select>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="txtCodigoSap">Código SAP</label>
            <input type="text" class="form-control" id="txtCodigoSap" name="txtCodigoSap" value="<?=$dataProducto->codigo_sap?>">
        </div>
        <div class="form-group col-md-6">
            <label for="txtOt">OT</label>
            <input type="text" class="form-control" id="txtOt" name="txtOt" value="<?=$dataProducto->ot?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="txtPrecio">Precio</label>
            <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" value="<?=$dataProducto->precio?>">
        </div>
        <div class="form-group col-md-6">
            <label for="txtHoras">Horas</label>
            <input type="text" class="form-control" id="txtHoras" name="txtHoras" value="<?=$dataProducto->horas?>">
        </div>
    </div>

    <div class="form-group">
        <label for="txtDescripcion">Descripción</label>
        <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" cols="30" rows="5"><?=$dataProducto->descripcion?></textarea>
    </div>
    <div class="form-group">
        <label for="txtObjetivo">Objetivo</label>
        <textarea name="txtObjetivo" id="txtObjetivo" class="form-control" cols="30" rows="5"><?=$dataProducto->objetivo?></textarea>
    </div>

    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="chkActivo" <?= $dataProducto->activo == 1 ? "checked" : "" ?> name="chkActivo">
            <label class="form-check-label" for="chkActivo">Activo</label>
        </div>
    </div>
    <hr>
    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info btn-sm">Guardar</button>
    </div>
</form>

<!-- AJAX -->
<script>
cant_reg_activas = parseInt("<?= $regiones['cant_reg_activas']; ?>");
$(document).ready(function() {
    /*$("#txtRut").Rut({
        format_on: 'keyup'
    });*/
    $("#formProducto").validate({
        debug: true,
        rules: {
            cmbReferencia: {
                required: true
            },
            txtCodigoSap: {
                required: true,
                digits: true
            },
            txtPrecio: {
                digits: true
            }
        },
        messages: {
            cmbReferencia: {
                required: "Debe seleccionar una Referencia"
            },
            txtCodigoSap: {
                required: "Por favor ingrese el Código SAP",
                digits: "El Código SAP sólo debe tener números"
            },
            txtPrecio: {
                digits: "El precio debe ser numérico"
            }
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {
            const answer_arr = $("#formProducto").serialize();
            console.info(answer_arr);

            $.ajax({
                url: "<?= CONTROLLERS ?>/cotizacion/producto-y-servicio.php",
                type: "POST",
                data: "acc=2&type=<?= $id == 0 ? 'create' : 'edit'; ?>&idP=<?= $id; ?>&"+answer_arr,
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
                    alertOk(r.titulo,r.mensaje);
                    if (r.resultado == "OK")
                        tblProducto.ajax.reload();
                }
            });
        }
    });
});
</script>
<!-- GET COMUNAS -->
<script>
$(document).ready(function() {
    $("#cmbRegion").on("change",function(){
        const idR = parseInt($("#cmbRegion").val());
        console.info(idR);
        if (isNaN(idR) || idR <= 0 || idR > 15) {
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
                    $("#cmbComuna").html(comunas_load);
                }
            }
        });
        
    });
});
</script>