<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>
<!doctype html>
<html lang="en">

<head>
    <title>Servicios</title>
    <!-- Required meta tags -->
    <?php require_once APP_PUBLIC . "/shared/meta.php"; ?>

</head>
<body>
<?php require_once APP_PUBLIC . "/shared/header.php"; ?>
<!-- WRAPPER -->
<div class="page-wrapper chiller-theme toggled">
    <?php require_once APP_PUBLIC . "/module/shared/left-nav.php"; ?>

    <!-- MAIN -->
    <main class="page-content">
        <div class="container-fluid">

            <h3 class="text-center text-light">SERVICIOS</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Lista de Servicios
                        </div>

                        <div class="card-body">

                            <a href="javascript:void(0)" title="Detalle" class="btn btn-info btn-sm" onclick="abrirModalServicio(1);"><i class="fas fa-eye"></i> Detalle </a>
                            <a href="javascript:void(0)" title="Crear" class="btn btn-info btn-sm" onclick="abrirModalServicio(2);"><i class="far fa-plus-square"></i> Crear </a>
                            <a href="javascript:void(0)" title="Editar" class="btn btn-info btn-sm" onclick="abrirModalServicio(3);"><i class="fas fa-edit"></i> Editar </a>
                            <a href="javascript:void(0)" title="Estado" class="btn btn-info btn-sm" onclick="cambiarEstadoServicio();"><i class="fas fa-toggle-on"></i> Cambiar Estado </a>

                            <!-- <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Ir al carro" class="btn btn-secondary btn-sm" onclick="exportarProductos();"><i class="fas fa-file-export"></i> Exportar </a> -->

                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblProducto" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Código SAP</th>
                                        <th>Código SENCE</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Horas</th>
                                        <th>Objetivo</th>
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

            <!-- MODAL ACTIONS -->
            <div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-labelledby="modalProductoLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-grey">
                            <h6 class="modal-title" id="modalProductoLabel"></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
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
    var tblProducto;
    $(document).ready(function () {

        tblProducto = $('#tblProducto').DataTable({
            "ajax": {
                "url": "<?= CONTROLLERS ?>/cotizacion/producto-y-servicio.php",
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
                {"data": "tipo_cotizacion"},
                {"data": "codigo_sap"},
                {"data": "codigo_sence"},
                {"data": "descripcion"},
                {"data": "precio"},
                {"data": "horas"},
                {"data": "objetivo"}
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        $('#tblProducto tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                tblProducto.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    });

    function abrirModalServicio (ventana) {
        let titulo = "";
        let pagina = "";
        let selected = tblProducto.row('.selected').data();

        if (selected === undefined && ventana != 2) {
            alertFail("Error","Debe seleccionar un registro");
            return false;
        }

        switch (ventana) {
            case 1:
                titulo = "DETALLE PRODUCTO";
                pagina = "inc.detalle-producto.php?id=" + selected.id;
                break;
            case 2:
                titulo = "CREAR PRODUCTO";
                pagina = "inc.editar-producto.php?id=0";
                break;
            case 3:
                titulo = "EDITAR PRODUCTO";
                pagina = "inc.editar-producto.php?id=" + selected.id;
                break;
            default:
                titulo = "DETALLE PRODUCTO";
                pagina = "inc.detalle-producto.php?id=" + selected.id;
                break;
        }

        let modalP = $('#modalProducto');

        modalP.find('.modal-title').text(titulo);
        modalP.find('.modal-body').load(pagina);
        modalP.modal('show');
    }

    function cambiarEstadoServicio () {
        let selected    = tblProducto.row('.selected').data();
        const chkActivo = selected.activo == 1 ? 0 : 1;

        if (selected === undefined) {
            alertFail("Error","Debe seleccionar un registro");
            return false;
        }
        $.ajax({
            url: "<?= CONTROLLERS ?>/cotizacion/producto-y-servicio.php",
            type: "POST",
            data: {
                acc                        : 2,
                type                       : "desable",
                idP                        : selected.id,
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
                console.info(data);
                eval(data);
                alertOk(r.titulo,r.mensaje);
                if (r.resultado == "OK")
                    tblProducto.ajax.reload();
            }
        });
    }

    function exportarProductos () {
        alert("En desarrollo...");
    }

</script>
</body>

</html>
