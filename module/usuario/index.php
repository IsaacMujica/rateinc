<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>
<!doctype html>
<html lang="en">

<head>
    <title>Usuario - Administración</title>
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

            <h3 class="text-center text-light">USUARIOS</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Listado de Usuarios
                        </div>

                        <div class="card-body">

                            <a href="javascript:void(0)" title="Crear" class="btn btn-info btn-sm" data-title="Crear" onclick="abrirModalUsuario(2);"><i class="fas fa-plus-square"></i> Crear </a>
                            <!--
                            <a href="javascript:void(0)" title="Detalle" class="btn btn-info btn-sm" onclick="abrirModalUsuario(1);"><i class="fas fa-eye"></i> Detalle </a>
                            <a href="javascript:void(0)" title="Editar" class="btn btn-info btn-sm" data-title="Editar" onclick="abrirModalUsuario(3);"><i class="fas fa-edit"></i> Editar </a>
                            <a href="javascript:void(0)" title="Permiso" class="btn btn-info btn-sm" data-title="Permiso" onclick="abrirModalUsuario(4);"><i class="fas fa-edit"></i> Permisos </a>
                            <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Ir al carro" class="btn btn-secondary btn-sm" onclick="exportarProductos();"><i class="fas fa-file-export"></i> Exportar </a>
                            -->

                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblUsuario" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Rut</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Profesión</th>
                                        <th>Sede</th>
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
            <div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modalUsuarioLabel"></h6>
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
    var tblUsuario;
    $(document).ready(function () {

        tblUsuario = $('#tblUsuario').DataTable({
            "ajax": {
                "url": "<?= CONTROLLERS ?>/usuario.php",
                "type": "post",
                "data": {
                    acc: 1,
                },
                /*
                "success": function (data) {
                    console.info(data);
                }*/
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
                {"data": "nombre_completo"},
                {"data": "email"},
                {"data": "profesion"},
                {"data": "sede"},
                {
                    "data": "Seleccionar",
                    "render": function (data, type, row){

                        let btnDetalle  = '<button title="Detalle" class="btn btn-info btn-sm btn-detalle"><i class="fas fa-eye"></i> Detalle </button> ';
                        let btnEditar   = '<button title="Editar" class="btn btn-info btn-sm btn-editar"><i class="fas fa-edit"></i> Editar </button> ';
                        let btnPermiso  = '<button title="Permiso" class="btn btn-info btn-sm btn-permiso"><i class="fas fa-edit"></i> Permiso </button> ';

                        return btnDetalle + btnEditar + btnPermiso;
                    },
                    "width": "300",
                    "className": "text-center"
                }
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        let tblUsuarioBody = $('#tblUsuario tbody');
        tblUsuarioBody.on('click', 'tr td .btn-detalle', function () {
            var tr = $(this).closest('tr');
            var row = tblUsuario.row(tr);
            row.child(abrirModalUsuario(1, row.data()));
        });

        tblUsuarioBody.on('click', 'tr td .btn-editar', function () {
            var tr = $(this).closest('tr');
            var row = tblUsuario.row(tr);
            row.child(abrirModalUsuario(3, row.data()));
        });

        tblUsuarioBody.on('click', 'tr td .btn-permiso', function () {
            var tr = $(this).closest('tr');
            var row = tblUsuario.row(tr);
            row.child(abrirModalUsuario(4, row.data()));
        });

    });

    function abrirModalUsuario (ventana, row) {
        let titulo = "";
        let pagina = "";
        let selected = row; //tblUsuario.row('.selected').data();

        if (selected === undefined && ventana != 2) {
            alertFail("Error","Debe seleccionar un registro");
            return false;
        }

        switch (ventana) {
            case 1:
                titulo = "DETALLE USUARIO";
                pagina = "inc.detalle.php?id=" + selected.id;
                break;
            case 2:
                titulo = "CREAR USUARIO";
                pagina = "inc.editar.php?id=0";
                break;
            case 3:
                titulo = "EDITAR USUARIO";
                pagina = "inc.editar.php?id=" + selected.id;
                break;
            case 4:
                titulo = "PERMISOS DE USUARIO";
                pagina = "inc.permiso.php?id=" + selected.id;
                break;
            default:
                titulo = "DETALLE USUARIO";
                pagina = "inc.detalle.php?id=" + selected.id;
                break;
        }

        let modalU = $('#modalUsuario');

        modalU.find('.modal-title').text(titulo);
        modalU.find('.modal-body').load(pagina);
        modalU.modal('show');
    }

    function exportarProductos () {
        alert("En desarrollo...");
    }
</script>
</body>

</html>
