<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>
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

            <h3 class="text-center text-light">EMPRESAS</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="alert alert-help" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Debes seleccionar una empresa de la lista, para ejecutar alguna acción.
                    </div>


                    <div class="card">
                        <div class="card-header">
                            Empresas y Particulares
                        </div>

                        <div class="card-body">

                            <a href="javascript:void(0)" title="Detalle" class="btn btn-info btn-sm" onclick="abrirModalEmpresa(1);"><i class="fas fa-eye"></i> Detalle </a>
                            
                            <?php if(in_array("2", $_SESSION['PERMISOS'])){ ?>

                            <!--<a href="javascript:void(0)" title="Crear" class="btn btn-info btn-sm" data-title="Crear" onclick="abrirModalEmpresa(2);"><i class="fas fa-plus-square"></i> Crear </a>-->

                            <a href="empresa.php" title="Crear" class="btn btn-info btn-sm" data-title="Crear"><i class="fas fa-plus-square"></i> Crear </a>

                            <?php } 
                            if(in_array("4", $_SESSION['PERMISOS'])){ ?>
                            <a href="javascript:void(0)" title="Editar" class="btn btn-info btn-sm" data-title="Editar" onclick="abrirModalEmpresa(3);"><i class="fas fa-edit"></i> Editar </a>
                            <?php }
                            if(in_array("5", $_SESSION['PERMISOS'])){ ?>
                            <a href="javascript:void(0)" title="Personal" class="btn btn-info btn-sm" data-title="Personal" onclick="abrirModalEmpresa(4,true);"><i class="fas fa-user-tie"></i> Personal </a>
                            <?php }
                            if(in_array("6", $_SESSION['PERMISOS'])){ ?>
                            <a href="javascript:void(0)" title="Contactos" class="btn btn-info btn-sm" data-title="Contactos" onclick="abrirModalEmpresa(5,true);"><i class="fas fa-user-tie"></i> Contactos </a>
                            <?php } ?>
                            <!-- <a href="javascript:void(0)" title="Ventas" class="btn btn-info btn-sm" data-title="Ventas" onclick="abrirModalEmpresa(6);"><i class="fas fa-money-check-alt"></i> Ventas </a> -->
                            <!--<a href="javascript:void(0)" title="Estado" class="btn btn-info btn-sm" onclick="cambiarEstadoEmpresa();"><i class="fas fa-toggle-on"></i> Cambiar Estado </a>-->

                            <!-- <span class="text-muted"> | </span>
                            
                            <a href="javascript:void(0)" title="Ir al carro" class="btn btn-secondary btn-sm" onclick="exportarProductos();"><i class="fas fa-file-export"></i> Exportar </a> -->

                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblcampania" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Rut</th>
                                        <th>Razón Social</th><!-- 
                                        <th>Rut Representante</th> -->
                                        <th>Correo</th>
                                        <th>Región</th>
                                        <th>Comuna</th>
                                        <th>Fecha Creación</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
    $(document).ready(function () {

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
                {"data": "razon_social"},/*
                {"data": "rut_representante"},*/
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
    });

    function abrirModalEmpresa (ventana, personal) {
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
                //pagina = "inc.editar.php?id=0";
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
    }

    function abrirModalEmpresaPersonal (ventana, idP = 0) {
        let titulo = "";
        let pagina = "";
        let selected = tblcampania.row('.selected').data();
        //$("#modalEmpresaPersonal").modal("hide");

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
    }

    function abrirModalEmpresaContacto (ventana, idC = 0) {
        let titulo = "";
        let pagina = "";
        let selected = tblcampania.row('.selected').data();
        //$("#modalEmpresaPersonal").modal("hide");

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
    }

    function cambiarEstadoEmpresa () {
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
    }
</script>
</body>

</html>
