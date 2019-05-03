<?php
require_once "../../config/app.php";
require_once "../../app/Cotizacion.php";
require_once "../../app/Empresa.php";

$cotizacion = new Cotizacion();
$empresa = new Empresa();

$idCotizacion = intval($_GET['idC']);
$idEmpresa = intval($_GET['idE']);
$idSede = intval($_GET['ids']);
$idUsuario = intval($_GET['idu']);

$arr = array("idE" => $idEmpresa, "tipo_p" => "3");
$datos_encargados_pagos = $empresa->getListaPersonal($arr);

$arr = array("idE" => $idEmpresa, "tipo_p" => "4");
$datos_encargados_compras = $empresa->getListaPersonal($arr);

$arr = array("idE" => $idEmpresa, "tipo_p" => "5");
$datos_jefe_bodega = $empresa->getListaPersonal($arr);

session_start();

$FormaPago = array (
    'Orden de Compra',
    'Pago Directo',
    'Efectivo',
    'Cheque al Día',
    'Transferencia Bancaria',
    'Cheque a 30 Días'
);

/*
echo "<pre>";
print_r($_GET);
echo "</pre>";
*/
?>

<form id="formEstadoPago" autocomplete="off">
    <!--<div class="form-group">
        <label for="cmbGerente">Gerente</label>
        <select id="cmbGerente" name="cmbGerente" class="form-control">
            <option value="">Seleccione Gerente</option>
        </select>
    </div>-->

    <div class="form-group">
        <label for="cmbEncargadoPago">Encargado de Pagos</label>
        <select id="cmbEncargadoPago" name="cmbEncargadoPago" class="form-control">
            <option value="">Seleccione Encargado</option>
            <?php 

                print_r($datos_encargados_pagos);
                foreach ($datos_encargados_pagos as $key => $value) {
                    if($key == 0){
                        $selected = "selected";
                    }else{
                        $selected = "";
                    }
                    echo '<option value="'.$value->id.'" '.$selected.'>'.$value->nombre.'</option>';
                } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="cmbEncargadoCompra">Encargado de Compras</label>
        <select id="cmbEncargadoCompra" name="cmbEncargadoCompra" class="form-control">
            <option value="">Seleccione Encargado</option>
            <?php
                foreach ($datos_encargados_compras as $key => $value) {
                    if($key == 0){
                        $selected = "selected";
                    }else{
                        $selected = "";
                    }
                    echo '<option value="'.$value->id.'" '.$selected.'>'.$value->nombre.'</option>'; 
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="cmbJefeBodega">Jefe de Bodega</label>
        <select id="cmbJefeBodega" name="cmbJefeBodega" class="form-control">
            <option value="">Seleccione Jefe de Bodega</option>
            <?php 
                foreach ($datos_jefe_bodega as $key => $value) {
                    if($key == 0){
                        $selected = "selected";
                    }else{
                        $selected = "";
                    }
                    echo '<option value="'.$value->id.'" '.$selected.'>'.$value->nombre.'</option>';     
                } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="txtOrdenCompra">N° Orden de Compra </label>
        <input type="text" id="txtOrdenCompra" name="txtOrdenCompra" class="form-control">
    </div>

    <div class="form-group">
        <label for="txtOtrosDatos">Otros datos de Facturación</label>
        <input type="text" id="txtOtrosDatos" name="txtOtrosDatos" class="form-control" placeholder="">
    </div>

    <div class="form-group">
        <label for="cmbFormaPago">Forma de Pago</label>
        <select id="cmbFormaPago" name="cmbFormaPago" class="form-control">
            <option value="">Seleccione Forma de Pago</option>
            <?php

            foreach ($FormaPago as $key => $value) {

                $key++;
                echo '<option value="'.$key.'">'.$value.'</option>';

            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="txtFechaCotizacion">Fecha Cotización</label>
        <input type="text" id="txtFechaCotizacion" name="txtFechaCotizacion" class="form-control" value="<?=date('d-m-Y')?>" disabled>
    </div>

    <div class="form-group">
        <label for="txtOrdenCompra">Documento</label><br>
        <input type="file" id="fileDocumento" name="fileDocumento" multiple class="">
    </div>

    <hr>
    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-info btn-sm" id="btnGuardar">Guardar</button>
    </div>
</form>

<script>
    //ajax

    $(document).ready(function() {

        //alert("asd:" + "<?= $idCotizacion; ?>");


    $("#formEstadoPago").validate({
        debug: true,
        rules: {
            cmbEncargadoPago: {
                required: true
            },
            cmbJefeBodega: {
                required: true
            },
            txtOrdenCompra: {
                required: true
            },
            cmbFormaPago: {
                required:true
            }
        },
        messages: {
            cmbEncargadoPago: {
                required: "Debe seleccionar un personal válido"
            },
            cmbJefeBodega: {
                required: "Debe seleccionar un personal válido"
            },
            txtOrdenCompra: {
                required: "Debe ingresar el número de orden"
            },
            cmbFormaPago: {
                required: "Debe ingresar una forma de pago válida"
            }
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {

            const dataForEstadoPago = $("#formEstadoPago").serialize();

            let cmbEncargadoPago    = $('#cmbEncargadoPago').val();
            let cmbEncargadoCompra  = $('#cmbEncargadoCompra').val();
            let cmbJefeBodega       = $('#cmbJefeBodega').val();
            let txtOrdenCompra      = $('#txtOrdenCompra').val();
            let txtOtrosDatos       = $('#txtOtrosDatos').val();
            let cmbFormaPago        = $('#cmbFormaPago').val();

            let formData = new FormData();

            formData.append('acc', '6');
            formData.append('cmbEncargadoPago', cmbEncargadoPago);
            formData.append('cmbEncargadoCompra', cmbEncargadoCompra);
            formData.append('cmbJefeBodega', cmbJefeBodega);
            formData.append('txtOrdenCompra', txtOrdenCompra);
            formData.append('txtOtrosDatos', txtOtrosDatos);

            formData.append('cmbFormaPago', cmbFormaPago);

            formData.append('idu', '<?= $idUsuario; ?>');
            formData.append('idc', '<?= $idCotizacion; ?>');
            formData.append('ids', '<?= $idSede; ?>');
            formData.append('idE', '<?=$idEmpresa?>');

            jQuery.each(jQuery('#fileDocumento')[0].files, function(i, file) {
                formData.append('archivo_' + i, file);
            });

            $.ajax({
                url: "<?= CONTROLLERS ?>/cotizacion/cotizacion.php",
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                //data: "acc=6&" + dataForEstadoPago + "&idu=<?= $idUsuario; ?>&idc=<?= $idCotizacion; ?>&ids=<?= $idSede; ?>&idE=<?=$idEmpresa?>",
                error: function (e) {
                    $("#btnGuardar").prop("disabled", false);
                },
                beforeSend: function () {
                    $("#btnGuardar").prop("disabled", true);
                },
                success: function (data) {
                    $("#btnGuardar").prop("disabled", false);
                    console.info(data);
                    eval(data);
                    //alert(r.mensaje);
                    if (response.respuesta == "OK") {

                        alertOk("Correcto", response.mensaje, function() {
                            $("#modalCotizacion").modal("hide");
                            tblCotizacion.ajax.reload();

                            window.open('cotizacionPagoPDF.php?ficha=<?=$idCotizacion?>&idcotPag=' + response.idEstadoPago + '&idE=<?=$idEmpresa?>', '_blank')
                        });

                    }else{
                        alertFail("Error", response.mensaje);                        
                    }
                }
            });
        }
    });
});

</script>
