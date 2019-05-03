<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";
require_once "../../app/Localidad.php";
require_once "../../config/session.php";

//$tipo_empresa = array("Persona Natural","Entidad Pública","Empresa"/*,"Privada","Colegio","Gobierno","Universidad"*/);

$empresa = new Empresa();
$localidad = new Localidad();

$id = intval($_GET['id']);

$dataEmpresa = $empresa->getInfoEmpresa($id);

$regiones = $localidad->getRegiones();
$comunas = [];

$tipo_empresa = $empresa->getTipoEmpresa();

if ($dataEmpresa->comuna_id != "")
    $comunas = $localidad->getComunas($dataEmpresa->region_id);

//PERSONAL
$dataTipoPersona = $empresa->getListaPersonalTipo();

//CONTACTOS


?>

<div class="row">
	
	<div class="col-5">
		<form id="formEmpresa" autocomplete="off" method="post">
		    <div class="form-group">
		        <label for="cmbTipoEmpresa">Tipo de empresa</label>
		        <select id="cmbTipoEmpresa" class="form-control" name="cmbTipoEmpresa">
		            <option value="">Seleccione tipo de organización</option>
		                <?php
		                foreach ($tipo_empresa as $clave => $valor) {
		                    //$selected = $dataEmpresa->tipo_empresa == $valor->id ? 'selected' : '';
		                    //echo '<option value="'.$valor->id.'" '.$selected.'>'.$valor->descripcion.'</option>';
		                    echo '<option value="'.$valor->id.'">'.$valor->descripcion.'</option>';
		                }
		                ?>
		        </select>
		    </div>

		    <div class="form-row">
		        <div class="form-group col-md-12">
		            <label for="txtRazonSocial">Razón Social</label>
		            <input type="text" class="form-control" id="txtRazonSocial" value="" name="txtRazonSocial">
		        </div>
		        <div class="form-group col-md-12">
		            <label for="txtNombreFantasia">Nombre Fantasía</label>
		            <input type="text" class="form-control" id="txtNombreFantasia" value="" name="txtNombreFantasia">
		        </div>
		    </div>

		    <div class="form-row">
		        <div class="form-group col-md-6">
		            <label for="txtRut">RUT</label>
		            <input type="text" class="form-control" id="txtRut" value="" name="txtRut">
		        </div>
		        <div class="form-group col-md-6">
		            <label for="txtTelefono">Teléfono</label>
		            <input type="text" class="form-control" id="txtTelefono" value="" name="txtTelefono">
		        </div>
		    </div>

		    <div class="form-group">
		        <label for="txtGiro">Giro</label>
		        <input type="text" class="form-control" id="txtGiro" value="" name="txtGiro">
		    </div>

		    <div class="form-group">
		        <label for="txtEmail">Email</label>
		        <input type="email" class="form-control" id="txtEmail" value="" name="txtEmail">
		    </div>

		    <div class="form-group">
		        <label for="txtPaginaWeb">Página Web</label>
		        <input type="text" class="form-control" id="txtPaginaWeb" value="" name="txtPaginaWeb">
		    </div>

		    <div class="form-row">
		        <div class="form-group col-md-6">
		            <label for="cmbRegion">Región</label>
		            <select id="cmbRegion" class="form-control" name="cmbRegion">
		                <option value="">Seleccionar Región</option>
		                <?php
		                foreach ($regiones as $clave => $valor) {
		                    //$selected = $dataEmpresa->region_id == $valor->id ? "selected" : "";
		                    //if ($clave != "cant_reg_activas")
		                        //echo "<option value='$valor->id' $selected> $valor->descripcion </option>";
		                        echo "<option value='$valor->id'> $valor->descripcion </option>";
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
		                    //$selected = $dataEmpresa->comuna_id == $valor->id ? "selected" : "";
		                    //echo "<option value='$valor->id' $selected> $valor->descripcion </option>";
		                    echo "<option value='$valor->id'> $valor->descripcion </option>";
		                }
		                ?>
		            </select>
		        </div>
		    </div>

		    <div class="form-group">
		        <label for="txtDireccion">Dirección</label>
		        <input type="text" class="form-control" id="txtDireccion" value="" name="txtDireccion">
		    </div>
			
			<?php if(in_array("3", $_SESSION['PERMISOS'])){ ?>
			    <div class="form-group">
			        <div class="form-check">
			            <input class="form-check-input" type="checkbox" 
			            id="chkActivo" checked name="chkActivo">
			            <label class="form-check-label" for="chkActivo">Activo</label>
			        </div>
			    </div>
		    <?php } ?>

		    <hr>
		    <div class="form-group text-right">
		        <span class="is-invalid invalid-feedback"></span>
		    </div>
		    <div class="form-group text-right">
		        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-info btn-sm" id="btnGuardar">Guardar</button>
		    </div>
		</form>
	</div>

	<div class="col-7">
		<form id="formPersonal">
			<div align="right">
				<button type="button" class="btn btn-info btn-xs" id="agregar_item_personal">
					<span>+</span>
				</button>
			</div>
			<table class="table" id="tablaPers">
				<tr>
					<td>
						<label for="cmbTipoPersonal">Tipo de Personal</label>
						<div id="SecctipoPersonal">
						<select id="cmbTipoPersonal" class="form-control" name="cmbTipoPersonal">
				            <option value="" selected="">Seleccione tipo de personal</option>
					        <?php
						        foreach ($dataTipoPersona as $key => $value) {
						        	echo '<option value="' . $value->id . '">' . $value->nombre . '</option>';
						        }
					        ?>
				        </select>
				        </div>
					</td>
					<td>
						<label for="txtNombre">Nombre</label>
						<div id="SecctxtNombre">
	        			<input type="text" class="form-control" id="txtNombre" value="" name="txtNombreFantasiare">
	        			</div>
					</td>
					<td>
						<label for="txtEmail">Email</label>
						<div id="SecctxtEmail">
	        			<input type="email" class="form-control" id="txtEmail" value="" name="txtEmail">
	        			</div>
					</td>
					<td>
						<label for="txtTelefono">Teléfono</label>
						<div id="SecctxtTelefono">
						<input type="text" class="form-control" id="txtTelefono" value="" name="txtTelefono">
						</div>
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</form>

		<form id="formContacto">
			
		</form>
	</div>

