<?php include_once "../../config/app.php"; ?>
<!doctype html>
<html lang="en">

<head>
    <title>Cotización</title>
    <!-- Required meta tags -->|y
    <?php require_once APP_PUBLIC . "/shared/meta.php"; ?>

</head>
<body>
<!-- WRAPPER -->
<div id="wrapper">
    <?php require_once APP_PUBLIC . "/shared/header.php"; ?>

    <?php require_once APP_PUBLIC . "/module/shared/left-nav.php"; ?>
    <!-- MAIN -->

    <main class="page-content">
        <div class="container-fluid">
            <h2>Sidebar template</h2>
            <hr>
            <div class="row">
                <div class="form-group col-md-12">
                    <p>This is a responsive sidebar template with dropdown menu based on bootstrap 4 framework.</p>
                    <p> You can find the complete code on <a href="https://github.com/azouaoui-med/pro-sidebar-template" target="_blank">
                            Github</a>, it contains more themes and background image option</p>
                </div>
                <div class="form-group col-md-12">
                    <iframe src="https://ghbtns.com/github-btn.html?user=azouaoui-med&amp;repo=pro-sidebar-template&amp;type=star&amp;count=true&amp;size=large" frameborder="0" scrolling="0" width="140px" height="30px"></iframe>
                    <iframe src="https://ghbtns.com/github-btn.html?user=azouaoui-med&amp;repo=pro-sidebar-template&amp;type=fork&amp;count=true&amp;size=large" frameborder="0" scrolling="0" width="140px" height="30px"></iframe>
                </div>
            </div>
            <h5>More templates</h5>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h6>Angular 2+ Version</h6>
                    <div style="width:13rem;">
                        <a href="https://github.com/azouaoui-med/angular-pro-sidebar" target="_blank" class="alert-link">
                            <img class="card-img-top" src="https://user-images.githubusercontent.com/25878302/50010090-d193f480-ffb8-11e8-98ef-3d7ffa6ddfe1.png" alt="Card image cap">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- END MAIN -->
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
    $(document).ready(function () {

        tblcampania = $('#tblcampania').DataTable({

            /*"ajax": {

                "url": "controller/campania_ajax.php",

                "type": "post",

                "data": {

                    acc: 1,

                }

            },*/

            "order": [],

            "responsive": true,


            "columns": [

                //{ "data": "activo"},

                {"data": "codigo"},

                {"data": "rut"},

                {"data": "nombre"},

                {"data": "email"},

                // {"data": "mensaje"},

                {"data": "Accion"}

    ],
        "dom"
    :
        'Hfrtip',

            "buttons"
    :
        [

            'excel'

        ],

            "pageLength"
    :
        50,
            "lengthMenu"
    :
        [50, 100, 200, 300],
            "language"
    :
        {

            "sProcessing"
        :
            "Procesando...",

                "sLengthMenu"
        :
            "Mostrar _MENU_ registros",

                "sZeroRecords"
        :
            "No se encontraron resultados",

                "sEmptyTable"
        :
            "Ningún dato disponible en esta tabla",

                "sInfo"
        :
            "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty"
        :
            "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered"
        :
            "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix"
        :
            "",

                "sSearch"
        :
            "Buscar:",

                "sUrl"
        :
            "",

                "sInfoThousands"
        :
            ",",

                "sLoadingRecords"
        :
            "Cargando...",

                "oPaginate"
        :
            {

                "sFirst"
            :
                "Primero",

                    "sLast"
            :
                "Último",

                    "sNext"
            :
                "Siguiente",

                    "sPrevious"
            :
                "Anterior"

            }
        ,

            "oAria"
        :
            {

                "sSortAscending"
            :
                ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending"
            :
                ": Activar para ordenar la columna de manera descendente"

            }

        }

    })
        ;
    });

</script>
</body>

</html>
