<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>
<!doctype html>
<html lang="en">

<head>
    <title>Sede</title>
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

            <h3 class="text-center text-light">SEDES</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Listado de Sedes
                        </div>

                        <div class="card-body">
                            <a href="javascript:void(0)" title="Crear" class="btn btn-info btn-sm" data-title="Crear" onclick="abrirModalSede(2);"><i class="fas fa-plus-square"></i> Crear </a>

                            <!--<span class="text-muted"> | </span>-->
                            <!--<a href="javascript:void(0)" title="Ir al carro" class="btn btn-secondary btn-sm" onclick="exportarProductos();"><i class="fas fa-file-export"></i> Exportar </a>-->

                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblSede" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Descripción</th>
                                        <th>Dirección</th>
                                        <th>Encargado</th>
                                        <th>Acciones</th>
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
            <div class="modal fade" id="modalSede" tabindex="-1" role="dialog" aria-labelledby="modalEmpresaLabel" aria-hidden="true">
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
    var tblSede;
    $(document).ready(function () {

        tblSede = $('#tblSede').DataTable({
            "ajax": {
                "url": "<?= CONTROLLERS ?>/sede.php",
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
                {"data": "descripcion"},
                {"data": "direccion"},
                {"data": "encargado"},
                {
                    "data": "Seleccionar",
                    "render": function (data, type, row){

                        let btnDetalle = '<button title="Detalle" class="btn btn-info btn-sm btn-detalle"><i class="fas fa-eye"></i> Detalle </button> ';
                        let btnEditar = '<button title="Editar" class="btn btn-info btn-sm btn-editar"><i class="fas fa-edit"></i> Editar </button> ';

                        return btnDetalle + btnEditar;
                    },
                    "width": "140",
                    "className": "text-center"
                },

            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        let tblSedeBody = $('#tblSede tbody');
        tblSedeBody.on('click', 'tr td .btn-detalle', function () {
            var tr = $(this).closest('tr');
            var row = tblSede.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child(abrirModalSede(1, row.data()));
                tr.addClass('shown');
            }
        });

        tblSedeBody.on('click', 'tr td .btn-editar', function () {
            var tr = $(this).closest('tr');
            var row = tblSede.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child(abrirModalSede(3, row.data()));
                tr.addClass('shown');
            }
        });
    });

    function abrirModalSede (ventana, row) {
        let titulo = "";
        let pagina = "";
        let selected = row;

        if (selected === undefined && ventana != 2) {
            alert("Debe seleccionar un registro");
            return false;
        }

        switch (ventana) {
            case 1:
                titulo = "DETALLE SEDE";
                pagina = "inc.detalle.php?id=" + selected.id;
                break;
            case 2:
                titulo = "CREAR SEDE";
                pagina = "inc.editar.php?id=0";
                break;
            case 3:
                titulo = "EDITAR SEDE";
                pagina = "inc.editar.php?id=" + selected.id;
                break;
        }

        let modalE = $('#modalSede');

        modalE.find('.modal-title').text(titulo);
        modalE.find('.modal-body').load(pagina);
        modalE.modal('show');
    }

    function exportarProductos () {
        alert("En desarrollo...");
    }
</script>
</body>

</html>