</div>


<!-- AJAX -->
<script src="../../public/vendor/jquery.Rut.min.js"></script>
<script>
cant_reg_activas = parseInt("<?= $regiones['cant_reg_activas']; ?>");
$(document).ready(function() {
    $("#txtRut").Rut({
        format_on: 'keyup'
    });

    $('#modalEmpresa .modal-dialog').addClass("modal-xl");

    //AGREGANDO ITEMS PERSONAL

    $("#agregar_item_personal").on("click", function(){

    	var tipo_personal = $("#SecctipoPersonal").html();
    	var nombre_personal = $("#SecctxtNombre").html();
    	var email_personal = $("#SecctxtEmail").html();
    	var fono_personal = $("#SecctxtTelefono").html();

    	contenido = "";
    	contenido += "<tr>";
    	contenido += "<td>"+tipo_personal+"</td>";
    	contenido += "<td>"+nombre_personal+"</td>";
    	contenido += "<td>"+email_personal+"</td>";
    	contenido += "<td>"+fono_personal+"</td>";
    	contenido += "</tr>";

    	$("#tablaPers").append(contenido);

    });

    //AGREGANDO ITEMS CONTACTO




    /*$.validator.addMethod('rut', function (value, element) { 
    return $.Rut.validar(value) 
    }, 'El RUT debe ser válido');*/ 

    $("#formEmpresa").validate({
        debug: true,
        rules: {
            cmbTipoEmpresa: {
                required: true,
                digits: true,
                minlength: 1
            },
            txtRazonSocial: {
                required: true,
                minlength: 3
            },
            txtNombreFantasia: {
                required: true
            },
            txtRut: {
                required: true,
                minlength: 8,
                rut: true
            },
            txtGiro: {
                required: true
            },
            txtEmail: {
                email: true
            },
            txtTelefono: {
                required: true,
                digits: true,
                minlength: 9
            },
            txtPaginaWeb: {
                url_final: true
            },
            cmbRegion: {
                required: true,
                digits: true
            },
            cmbComuna: {
                required: true,
                digits: true
            },
            txtDireccion: {
                required: true
            }
        },
        messages: {
            cmbTipoEmpresa: {
                required: "Debe seleccionar un Tipo de Empresa correcto",
                digits: "Seleccione un Tipo de Empresa válido",
                minlength: "Seleccione un Tipo de Empresa válido"
            },
            txtRazonSocial: {
                required: "Debe ingresar su Razón Social",
                minlength: "La Razón Social debe tener mínimo 3 letras"
            },
            txtNombreFantasia: {
                required: "Debe ingresar un nombre de fantasía"
            },
            txtRut: {
                required: "Debe ingresar un RUT correcto",
                minlength: "El RUT ingresado debe tener mínimo 8 dígitos",
                rut: "El RUT debe ser válido"
            },
            txtGiro: {
                required: "Debe ingresar un Giro"
            },
            txtEmail: {
                email: "El Correo debe contener el siguiente formato: nombre@dominio.cl"
            },
            txtTelefono: {
                required: "Debe ingresar un teléfono",
                digits: "El Número sólo puede contener dígitos",
                minlength: "El Número debe tener 9 dígitos, recuerde agregar el 2 o el 9 según corresponda"
            },
            txtPaginaWeb: {
                url_final: "La página debe tener el siguiente formato: paginaweb.cl"
            },
            cmbRegion: {
                required: "Debe seleccionar una Región",
                digits: "Debe seleccionar una Región válida"
            },
            cmbComuna: {
                required: "Debe seleccionar una Comuna",
                digits: "Debe seleccionar una Comuna válida"
            },
            txtDireccion: {
                required: "Debe ingresar una dirección"
            }
        },
        errorElement: 'span',
        errorClass: 'is-invalid invalid-feedback',
        highlight: function (element) {
            $(element).addClass('has_error is-invalid');
        },
        submitHandler: function (form) {
            const answer_arr = $("#formEmpresa").serialize();
            //console.info({form,answer_arr});
            /*if(!$.Rut.validar($("#txtRut").val())){
                alertFail("Error","Ingrese un RUT válido.");
                $("#txtRut").focus();
                return false;
            }*/
            $.ajax({
                url: "<?= CONTROLLERS ?>/empresa.php",
                type: "POST",
                data: "acc=2&type=<?= $id == 0 ? 'create' : 'edit'; ?>&idE=<?= $id; ?>&"+answer_arr,
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
                        alertOk(r.titulo, r.mensaje, function () {
                            tblcampania.ajax.reload();
                            $("#modalEmpresa").modal("hide");
                        });
                    }
                    else
                        alertFail(r.titulo, r.mensaje);
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
            alert("Selecciona una Región válida");
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