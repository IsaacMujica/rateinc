<?php 
include_once "../../config/app.php"; 
include_once "../../config/session.php";
require_once "../../app/Empresa.php";
require_once "../../app/Localidad.php";
require_once "../../app/Sede.php";

//EMPRESA
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


//CONTACTO
$sedes = new Sede();
$sedeusuario = $sedes->getListaSedes();

?>

<!doctype html>
<html lang="en">

<head>
    <title>Empresa</title>
    <!-- Required meta tags -->
    <?php require_once APP_PUBLIC . "/shared/meta.php"; ?>

</head>
<body>
<?php require_once APP_PUBLIC . "/shared/header.php"; ?>
<!-- WRAPPER -->
<div class="page-wrapper chiller-theme toggled">

    <?php require_once APP_PUBLIC . "/shared/left-nav.php"; ?>

    <!-- MAIN -->
    <main class="page-content">
        <div class="container-fluid">

            <h3 class="text-center text-light">GESTIÓN EMPRESA</h3>
            <br>

            <div class="row">

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Empresa
                        </div>
                        <div class="card-body">
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
                            </form> 
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Personal y Contacto
                        </div>
                        <div class="card-body">
                            <form id="formPersonal" autocomplete="off" method="post">
                                <label for="tablaPers">Personal</label>
                                <table class="table" id="tablaPers">
                                    <tr>
                                        <td>
                                            <label for="cmbTipoPersonal">Tipo</label>
                                            <div id="SecctipoPersonal">
                                            <select id="cmbTipoPersonal" class="form-control" name="cmbTipoPersonal[]">
                                                <option value="" selected="">Seleccione</option>
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
                                            <input type="text" class="form-control" id="txtNombre" value="" name="txtNombre[]">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="txtEmail">Email</label>
                                            <div id="SecctxtEmail">
                                            <input type="email" class="form-control" id="txtEmail" value="" name="txtEmail[]">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="txtTelefono">Teléfono</label>
                                            <div id="SecctxtTelefono">
                                            <input type="text" class="form-control" id="txtTelefono" value="" name="txtTelefono[]">
                                            </div>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>
                                <div align="center">
                                    <button type="button" class="btn btn-info btn-sm" id="agregar_item_personal">
                                        <span>Agregar</span>
                                    </button>
                                </div>
                            </form>

                            <form id="formContacto" autocomplete="off" method="post">
                                <label for="tablaPers">Contacto</label>
                                <table class="table" id="tablaContacto">
                                    <tr>
                                        <td>
                                            <label for="txtNombreC">Nombre</label>
                                            <div id="SeccNombreC">
                                                <input type="text" class="form-control" id="txtNombreC" value="" name="txtNombreC[]">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="txtCargoC">Cargo</label>
                                            <div id="SeccCargoC">
                                                <input type="text" class="form-control" id="txtCargoC" value="" name="txtCargoC[]">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="selectSedeC">Sede</label>
                                            <div id="SeccSedeC">
                                                <select class="form-control" id="selectSedeC" name="selectSedeC[]">
                                                    <option value="0">Seleccione</option>
                                                    <?php 
                                                        foreach ($sedeusuario as $clave => $valor) {
                                                            echo "<option value='".$valor->id_sede."' ".$selected.">".$valor->descripcion."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <label for="txtEmailC">Email</label>
                                            <div id="SecctxtEmailC">
                                                 <input type="email" class="form-control" id="txtEmailC" value="" name="txtEmailC[]">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="txtTelefonoC">Teléfono</label>
                                            <div id="SecctxtTelefonoC">
                                                <input type="text" class="form-control" id="txtTelefonoC" value="" name="txtTelefonoC[]">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="txtCelularC">Celular</label>
                                            <div id="SecctxtCeluC">
                                                <input type="text" class="form-control" id="txtCelularC" value="" name="txtCelularC[]">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div align="center">
                                    <button type="button" class="btn btn-info btn-sm" id="agregar_item_contacto">
                                        <span>Agregar</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div align="center" class="secc_guardaremp">
                        <div class="card">
                            <div class="card-body">
                                 <div class="form-group text-center">
                                    <button type="button" class="btn btn-info btn-sm" id="btnGuardar">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MODAL ACTIONS PERSONAL -->
            <div class="modal fade" id="modalEmpresaPersonal" tabindex="-1" role="dialog" aria-labelledby="modalEmpresaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modalEmpresaPersonalLabel"></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>

            <!-- MODAL ACTIONS PERSONAL -->

            <!-- MODAL ACTIONS -->
            <div class="modal fade modalEmpresa" id="modalEmpresa" tabindex="-1" role="dialog" aria-labelledby="modalEmpresaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modalEmpresaLabel"></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                        <!--
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
                        -->
                    </div>
                </div>
            </div>
            <!-- END MODAL ACTIONS -->
        </div>
    </main>
    <div class="clearfix"></div>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<?php require_once APP_PUBLIC . "/shared/js.php"; ?>
<!-- Optional JavaScript -->
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" type="text/javascript"></script>
<script>
    var tblcampania;
    /*$(document).ready(function () {

        $("#modalEmpresa").on('hide.bs.modal', function () {
            setTimeout(function(){
                $('#modalEmpresa .modal-dialog').removeClass("modal-xl");
            }, 500);
        });

        tblcampania = $('#tblcampania').DataTable({
            "ajax": {
                "url": "<?= CONTROLLERS ?>/empresa.php",
                "type": "post",
                "data": {
                    acc: 1,
                }
            },
            "order": [],
            "responsive": true,
            "columns": [
                {
                    "data": "activo",
                    "render": function (data, type, row){
                        if (data === "1") {
                            return '<span class="badge badge-success">Activo</span>';
                        } else {
                            return '<span class="badge badge-danger">Inactivo</span>';
                        }
                    }
                },
                {"data": "rut"},
                {"data": "razon_social"},
                {"data": "email"},
                {"data": "region"},
                {"data": "comuna"},
                {"data": "fecha_creacion"}
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        $('#tblcampania tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                tblcampania.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    });*/

    /*function abrirModalEmpresa (ventana, personal) {
        let titulo = "";
        let pagina = "";
        var selected = tblcampania.row('.selected').data();

        if (selected === undefined && ventana != 2 && ventana != 8) {
            alertFail("Error","Debes seleccionar un registro");
            return false;
        }

        switch (ventana) {
            case 1:
                titulo = "DETALLE EMPRESA";
                pagina = "inc.detalle.php?id=" + selected.id;
                break;
            case 2:
                titulo = "CREAR EMPRESA";
                pagina = "inc.crear.php?id=0";
                break;
            case 3:
                titulo = "EDITAR EMPRESA";
                pagina = "inc.editar.php?id=" + selected.id;
                break;
            case 4:
                titulo = "INFORMACIÓN DE PERSONAL";
                pagina = "inc.detalle-personal.php?id=" + selected.id + "&idU=<?= $_SESSION['USUARIO_ID']; ?>";
                break;
            case 5:
                titulo = "INFORMACIÓN DE CONTACTOS";
                pagina = "inc.detalle-contacto.php?id=" + selected.id + "&idU=<?= $_SESSION['USUARIO_ID']; ?>";
                break;
            case 6:
                titulo = "INFORMACIÓN DE VENTAS";
                pagina = "inc.venta.php?id=" + selected.id;
                break;
            case 7:
                titulo = "EDITAR CONTACTOS";
                pagina = "inc.editar-contactos.php?id=" + selected.id + "&idU=<?= $_SESSION['USUARIO_ID']; ?>";
                break;
            default:
                titulo = "DETALLE EMPRESA";
                pagina = "inc.detalle.php?id=" + selected.id;
                break;
        }

        let modalE = $('#modalEmpresa');

        if (personal) modalE = $('#modalEmpresaPersonal');

        modalE.find('.modal-title').text(titulo);
        modalE.find('.modal-body').load(pagina);
        modalE.modal('show');
    }*/

    /*function abrirModalEmpresaPersonal (ventana, idP = 0) {
        let titulo = "";
        let pagina = "";
        let selected = tblcampania.row('.selected').data();

        if (idP === undefined && ventana != 1) {
            alertFail("Error","Debes seleccionar un registro");
            return false;
        }
        titulo = "CREAR PERSONAL";
        pagina = "inc.editar-personal.php?id=" + selected.id + "&idP=" + idP + "&idU=<?= $_SESSION['USUARIO_ID']; ?>";

        if (ventana == 2)
            titulo = "EDITAR PERSONAL";

        let modalE = $('#modalEmpresa');

        modalE.find('.modal-title').text(titulo);
        modalE.find('.modal-body').load(pagina);
        modalE.modal('show');
    }*/

    /*function abrirModalEmpresaContacto (ventana, idC = 0) {
        let titulo = "";
        let pagina = "";
        let selected = tblcampania.row('.selected').data();

        if (idC === undefined && ventana != 1) {
            alertFail("Error","Debes seleccionar un registro");
            return false;
        }
        titulo = "CREAR CONTACTO";
        pagina = "inc.editar-contacto.php?id=" + selected.id + "&idC=" + idC + "&idU=<?= $_SESSION['USUARIO_ID']; ?>";

        if (ventana == 2)
            titulo = "EDITAR CONTACTO";

        let modalE = $('#modalEmpresa');
        modalE.find('.modal-title').text(titulo);
        modalE.find('.modal-body').load(pagina);
        modalE.modal('show');
    }*/

    /*function cambiarEstadoEmpresa () {
        let selected    = tblcampania.row('.selected').data();
        const chkActivo = selected.activo == 1 ? 0 : 1;

        if (selected === undefined) {
            alertOk("Error", "Debe seleccionar un registro");
            return false;
        }
        $.ajax({
            url: "<?= CONTROLLERS ?>/empresa.php",
            type: "POST",
            data: {
                acc                        : 2,
                type                       : "desable",
                idE                        : selected.id,
                chkActivo                  : chkActivo
            },
            error: function (e) {
                $("#btnGuardar").prop("disabled", false);
                console.info(e);
            },
            beforeSend: function () {
                $("#btnGuardar").prop("disabled", true);
            },
            success: function (data) {
                $("#btnGuardar").prop("disabled", false);
                eval(data);

                if (r.resultado == "OK") {
                    tblcampania.ajax.reload();
                    alertOk(r.titulo,r.mensaje);
                }
                else
                    alertFail(r.titulo,r.mensaje);
            }
        });
    }

    function exportarProductos () {
        alert("En desarrollo...");
    }*/

    contPerso = 0;
    contConta = 0;

    successEmpresa = 0;
    successPersonal = 0;
    successContacto = 0;

    $(document).ready(function() {
        $("#txtRut").Rut({
            format_on: 'keyup'
        });

        $('#modalEmpresa .modal-dialog').addClass("modal-xl");


        $("#agregar_item_personal").on("click", function(){

            contPerso++;

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

            if(contPerso >= 4){
                $("#agregar_item_personal").prop("disabled", true);
            }else{
                $("#tablaPers").append(contenido);
            }
        });

        //AGREGANDO ITEMS CONTACTO
        $("#agregar_item_contacto").on("click", function(){

            contConta++;

            var nombre_contacto = $("#SeccNombreC").html();
            var cargo_contacto = $("#SeccCargoC").html();
            var sede_contacto = $("#SeccSedeC").html();
            var email_contacto = $("#SecctxtEmailC").html();
            var fono_contacto = $("#SecctxtTelefonoC").html();
            var celu_contacto = $("#SecctxtCeluC").html();

            contenido = "";
            contenido += "<tr>";
            contenido += "<td>"+nombre_contacto+"</td>";
            contenido += "<td>"+cargo_contacto+"</td>";
            contenido += "<td>"+sede_contacto+"</td>";
            contenido += "<td>"+email_contacto+"</td>";
            contenido += "<td>"+fono_contacto+"</td>";
            contenido += "<td>"+celu_contacto+"</td>";
            contenido += "</tr>";

            if(contConta >= 4){
                $("#agregar_item_contacto").prop("disabled", true);
            }else{
                $("#tablaContacto").append(contenido);
            }
        });



        /*$.validator.addMethod('rut', function (value, element) { 
        return $.Rut.validar(value) 
        }, 'El RUT debe ser válido');*/ 

        


        //VALIDANDO PERSONAL
        $("#formPersonal").validate({
            ignore: [],
            debug: true,
            rules: {                
                "cmbTipoPersonal[]": {
                    required: true
                },
                "txtNombre[]": {
                    required: true,
                    minlength: 3
                },
                "txtEmail[]": {
                    required: true,
                    email: true
                },
                "txtTelefono[]": {
                    digits: true,
                    minlength: 9
                }
            },
            messages: {
                "cmbTipoPersonal[]": {
                    required: "Debe seleccionar un tipo de personal válido"
                },
                "txtNombre[]": {
                    required: "Debe ingresar su Nombre",
                    minlength: "El Nombre debe tener mínimo 3 letras"
                },
                "txtEmail[]": {
                    required: "Debe ingresar un correo",
                    email: "El Correo debe contener el siguiente formato nombre@dominio.cl"
                },
                "txtTelefono[]": {
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
                //var formPerso = $("#formPersonal").serialize();
                successPersonal = 1;
            }
        });

        //VALIDANDO CONTACTO
        $("#formContacto").validate({
            debug: true,
            rules: {
                "txtNombreC[]": {
                    required: true,
                    minlength: 3
                },
                "selectSedeC[]": {
                    required: true,
                    min: 1
                },
                "txtEmailC[]": {
                    required: true,
                    email: true
                },
                "txtTelefonoC[]": {
                    digits: true,
                    minlength: 9
                },
                "txtCelularC[]": {
                    digits: true,
                    minlength: 9
                }
            },
            messages: {
                "txtNombreC[]": {
                    required: "Debe ingresar su Nombre",
                    minlength: "El Nombre debe tener mínimo 3 letras"
                },
                "selectSedeC[]": {
                    required: "Debe ingresar una sede.",
                    min: "Debe seleccionar una sede válida"
                },
                "txtEmailC[]": {
                    required: "Debe ingresar un correo",
                    email: "El Correo debe contener el siguiente formato nombre@dominio.cl"
                },
                "txtTelefonoC[]": {
                    digits: "El Teléfono sólo puede contener dígitos",
                    minlength: "El Teléfono debe tener 9 dígitos, recuerde agregar el 2 o el 9 según corresponda"
                },
                "txtCelularC[]": {
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

                //var formContac = $("#formContacto").serialize();

                successContacto = 1;
            }
        });

        //VALIDANDO EMPRESA
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

                //var formEmpre = $("#formEmpresa").serialize();
                //const fPersonal = $("#formPersonal").serialize()
                successEmpresa = 1;

                //console.log(successEmpresa+" "+successContacto+" "+successPersonal);

            }
        });

        /*if(successEmpresa == 1 && successContacto == 1 && success == 1){

        }*/

        $("#btnGuardar").on("click", function(){

            //console.log("asdsa");

            var formEmpre = $("#formEmpresa").serialize();
            var formContac = $("#formContacto").serialize();
            var formPerso = $("#formPersonal").serialize();

            $("#formEmpresa").submit();
            $("#formPersonal").submit();
            $("#formContacto").submit();

            console.log(successEmpresa+" "+successContacto+" "+successPersonal);

            if(successEmpresa != 1 || successContacto != 1 || successPersonal != 1){

            }else{

                $.ajax({
                    url: "<?= CONTROLLERS ?>/empresa.php",
                    type: "POST",
                    data: "acc=2&type=<?= $id == 0 ? 'create' : 'edit'; ?>&idE=<?= $id; ?>&"+formEmpre
                    + "&idU=<?= $_SESSION['USUARIO_ID'] ?>"
                    + "&" + formContac
                    + "&" + formPerso,
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
                                //tblcampania.ajax.reload();
                                //$("#modalEmpresa").modal("hide");
                                location.href = "../empresa";

                            });


                        }
                        else{
                            alertFail(r.titulo, r.mensaje);
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
</body>

</html>
