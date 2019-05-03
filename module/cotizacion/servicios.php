<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>

<?php 
$editServ = in_array("17", $_SESSION['PERMISOS']) ? 1 : 0;
?>

<!DOCTYPE html>
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
    
    <?php require_once APP_PUBLIC . "/shared/left-nav.php"; ?>

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
                            <?php 
                            if(in_array("16", $_SESSION['PERMISOS'])){
                            ?>
                            <a href="javascript:void(0)" title="Crear" class="btn btn-info btn-sm" onclick="abrirModalServicio(2);"><i class="far fa-plus-square"></i> Crear </a>
                            <?php 
                            }
                            ?>
                            <!--
                            <a href="javascript:void(0)" title="Detalle" class="btn btn-info btn-sm" onclick="abrirModalServicio(1);"><i class="fas fa-eye"></i> Detalle </a>
                            <a href="javascript:void(0)" title="Editar" class="btn btn-info btn-sm" onclick="abrirModalServicio(3);"><i class="fas fa-edit"></i> Editar </a>

                             <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Ir al carro" class="btn btn-secondary btn-sm" onclick="exportarProductos();"><i class="fas fa-file-export"></i> Exportar </a>
                            -->

                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblProducto" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Tipo</th>
                                        <th>Código SAP</th>
                                        <th>Código SENCE</th>
                                        <th>OT</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Horas</th>
                                        <th>Contenido</th>
                                        <th>Requisito</th>
                                        <th>Objetivo</th>
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
<!-- END WRAPPER --><
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
                "url": "<?= CONTROLLERS ?>/cotizacion/servicio.php",
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
                {"data": "codigo_ot"},
                {"data": "descripcion"},
                {"data": "precio"},
                {"data": "horas"},
                {
                    "data": "contenido",
                    "render": function (data, type, row){
                        let texto = data + "";
                        if (data !== "" && data != null && data.length >= 20) {
                            return texto.substr(0, 20) + '...<br><a href="javascript:void(0)" title="Ver" class="btn-link btn-contenido">Ver Más</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "requisito",
                    "render": function (data, type, row){
                        let texto = data + "";
                        if (data !== "" && data != null && data.length >= 20) {
                            return texto.substr(0, 20) + '...<br><a href="javascript:void(0)" title="Ver" class="btn-link btn-requisito">Ver Más</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "objetivo",
                    "render": function (data, type, row){
                        let texto = data + "";
                        if (data !== "" && data != null && data.length >= 20) {
                            return texto.substr(0, 20) + '...<br><a href="javascript:void(0)" title="Ver" class="btn-link btn-objetivo">Ver Más</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "Seleccionar",
                    "render": function (data, type, row){

                        var eServ = "<?= $editServ; ?>";
                        let btnEditar = '';

                        if(eServ == 1){
                            btnEditar = '<button title="Editar" class="btn btn-info btn-sm btn-editar"><i class="fas fa-edit"></i> Editar </button> ';
                        }

                        let btnDetalle  = '<button title="Detalle" class="btn btn-info btn-sm btn-detalle"><i class="fas fa-eye"></i> Detalle </button> ';
                     

                        return btnDetalle + btnEditar;
                    },
                    "width": "200",
                    "className": "text-center"
                }
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        let tblProductoBody = $('#tblProducto tbody');
        tblProductoBody.on('click', 'tr td .btn-detalle', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalServicio(1, row.data()));
        });

        tblProductoBody.on('click', 'tr td .btn-editar', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalServicio(3, row.data()));
        });

        tblProductoBody.on('click', 'tr td .btn-contenido', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalServicio(4, row.data()));
        });

        tblProductoBody.on('click', 'tr td .btn-requisito', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalServicio(5, row.data()));
        });

        tblProductoBody.on('click', 'tr td .btn-objetivo', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalServicio(6, row.data()));
        });
    });

    function verTextoCompleto (row) {
        alert(row.contenido);
    }


    function abrirModalServicio (ventana, row) {
        let titulo = "";
        let contenido = "";
        let selected = row; //tblProducto.row('.selected').data();

        if (selected === undefined && ventana != 2) {
            alertFail("Error","Debe seleccionar un registro");
            return false;
        }

        switch (ventana) {
            case 1:
                titulo = "DETALLE SERVICIO";
                contenido = "inc.detalle-servicio.php?id=" + selected.id;
                break;
            case 2:
                titulo = "CREAR SERVICIO";
                contenido = "inc.editar-servicio.php?id=0";
                break;
            case 3:
                titulo = "EDITAR SERVICIO";
                contenido = "inc.editar-servicio.php?id=" + selected.id;
                break;
            case 4:
                titulo = "CONTENIDO";
                contenido = row.contenido;
                break;
            case 5:
                titulo = "REQUISITO";
                contenido = row.requisito;
                break;
            case 6:
                titulo = "OBJETIVO";
                contenido = row.objetivo;
                break;
            default:
                titulo = "DETALLE SERVICIO";
                contenido = "inc.detalle-servicio.php?id=" + selected.id;
                break;
        }

        let modalP = $('#modalProducto');
        modalP.find('.modal-title').text(titulo);

        if (ventana === 4 || ventana === 5 || ventana === 6)
            modalP.find('.modal-body').html(contenido);
        else
            modalP.find('.modal-body').load(contenido);


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
            url: "<?= CONTROLLERS ?>/cotizacion/servicio.php",
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
