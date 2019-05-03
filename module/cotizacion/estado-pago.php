<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>

<?php
$VerPDFEstPago = in_array("14", $_SESSION['PERMISOS']) ? 1 : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cotización</title>
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

            <h3 class="text-center text-light">ESTADO PAGO</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Lista de Pagos
                        </div>

                        <div class="card-body">
                            <!--
                            <a href="javascript:void(0)" title="Generar PDF" class="btn btn-info btn-sm" onclick="generarEstadoPagoPDF();"><i class="far fa-file-pdf"></i> Generar PDF </a>
                            <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Exportar" class="btn btn-secondary btn-sm" onclick="alert('En desarrollo...');"><i class="fas fa-file-export"></i> Exportar </a>
                            <hr class="line-grey-2">
-->
                            <div class="table-responsive">
                                <table id="tblEstadoPago" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Folio Pago</th>
                                        <th>Folio Cotización</th>
                                        <th>Número Orden</th>
                                        <th>RUT Empresa</th>
                                        <th>Empresa</th>
                                        <th>Contacto</th>
                                        <th>Fecha Creación</th>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
    var tblEstadoPago;
    $(document).ready(function () {

        tblEstadoPago = $('#tblEstadoPago').DataTable({
            "ajax": {
                "url": "<?= CONTROLLERS ?>/cotizacion/cotizacion.php",
                "type": "post",
                "data": {
                    acc: 7,
                }
            },
            "order": [],
            "responsive": true,
            "columns": [
                {"data": "cotpag_id"},
                //{"data": "cot_id"},
                {
                    "data": "cot_id",
                    "render": function(data, type, row){
                        /*if(row.folio_padre != null){
                            return data + '<br><span class="text-muted" style="font-size: 12px;">(Ref: ' + row.folio_padre + ')</span>';
                        }else{*/
                            //return data;
                        //}

                        if(row.cot_folio_padre2 == null || row.cot_folio_padre2 == ""){
                            //return data;
                            //return row.folio_padre3;

                            /*if(){
                            }*/
                            if(row.cot_folio_padre3 == null || row.cot_folio_padre3 == ""){
                                //return row.folio_padre3;
                                return data;
                            }else{
                                //return data;
                                return row.cot_folio_padre3;
                            }
                        }else{
                            return row.cot_folio_padre2;
                            //return row.id;                        
                        }

                    }
                },
                {"data": "cotpag_numero_orden"},
                {"data": "emp_rut"},
                {"data": "emp_razon_social"},
                {"data": "con_nombre"},
                {"data": "cotpag_fecha_creacion"},
                {
                    "data": "acciones",
                    "render": function (data, type, row){

                        let btnPDF = '<?= $VerPDFEstPago; ?>' == 1 ? '<button title="PDF" class="btn btn-info btn-sm btn-pdf"><i class="far fa-file-pdf"></i> Ver PDF </button>' : '';
                        let btnArchivo = '<button title="PDF" class="btn btn-info btn-sm btn-archivo" ' + (row.archivos.length == 0 ? "disabled" : "") + '><i class="fas fa-file-download"></i> Archivos </button>';

                        return '<div style="width: 180px !important; margin: auto;">' + btnPDF + ' ' + btnArchivo + ' </div>';
                    },
                    "className": "text-center"
                }
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        let tblEstadoPagoBody = $('#tblEstadoPago tbody');
        tblEstadoPagoBody.on('click', 'tr td .btn-pdf', function () {
            var tr = $(this).closest('tr');
            var row = tblEstadoPago.row(tr);
            row.child(generarEstadoPagoPDF(row.data()));
        });

        tblEstadoPagoBody.on('click', 'tr td .btn-archivo', function () {
            var tr = $(this).closest('tr');
            var row = tblEstadoPago.row(tr);
            row.child(abrirModalCotizacion(1, row.data()));
        });


    });

    function abrirModalCotizacion (ventana, row) {
        let titulo = "";
        let contenido = "";

        if (row === undefined) {
            alert("Debe seleccionar un registro");
            return false;
        }

        switch (ventana) {
            case 1:
                titulo = "ARCHIVOS - ESTADO PAGO N° " + row.cotpag_id;
                contenido = "";
                $.each(row.archivos, function(ind, val) {
                    contenido += '<li><a href="../../storage/cotizacion_pago/documento/' + val.nombre_codificado + '" download="' + val.nombre_original + '">' + val.nombre_original + '</a></li>';
                });
                break;
            default:
                titulo = "COTIZACIÓN";
                contenido = "";
                break;
        }

        let modalC = $('#modalCotizacion');

        modalC.find('.modal-title').text(titulo);
        modalC.find('.modal-body').html(contenido);
        modalC.modal('show');

    }

    function generarEstadoPagoPDF (row) {
        window.open("cotizacionPagoPDF.php?ficha="+row.cot_id+"&idcotPag="+row.cotpag_id+"&idE="+row.emp_id, "_blank");
    }

</script>
</body>

</html>
