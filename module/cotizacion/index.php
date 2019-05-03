<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>

<?php 
$VerPDFCot = in_array("12", $_SESSION['PERMISOS']) ? 1 : 0;
$crearEstPago = in_array("10", $_SESSION['PERMISOS']) ? 1 : 0;
$editCot = in_array("11", $_SESSION['PERMISOS']) ? 1 : 0;
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

            <h3 class="text-center text-light">COTIZACIONES</h3>
            <br>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Lista de Cotizaciones
                        </div>

                        <div class="card-body">
                            <?php if(in_array("9", $_SESSION['PERMISOS'])){ ?>
                            <a href="cotizacion.php" title="Crear Cotización" class="btn btn-info btn-sm"><i class="far fa-file-pdf"></i> Crear Cotización </a>
                            <?php } ?>
                            <!--
                            <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Exportar excel" class="btn btn-secondary btn-sm" onclick="alert('en desarrollo...');"><i class="fas fa-file-export"></i> Exportar </a>
                            -->
                            <hr class="line-grey-2">

                            <div class="table-responsive">
                                <table id="tblCotizacion" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <!--<th>Seguimiento</th>-->
                                        <th>Referencia</th>
                                        <th>Estado Pago</th>
                                        <th>Rut</th>
                                        <th>Razón Social</th>
                                        <th>Emisor</th>
                                        <th>Contacto</th>
                                        <th>Email</th>
                                        <th>Fecha</th>
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
                        <!--<input type="text" id="idE" value="">-->
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
    var tblCotizacion;
    $(document).ready(function () {

        tblCotizacion = $('#tblCotizacion').DataTable({
            "ajax": {
                "url": "<?= CONTROLLERS ?>/cotizacion/cotizacion.php",
                "type": "post",
                "data": {
                    acc: 1,
                }
            },
            "order": [],
            "responsive": true,
            "columns": [
                {
                    "data": "id",
                    "render": function(data, type, row){
                        /*if(row.folio_padre != null){
                            return data + '<br><span class="text-muted" style="font-size: 12px;">(Ref: ' + row.folio_padre + ')</span>';
                        }else{*/
                            //return data;
                        //}

                        if(row.folio_padre2 == null || row.folio_padre2 == ""){
                            //return data;
                            //return row.folio_padre3;

                            /*if(){
                            }*/
                            if(row.folio_padre3 == null || row.folio_padre3 == ""){
                                //return row.folio_padre3;
                                if(row.existeReferencia  !== 1){
                                    return '<div align="center"><span class="badge badge-success">N° '+data+'</span></div>';
                                }else{
                                    return '<div align="center">'+data+'</div>';
                                }
                            }else{
                                //return data;
                                //return row.folio_padre3;

                                if(row.existeReferencia  !== 1){
                                    return '<div align="center"><span class="badge badge-success">N° '+row.folio_padre3+'</span></div>';
                                }else{
                                    return '<div align="center">'+row.folio_padre3+'</div>';
                                }
                            }
                        }else{
                            //return row.folio_padre2;
                            //return row.id;

                            if(row.existeReferencia  !== 1){
                                return '<div align="center"><span class="badge badge-success">N° '+row.folio_padre2+'</span></div>';
                            }else{
                                return '<div align="center">'+row.folio_padre2+'</div>';
                            }                        
                        }

                    }
                },
                //{"data": "folio_padre2"},
                {"data": "tipo_cotizacion"},
                {
                    "data": "cant_estpag",
                    "render": function(data, type, row){
                        if(data > 0){
                            return '<div align="center"><span class="badge badge-success">N° '+row.cant_estpag+'</span></div>';
                        }else{
                            return '';
                            //return '<span class="badge badge-danger">No Generado</span>';
                        }
                    }
                },
                {"data": "rut_empresa"},
                {"data": "razon_social"},
                {"data": "nombre"},
                {"data": "contacto"},
                //{"data": "usuario_id"},
                {"data": "email_empresa"},
                {"data": "fecha_creacion"},
                {
                    "data": "acciones",
                    "render": function (data, type, row){

                        var verPDFCot = "<?= $VerPDFCot; ?>";
                        var createEstPago = "<?= $crearEstPago; ?>";
                        var editCot = "<?= $editCot; ?>";

                        let btnEditar = '';
                        let btnPDF = '';
                        let btnEstadoPago = '';

                        if(editCot == 1){

                        //DESCOMENTAR ?

                        //btnEditar = '<button title="Editar" class="btn btn-info btn-sm btn-editar" ' + (row.existeReferencia  === 1 ?  "disabled" : "") + '>' +
                        //'<i class="fas fa-edit"></i> Editar </button> ';

                            if(row.cant_estpag > 0){
                                btnEditar = '<button title="Editar" class="btn btn-info btn-sm btn-editar" disabled>' +
                                '<i class="fas fa-edit"></i> Editar </button> ';
                            }else{
                                btnEditar = '<button title="Editar" class="btn btn-info btn-sm btn-editar" ' + (row.existeReferencia  === 1 ?  "disabled" : "") + '>' +
                                '<i class="fas fa-edit"></i> Editar </button> ';
                            }
                        }

                        if(verPDFCot == 1){
                            btnPDF = '<button title="PDF" class="btn btn-info btn-sm btn-pdf"><i class="far fa-file-pdf"></i> Ver PDF </button> ';
                        }

                        if(row.cant_estpag > 0){

                        }else{

                        }

                        if(createEstPago == 1){

                            if(row.cant_estpag > 0){

                                 btnEstadoPago = '<button title="Estado Pago" class="btn btn-info btn-sm btn-estado-pago" disabled>' +
                                '<i class="far fa-file-alt"></i> Crear Estado Pago </button> ';

                            }else{

                                btnEstadoPago = '<button title="Estado Pago" class="btn btn-info btn-sm btn-estado-pago" ' + (row.existeReferencia  === 1 ?  "disabled" : "") + '>' +
                                '<i class="far fa-file-alt"></i> Crear Estado Pago </button> ';

                            }
                        }

                        return '<div style="width: 300px !important; margin: auto;">' + btnEditar + btnPDF + btnEstadoPago +'</div>';
                    },
                    //"width": "240",
                    "className": "text-center"
                }
            ],
            "dom": 'Hfrtip',
            "buttons": [ 'excel' ],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        let tblCotizacionBody = $('#tblCotizacion tbody');
        tblCotizacionBody.on('click', 'tr td .btn-pdf', function () {
            var tr = $(this).closest('tr');
            var row = tblCotizacion.row(tr);

            row.child(generarCotizacionPDF(row.data()));
        });

        tblCotizacionBody.on('click', 'tr td .btn-estado-pago', function () {
            var tr = $(this).closest('tr');
            var row = tblCotizacion.row(tr);

            row.child(abrirModalCotizacion(1, row.data()));
        });

        tblCotizacionBody.on('click', 'tr td .btn-editar', function () {
            var tr = $(this).closest('tr');
            var row = tblCotizacion.row(tr);
            row = row.data();
            window.open('cotizacion-editar.php?folio=' + row.folio_enc, '_self');
        });

    });

    function generarCotizacionPDF (row) {

        if (row === undefined) {
            alert("Debe seleccionar un registro");
            return false;
        }

        window.open("cotizacionPDF.php?ficha=" + row.id);
    }

    function abrirModalCotizacion (ventana, row) {
        let titulo = "";
        let pagina = "";

        if (row === undefined) {
            alert("Debe seleccionar un registro");
            return false;
        }

        if(row.cant_estpag > 0){
            alertFail("Error", "La cotización tiene el estado pago generado");
            return false;
        }
        
        switch (ventana) {
            case 1:
                titulo = "INGRESAR ESTADO PAGO - COTIZACIÓN N° " + row.id;
                pagina = "inc.estado-pago.php?id=" + row.id + "&idu=<?= $_SESSION['USUARIO_ID']; ?>&idE=" + row.empresa_id + "&ids=" + row.sede_id + "&idC=" + row.id;
                break;
            default:
                titulo = "COTIZACIÓN";
                pagina = "";
                break;
        }

        let modalC = $('#modalCotizacion');

        modalC.find('.modal-title').text(titulo);
        modalC.find('.modal-body').load(pagina);
        modalC.modal('show');
    }

</script>
</body>

</html>
