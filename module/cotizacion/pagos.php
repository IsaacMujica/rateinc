<?php include_once "../../config/app.php"; ?>
<!doctype html>
<html lang="en">

<head>
    <title>Pagos</title>
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

            <h3 class="text-center text-light">PAGOS</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Pagos
                        </div>

                        <div class="card-body">

                            <a href="javascript:void(0)" title="Detalle" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalCotizacion" data-title="Detalle" onclick="verDetalle();"><i class="fas fa-eye"></i> Crear Cotización </a>
                            <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Ir al carro" class="btn btn-secondary btn-sm" onclick="verDetalle();"><i class="fas fa-file-export"></i> Exportar </a>

                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblEmpresa" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Rut</th>
                                        <th>Razón Social</th>
                                        <th>Región</th>
                                        <th>Comuna</th>
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
            <div class="modal fade" id="modalCotizacion" tabindex="-1" role="dialog" aria-labelledby="modalCotizacionLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCotizacionLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
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
    var tblEmpresa;
    $(document).ready(function () {

        tblEmpresa = $('#tblEmpresa').DataTable({
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
                {"data": "region"},
                {"data": "comuna"}
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        $('#tblEmpresa tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                tblEmpresa.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        /* Modals */
        $('#modalCotizacion').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient = button.data('title'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-title').text('' + recipient);
            modal.find('.modal-body').val(recipient);
        });

    });

    function abrirModalCotizacion () {

    }

    function verDetalle () {
        var selected = tblEmpresa.row('.selected').data();

        if (selected !== undefined) {
            alert("Registro seleccionado -> " + selected.razon_social);
        }  else {
            alert("Debe seleccionar un registro");
        }
    }

</script>
</body>

</html>
