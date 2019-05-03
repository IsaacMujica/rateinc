<?php include_once "../../config/app.php"; ?>
<?php include_once "../../config/session.php"; ?>
<?php include_once "../../app/Sede.php"; ?>

<?php
$idCotizacion = $_GET['id'];

$sede = new Sede();
$listSede = $sede->getListaSedes();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Nueva Cotización</title>
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

            <h3 class="text-center text-light">NUEVA COTIZACIÓN</h3>
            <br>

            <div class="row seccion-cotizacion">
                <div class="col">

                    <div class="alert alert-help" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Seleccionar un registro de la lista, luego hacer clic en el botón "Seleccionar Empresa"
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Lista de Empresas
                        </div>

                        <div class="card-body">
                            <!--
                            <a href="javascript:void(0)" id="btnSeleccionEmpresa" title="Seleccionar" class="btn btn-info btn-sm"
                               onclick="mostrarBloqueCotizacion();"><i class="fas fa-check"></i> Seleccionar Empresa </a>
                            <span class="text-muted"> | </span>
                            <a href="javascript:void(0)" title="Exportar" class="btn btn-secondary btn-sm"
                               onclick="alert('En desarrollo...')"><i class="fas fa-file-export"></i> Exportar </a>

                            <hr class="line-grey-2">
                               -->

                            <div class="table-responsive">
                                <table id="tblEmpresa" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID Empresa</th>
                                        <th>Rut</th>
                                        <th>Razón Social</th>
                                        <th>Email</th>
                                        <th>Región</th>
                                        <th>Comuna</th>
                                        <th>Acción</th>
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

            <div class="row seccion-cotizacion seccion-contacto" id="containerDatoEmpresa">
                <div class="col">
                    <div class="alert alert-help" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Seleccionar referencia y el contacto de la empresa, si la empresa no tiene contactos, puede
                        crearlo en el módulo de empresas.
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Datos Empresa seleccionada
                        </div>
                        <div class="card-body">
                            <form id="formCotizacion" method="post" action="">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" colspan="2">Referencia y Contacto</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr>
                                        <td scope="row">
                                            <label for="cmbReferencia">Referencia</label>
                                        </td>
                                        <td>
                                            <select name="cmbReferencia" id="cmbReferencia" class="form-control">
                                                <option value="">Seleccione referencia</option>
                                                <option value="1">Capacitación</option>
                                                <option value="5">Calificación procedimiento AWS</option>
                                                <option value="6">Calificación procedimiento ASME IX</option>
                                                <option value="7">Calificación procedimiento API</option>
                                                <option value="3">Calificación de Soldador</option>
                                                <option value="2">Ensayos No Destructivos (END)</option>
                                                <option value="4">Laboratorios</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row">
                                            <label for="cmbContacto">Contacto</label>
                                        </td>
                                        <td>
                                            <select name="cmbContacto" id="cmbContacto" class="form-control"
                                                    onchange="mostrarDatoContacto(this.value)">
                                                <option value="">Seleccione Contacto</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="col" colspan="2">Datos de Empresa</th>
                                    </tr>
                                    <tr>
                                        <td scope="row">Rut Empresa</td>
                                        <td>
                                            <span id="lblRutEmpresa"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Razón social</td>
                                        <td>
                                            <span id="lblRazonSocial"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Dirección</td>
                                        <td>
                                            <span id="lblDirección"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2">Datos de Contacto</th>
                                    </tr>
                                    <tr>
                                        <td scope="row">Nombre</td>
                                        <td>
                                            <span id="lblNombreContacto"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Email</td>
                                        <td>
                                            <span id="lblEmailContacto"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Teléfono</td>
                                        <td>
                                            <span id="lblTelefonoContacto"></span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="col-12 text-right">
                                    <button type="submit" title="Continuar" class="btn btn-info btn-sm btn-seleccionar">
                                        Continuar <i class="fas fa-angle-right"></i></button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

            <div class="row seccion-cotizacion seccion-servicios" id="containerOfertaEconomica">
                <div class="col">
                    <div class="alert alert-help" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Buscar por código o nombre del servicio, luego seleccionar para agregarlo a la cotización.
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Oferta Económica
                        </div>
                        <div class="card-body">
                            <!--
                            <div class="row">
                                <div class="col col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="txtCodigoSap" name="txtCodigoSap" autocomplete='off'
                                               class="form-control" placeholder="Ingresa el código SAP o descripción">
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <a title="Seleccionar" class="btn btn-info" data-toggle="collapse" href="#collapseServicios" role="button" aria-expanded="false" aria-controls="collapseServicios">
                                        <i class="fas fa-cubes"></i> Ver Servicios </a>
                                </div>
                            </div>
                            <br>
                            -->
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card bg-light " style="border: 1px solid rgb(222, 226, 230);">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="tblProducto" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Código SAP</th>
                                                        <th>Código SENCE</th>
                                                        <th>Descripción</th>
                                                        <th>Precio</th>
                                                        <th>Horas</th>
                                                        <th>Contenido</th>
                                                        <th>Requisito</th>
                                                        <th>Objetivo</th>
                                                        <th>Acción</th>
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
                            <br>
                            <form id="formProducto" method="post" action="">
                                <table class="table" id="tblOfertaEconomica">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Código SAP</th>
                                        <th scope="col">Código SENCE</th>
                                        <!--<th scope="col">OT</th>-->
                                        <th scope="col">Detalle</th>
                                        <th scope="col">Extra</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Descuento %</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </form>
                            <br>
                            <div class="col-12 text-right">
                                <button type="submit" title="Continuar" class="btn btn-info btn-sm btn-viewItemObs"
                                        onclick="mostrarItemObservacion();">
                                    Continuar <i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tabla00 seccion-cotizacion seccion-horario">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Horario Ejecución del Curso
                        </div>
                        <div class="card-body">
                            <label for="txtHorarioCurso">Descripción:</label>
                            <textarea name="txtHorarioCurso" id="txtHorarioCurso" class="form-control" cols="30"
                                      rows="3">Diurno: Lunes a Viernes de: 08:30 a 12:00 / 12:30 a 17:00 horas. Vespertino: Lunes a Viernes de: 18:00 a 22:00 horas.</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-texto-servicio">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Descripción del Servicio
                        </div>
                        <div class="card-body">
                            <label for="txtServicio">Descripción:</label>
                            <textarea name="txtServicio" id="txtServicio" class="form-control" cols="30"
                                      rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-inspeccion">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Inspecciones
                        </div>
                        <div class="card-body">

                            <form id="formInspecciones" method="post" action="">
                                <table class="table table-bordered table-striped table-cotizacion">
                                    <tbody>
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]" id="chk53" value="53">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk53">
                                                <strong>Ultrasonido</strong><br>
                                                Como ocurre con el sonido cuando escuchamos, existe un emisor y nuestro
                                                oído es el receptor,
                                                el cual se estimular mecánicamente con el sonido.
                                                El mismo principio es utilizado en el ensayo de Ultra sonido, en el cual
                                                se introducen pulsos de
                                                sonido en el metal a una velocidad conocida y se controla la velocidad
                                                de retorno.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk54" value="54">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk54">
                                                <strong>Partículas Magnetizables</strong><br>
                                                Plazo de entrega de informes, calificación de
                                                procedimientos y soldadores será en un máximo de 07 días hábiles
                                                posteriores
                                                al ensayo.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk55" value="55">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk55">
                                                <strong>Tintas Penetrantes</strong><br>
                                                El método de las tintas penetrantes es uno de los ensayos no
                                                destructivos más usados actualmente en la industria.
                                                Las tintas nos permiten detectar gran variedad de defectos como poros,
                                                socavaciones, grietas y esfuerzos mecánicos o térmicos.
                                                También se puede utilizar para detectar fugas en recipientes herméticos,
                                                entre otras aplicaciones.</label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk56" value="56">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk56">
                                                <strong>Medición de Espesores</strong><br>
                                                Esta técnica de inspección consiste en la determinación del espesor real
                                                del material, que tal vez tenga un desgaste en el tiempo,
                                                corrosión en diversos lugares y materiales como acero carbono, acero
                                                inoxidable, aluminio, titanio etc.
                                                Mediante la introducción de ondas ultrasónicas, a través de la pieza.
                                                Se mide puntualmente en lugares en que un instrumento de medición no
                                                podría.</label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk57" value="57">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk57">
                                                <strong>Asesoría Técnica</strong><br>
                                                Asesorías e Inspecciones Ltda. cuenta con profesionales de amplia
                                                experiencia y certificaciones internacionales en soldadura,
                                                como Inspectores Certificados (CWI) de la Sociedad Americana de
                                                Soldadura (AWS).
                                                Formalice sus procesos de soldadura de manera que sean compatibles con
                                                su sistema de Calidad y/o gestión ISO 9001.
                                                Consulte con nuestro equipo de profesionales sobre cómo implementar un
                                                sistema de control de la calidad, a través del cual pueda controlar,
                                                ordenar y documentar todos sus procesos relacionados con soldadura.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk58" value="58">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk58">
                                                <strong>Análisis de Corrosivos</strong><br>
                                                Las fallas por problemas de corrosión de materiales metálicos causan
                                                perdidas económicas por miles de millones de dólares a nivel mundial
                                                cada año.
                                                Detectar la presencia de corrosión en sus procesos, aumenta la
                                                productividad y la eficiencia de sus proyectos.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk59" value="59">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk59">
                                                <strong>Ensayos Mecánicos</strong><br>
                                                Ceti Inspecciones Ltda. ofrece una amplia gama de servicios de ensayos
                                                mecánicos,
                                                mediante un taller de precisión mecánica se proporciona la preparación
                                                de la muestra para los ensayos, tanto para materiales metálicos como no
                                                metálicos,
                                                en lo relativo a la evaluación de resistencia a la tracción, tensión,
                                                impacto Charpy-V y dureza.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk60" value="60">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk60">
                                                <strong>Inspección Técnica en Soldadura (Visual)</strong><br>
                                                Es por excelencia la base para el control de cualquier proceso de
                                                fabricación o ensayo.
                                                Esta técnica es fundamental para controlar los procesos y productos
                                                antes, durante y después de la fabricación.
                                                Todos los Ensayos No Destructivos se inician con una inspección del tipo
                                                Visual (VT).
                                                Ésta es más rápida y económica, pues se realiza in-situ, y frente a
                                                posibles desviaciones, el Inspector puede sugerir otros tipos de
                                                ensayos,
                                                superficiales y/o sub-superficiales.
                                                Este tipo de inspección es muy valorado en la industria para el control
                                                de los procesos.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk61" value="61">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk61">
                                                <strong>Análisis de Falla</strong><br>
                                                El análisis de falla es un proceso de investigación técnica realizada
                                                mediante la observación y exhaustivos exámenes documentados de un
                                                elemento.
                                                Esto para determinar el mecanismo y condiciones que dan origen a la
                                                falla.
                                                Éste análisis incluye recomendaciones futuras para evitar fallas
                                                similares.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk62" value="62">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk62">
                                                <strong>Análisis Químicos</strong><br>
                                                A través de nuestro equipo de Fluorescencia de Rayos-X es posible
                                                realizar un análisis químico elemental cualitativo,
                                                semicuantitativo y cuantitativo, desde el rango de ppm hasta 100%
                                                concentración en cualquier tipo de muestra sólida en polvo o líquido,
                                                incluyendo soluciones y muestras metálicas.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk63" value="63">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk63">
                                                <strong>Laboratorio Químico</strong><br>
                                                En Chile, la calificación del soldador se realiza de acuerdo a diversas
                                                normas: AWS D1.1 – 2015 / ASME sección IX – 2017 / API 1104 – 2012 /
                                                UNE-EN ISO 9606-1 - 2014.
                                                Nuestros clientes valoran especialmente las calificaciones de soldadores
                                                realizadas en el CETI, por la basta experiencia y excelentes
                                                instalaciones.
                                                Ofrecemos este servicio en todas nuestras Sedes, así como proyectos en
                                                las instalaciones del cliente.
                                                Orientado a personas con experiencia que sólo requieren validar sus
                                                habilidades. *El soldador sólo debe rendir la prueba de soldadura*.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk64" value="64">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk64">
                                                <strong>Calificación de Procedimiento</strong><br>
                                                La calificación de procedimiento, también llamado WPS,
                                                es un respaldo técnico a las uniones soldadas cuya misión es garantizar
                                                la compatibilidad metalúrgica entre metal base, metal de aporte,
                                                proceso y la técnica de soldeo. El WPS es un documento que describe cómo
                                                se realizará la soldadura en producción.
                                                Se recomienda y exige para todas las operaciones de soldadura, sobre
                                                todo, para la fabricación de Proyectos Industriales y mineros,
                                                así como productos en los cuales es requisito de la ingeniería, la
                                                aplicación de códigos y normas de soldadura.
                                            </label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk65" value="65">
                                        </td>
                                        <td colspan="4">
                                            <label for="chk65">
                                                <strong>Servicio Evaluación de Habilidades de Soldador</strong><br>
                                                ¿Conoces las competencias técnicas del personal involucrado en la
                                                productividad de tu empresa?<br>
                                                Centro Técnico INDURA en sus 4 sedes, te ofrece medir estas
                                                competencias, a través de un diagnostico teórico-práctico, direccionado
                                                a:
                                                <br><br>
                                                SOLDADORES<br>
                                                OPERADORES DE SOLDADURAS<br>
                                                SUPERVISORES<br>
                                                DIBUJANTES PROYECTISTAS<br>
                                                SERVICIOS DE INSPECCIÓN<br>
                                            </label>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-oferta-tecnica">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Oferta Técnica
                        </div>
                        <div class="card-body">

                            <form id="formOfertaTecnica" method="post" action="">
                                <table class="table table-bordered table-striped table-cotizacion"
                                       style="display: table;">
                                    <tbody id="tabla1">
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]" id="chk10" value="10">
                                        </td>
                                        <td colspan="4"><label for="chk10">Respaldo y firma de Inspector Soldadura
                                                Certificado por AWS, nivel CWI</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk11" value="11">
                                        </td>
                                        <td colspan="4"><label for="chk11">Especialistas experimentados y/o certificados
                                                por la Sociedad Americana de Soldadura (AWS).</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk12" value="12">
                                        </td>
                                        <td colspan="4"><label for="chk12">Entrega a cada alumno el "Manual de
                                                calificación
                                                de soldador".</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk13" value="13">
                                        </td>
                                        <td colspan="4"><label for="chk13">Entrega de credencial con la información del
                                                soldador calificado.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk14" value="14">
                                        </td>
                                        <td colspan="4"><label for="chk14">Posibilidad de validar la calificación en
                                                línea,
                                                a travez de nuestras plataformas virtuales. </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk15" value="15">
                                        </td>
                                        <td colspan="4"><label for="chk15">Entrega de informe de rechazo con respaldo
                                                fotográfico.</label>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody id="tabla2">
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]" id="chk16" value="16">
                                        </td>
                                        <td colspan="4"><label for="chk16">Respaldo y firma de Inspector Soldadura
                                                Certificado por AWS, nivel CWI</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk17" value="17">
                                        </td>
                                        <td colspan="4"><label for="chk17">Inspector END Certificado nivel II en
                                                líquidos
                                                penetrantes, particular magnetizables y ultrasonido</label>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody id="tabla3">
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]" id="chk18" value="18">
                                        </td>
                                        <td colspan="4"><label for="chk18">Respaldo y firma de Inspector Soldadura
                                                Certificado por AWS, nivel CWI.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk19" value="19">
                                        </td>
                                        <td colspan="4"><label for="chk19">Laboratorios de análisis químico elemental
                                                basado en técnicas validadas por ASTM.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk20" value="20">
                                        </td>
                                        <td colspan="4"><label for="chk20">Laboratorios de ensayos mecánicos basado en
                                                técnicas validadas por ASTM.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk21" value="21">
                                        </td>
                                        <td colspan="4"><label for="chk21">Respaldo y firma de ingeniero
                                                Químico.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk22" value="22">
                                        </td>
                                        <td colspan="4"><label for="chk22">Respaldo y firma de ingeniero
                                                Metalúrgico.</label>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <label for="txtOfertaTecnica">Otro</label>
                                        </td>
                                        <td colspan="4">
                                        <textarea name="txtOfertaTecnica" id="txtOfertaTecnica" class="form-control"
                                                  rows="3"></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-plazo-condiciones">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Plazo de Entrega y Condiciones
                        </div>
                        <div class="card-body">

                            <form id="formPlazoCondiciones" method="post" action="">
                                <table class="table table-bordered table-striped table-cotizacion">
                                    <tbody>
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]" id="chk23" value="23">
                                        </td>
                                        <td colspan="4"><label for="chk23">Los servicios serán realizados previo pago o
                                                una
                                                vez recibida la orden de compra, para proceder a emisión de
                                                factura.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk24" value="24">
                                        </td>
                                        <td colspan="4"><label for="chk24">Plazo de entrega de informes, calificación de
                                                procedimientos y soldadores será en un máximo de 07 días hábiles
                                                posteriores
                                                al ensayo.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk25" value="25">
                                        </td>
                                        <td colspan="4"><label for="chk25">La entrega de resultados y/o informes queda
                                                sujeta a la regularización del pago.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk26" value="26">
                                        </td>
                                        <td colspan="4"><label for="chk26">Las muestras ensayadas permanecerán en el
                                                laboratorio por un período de 30 días. Pasado este plazo, serán
                                                reducidas a
                                                chatarra.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chk27" value="27">
                                        </td>
                                        <td colspan="4"><label for="chk27">CETI se reserva a emitir facturas previa
                                                ejecución de servicios.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <label for="txtEntregaCondicion">Otro</label>
                                        </td>
                                        <td colspan="4">
                                        <textarea name="txtEntregaCondicion" id="txtEntregaCondicion"
                                                  class="form-control" rows="3"></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-observaciones">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Observaciones
                        </div>
                        <div class="card-body">

                            <form id="formObservacion" method="post" action="">
                                <table
                                        class="table table-bordered table-striped table-cotizacion seccion-observacion-1">
                                    <tbody id="tabla5">
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]" id="chkObs33" value="33">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs33">El soldador debe presentarse con ropa de
                                                trabajo, zapato de seguridad y gorro de tela.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs34" value="34">
                                        </td>
                                        <td colspan="4"><label for="chkObs34">En caso de servicios en instalaciones del
                                                cliente, donde no se logre realizar la actividad de Calificación por
                                                razones
                                                ajenas a la responsabilidad de CETI, se cobrará el 100% del valor de la
                                                visita y eventualmente un porcentaje dependiendo del tiempo
                                                transcurrido.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs35" value="35">
                                        </td>
                                        <td colspan="4"><label for="chkObs35">El hecho de no calificar constituye el
                                                100%
                                                del
                                                costo ofertado, pero generar un descuento de un 5% en la próxima
                                                calificación.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs36" value="36">
                                        </td>
                                        <td colspan="4"><label for="chkObs36">La reserva de cabinas solo es previo pago
                                                del
                                                servicio.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs37" value="37">
                                        </td>
                                        <td colspan="4"><label for="chkObs37">Será de responsabilidad del cliente el
                                                proporcionar acceso directo a las zonas a inspeccionar, y los accesorios
                                                necesarios para poder realizar la inspección, tales como andamios,
                                                escalas,
                                                rampas, iluminación, etc. Además el cliente deberá acatar y tomar todas
                                                las
                                                medidas de seguridad que sean necesarias para ejecutar los
                                                trabajos.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs38" value="38">
                                        </td>
                                        <td colspan="4"><label for="chkObs38">Nuestro personal está instruido para
                                                negarse a
                                                efectuar trabajos que pongan en riesgo su integridad, la de otras
                                                personas y
                                                el medio ambiente; en este caso rige el punto anterior. Las zonas a
                                                inspeccionar deberán estar libres de aceites, grasas, pinturas,
                                                recubrimientos, etc.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs39" value="39">
                                        </td>
                                        <td colspan="4"><label for="chkObs39">CETI Inspecciones se hará responsable por
                                                cualquier daño a la infraestructura de las instalaciones de nuestros
                                                clientes que sea causado por la ejecución de nuestros trabajos hasta por
                                                el
                                                100% del valor de los servicios ejecutados o a ejecutar. El cliente
                                                tiene un
                                                plazo máximo de 5 días hábiles luego de ejecutada la visita para hacer
                                                la
                                                reclamación correspondiente.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs40" value="40">
                                        </td>
                                        <td colspan="4"><label for="chkObs40">CETI Inspecciones se reserva el derecho de
                                                informar oportunamente modificaciones en los plazos de entrega de
                                                informar,
                                                por condiciones propias de los ensayos a realizar. </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs41" value="41">
                                        </td>
                                        <td colspan="4"><label for="chkObs41">CETI inspecciones y Certificaciones Ltda
                                                informa que, para realizar devoluciones de dinero o dejar sin efecto
                                                Órdenes de
                                                compra, los clientes deberán informar con anticipación de 48 horas antes
                                                de
                                                la fecha programada. La devolución de dineros o documentos se realizara
                                                a
                                                través de cheque, vale vista o deposito, en un plazo mínimo de 15 días
                                                hábiles.</label>
                                        </td>
                                    </tr>

                                    </tbody>
                                    <tbody id="tabla4">
                                    <tr>
                                        <td class="text-center col-check">
                                            <input type="checkbox" name="chkObs[]3" id="chkObs42" checked="checked"
                                                   value="42">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs42">
                                                Nuestros cursos cuentan con Código SENCE por lo que las empresas pueden
                                                optar a
                                                la Franquicia Tributaria SENCE, el único requisito para hacer efectiva
                                                es
                                                que
                                                los trabajadores que participen en los cursos registren puntualmente su
                                                asistencia, marcando su huella digital al ingreso y salida de la jornada
                                                de
                                                clases, durante todos los días de ejecución.
                                                Si los alumnos llegan tarde o no registran su ingreso o salida, podrían
                                                obtener
                                                un porcentaje de asistencia inferior al 75 % (requisito mínimo exigido
                                                por
                                                SENCE
                                                para la aprobación de un curso). Esto significaría que su empresa no
                                                podría
                                                hacer uso de la Franquicia Tributaria SENCE a través del Programa
                                                Impulsa
                                                persona y por ende tendrá que pagar el valor íntegro del curso.
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs43" checked="checked"
                                                   value="43">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs43">
                                                Para la realización del curso, se le proporcionará al alumno los
                                                siguientes
                                                elementos de protección personal de uso obligatorio: coleto, polainas,
                                                chaqueta
                                                (todo de descarne), tapones auditivos, guantes, lentes de seguridad y
                                                máscara de
                                                soldar.
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs44" checked value="44">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs44">
                                                Para las clases prácticas los participantes deben presentarse con ropa
                                                de
                                                trabajo, calzado de seguridad, gorro de tela soldador y un candado para
                                                guardar
                                                sus pertenencias en un casillero que les será asignado (aplica sede
                                                Santiago).
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs45" checked="checked"
                                                   value="45">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs45">
                                                No reservamos cupos, estos sólo son asignados una vez que se encuentran
                                                pagados
                                                los cursos.
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs46" checked="checked"
                                                   value="46">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs46">La oferta tiene una validez de 30 días.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs47" checked="checked"
                                                   value="47">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs47">Si la parte interesada cancela su participación en
                                                el curso ya facturado, Centro Técnico Indura Ltda. Sólo realizará la
                                                devolución del dinero si esta comunicación es efectuada 03 días hábiles
                                                antes del inicio del curso.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs48" checked="checked"
                                                   value="48">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs48">
                                                Todos los cursos son impartidos en horario diurno
                                                y vespertino, según elección del cliente. Comienzan cada semana, no
                                                requieren de quórum mínimo, sin embargo, el ingreso de los participantes
                                                dependerá de la disponibilidad de cabinas. Se recomienda agendar cursos
                                                con,
                                                a lo menos, dos semanas de anticipación.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs49" checked="checked"
                                                   value="49">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs49">Respecto a la alimentación, en horario diurno los
                                                alumnos reciben almuerzo en nuestro casino (que cuenta con tres menús
                                                diarios, ensaladas, postre, sopa y jugo); y en horario vespertino recibe
                                                once (sándwich con té, café o yogurt).</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs50" checked="checked"
                                                   value="50">
                                        </td>
                                        <td colspan="4">
                                            <label for="chkObs50">"Actividad de Capacitación autorizada por el SENCE
                                                para los efectos de la Franquicia Tributaria, no conducente por norma a
                                                los
                                                procedimientos y requisitos para un otorgamiento de un título o grado
                                                académico, emanado según ley de la República 20.370" </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs51" checked="checked"
                                                   value="51">
                                        </td>
                                        <td colspan="4"><label for="chkObs51">La documentación del curso será enviada a
                                                su
                                                empresa en el plazo de 10 días hábiles, los alumnos no podrán retirar en
                                                forma personal dicha documentación a menos que el mandante autorice vía
                                                correo electrónico.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="chkObs[]" id="chkObs52" checked="checked"
                                                   value="52">
                                        </td>
                                        <td colspan="4"><label for="chkObs52">Teniendo en consideración lo previsto en
                                                el
                                                artículo 79 bis del Decreto N° 250 y el Oficio de Contraloría General de
                                                la
                                                República N° 7.561, de fecha 19 de marzo de 2018, que imparte
                                                instrucciones
                                                sobre el Pago Oportuno a los Proveedores en los Procesos de Contratación
                                                Pública Regulados por la Ley N° 19.886, el pago del precio ofrecido por
                                                (CETI) deberá realizarse dentro del plazo máximo de 30 días corridos
                                                siguientes a la recepción de la factura o del respectivo instrumento
                                                tributario de cobro</label>

                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody>
                                    <tr>
                                        <td class="text-center"><label for="txtObservacion">Otro</label></td>
                                        <td colspan="4">
                                        <textarea name="txtObservacion" id="txtObservacion" class="form-control"
                                                  rows="3"></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-sede">
                <?php if(in_array("18", $_SESSION['PERMISOS'])){ ?>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Sede
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="selectSede">Sede de la cotización:</label>
                                    <select class="form-control" name="selectSede" id="selectSede">
                                        <option value="">Seleccione sede</option>
                                        <?php
                                        foreach ($listSede as $key => $valor) {
                                            echo '<option value="'.$valor->id_sede.'">'.$valor->descripcion.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="row seccion-cotizacion seccion-obsadicional">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Observación
                        </div>
                        <div class="card-body">
                            <label for="txtObsAdicional">Observación Adicional:</label>
                            <textarea name="txtObsAdicional" id="txtObsAdicional" class="form-control" cols="20"
                                      rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row seccion-cotizacion seccion-acciones">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Acciones
                        </div>
                        <div class="card-body text-center">
                            <a href="javascript:void(0)" title="Guardar" class="btn btn-info btn-sm"
                               onclick="guardarCotizacion()" id="btn_guardar_cot"><i class="far fa-save"></i> Guardar Cotización </a>
                        </div>
                        <div align="center" id="txt_generando" style="display: none"><em>Generando Cotización...</em>
                        </div>
                    </div>
                </div>
            </div>


            <!-- MODAL ACTIONS -->
            <div class="modal fade" id="modalCotizacion" tabindex="-1" role="dialog"
                 aria-labelledby="modalCotizacionLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCotizacionLabel"></h5>
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
    var listaContacto = [];
    var tblEmpresa;
    var tblProducto;
    var idEmpresaCotizacion = 0;
    var cars = ["", ""
        , "Servicio de ensayo no destructivos, según:\n" +
        "Norma : AWS D1.1/D1.1M:2015 Structural Welding Code - Steel\n" +
        "Metodo : ----\n" +
        "Dirección : "
        , "Servicio de calificación de soldador, según especificaciones del cliente, a realizar en instalaciones de CETI Santiago:\n" +
        "Norma : AWS D1.1/D1.1M:2015 Structural Welding Code - Steel\n" +
        "Proceso a calificar : SMAW\n" +
        "Posición: Toda posición (3G-4G)\n" +
        "Tipo de unión : A tope\n" +
        "Espesor: 10 mm \n" +
        "Acero : ASTM A36"
        , "Servicio de laboratorio, para la siguiente muestra:\n" +
        "Ensayo : \n" +
        "Tipo de muestra : \n" +
        "Detalle:"
        , "Servicio de calificación de procedimiento según especificaciones del cliente, a realizar en la ciudad de --- :\n" +
        "Norma : AWS D1.1/D1.1M:2015 Structural Welding Code - Steel\n" +
        "Proceso a calificar : SMAW\n" +
        "Posición: Toda posición (2G-3G-4G)\n" +
        "Tipo de unión : A tope\n" +
        "Espesor: 25 mm \n" +
        "Acero : ASTM A36"
        , "Servicio de calificación de procedimiento según especificaciones del cliente, a realizar en la ciudad de --- :\n" +
        "Norma : ASME Sección IX\n" +
        "Proceso a calificar : SMAW\n" +
        "Posición: Toda posición (6G)\n" +
        "Tipo de unión : A tope\n" +
        "Dimensiones: 8 pulgadas, Sh 40. \n" +
        "Acero : ASTM A 53 Grade B"
        , "Servicio de calificación de procedimiento según especificaciones del cliente, a realizar en la ciudad de --- :\n" +
        "Norma : API 1104\n" +
        "Proceso a calificar : SMAW\n" +
        "Posición: Toda posición (EJE INCLINADO 45°)\n" +
        "Tipo de unión : A tope\n" +
        "Dimensiones: 12 pulgadas, Sh 40. \n" +
        "Acero : API 5L X70"];


    $('.seccion-contacto').hide();
    $('.seccion-servicios').hide();

    $('.seccion-horario').hide();
    $('.seccion-texto-servicio').hide();
    $('.seccion-oferta-tecnica').hide();
    $('.seccion-inspeccion').hide();
    $('.seccion-plazo-condiciones').hide();
    $('.seccion-observaciones').hide();

    $('.seccion-sede').hide();

    $('.seccion-obsadicional').hide();

    $('.seccion-otros').hide();
    $('.seccion-acciones').hide();

    $(document).ready(function () {

        tblProducto = $('#tblProducto').DataTable({
            //'searching': false,
            'processing': true,
            //'serverSide': true,
            'serverMethod': 'post',
            "ajax": {
                "url": "<?= CONTROLLERS ?>/cotizacion/producto-y-servicio.php",
                "type": "post",
                /*
                "data": {
                    acc: 1,
                    s_activo: 1,
                    s_tipo: $("#cmbReferencia").val() == 1 ? 1 : 8
                }
                */
                "data": function (data) {
                    var tipo = $("#cmbReferencia").val() == 1 ? 1 : 8;

                    data.acc = 1;
                    data.s_activo = 1;
                    data.s_tipo = tipo;
                }

            },
            "order": [],
            "responsive": true,
            "columns": [
                {"data": "tipo_cotizacion"},
                {"data": "codigo_sap"},
                {"data": "codigo_sence"},
                {"data": "descripcion"},
                {"data": "precio"},
                {"data": "horas"},
                {
                    "data": "contenido",
                    "render": function (data, type, row) {
                        let texto = data + "";
                        if (data !== "" && data != null && data.length >= 35) {
                            return texto.substr(0, 35) + '...<br><a href="javascript:void(0)" title="Ver" class="btn-link btn-contenido">Ver Más</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "requisito",
                    "render": function (data, type, row) {
                        let texto = data + "";
                        if (data !== "" && data != null && data.length >= 35) {
                            return texto.substr(0, 35) + '...<br><a href="javascript:void(0)" title="Ver" class="btn-link btn-requisito">Ver Más</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "objetivo",
                    "render": function (data, type, row) {
                        let texto = data + "";
                        if (data !== "" && data != null && data.length >= 35) {
                            return texto.substr(0, 35) + '...<br><a href="javascript:void(0)" title="Ver" class="btn-link btn-objetivo">Ver Más</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "Seleccionar",
                    "render": function (data, type, row) {
                        return '<button title="Seleccionar" class="btn btn-info btn-sm btn-seleccionar"><i class="fas fa-check"></i> Seleccionar </button>';
                    },
                    "width": 100,
                    "className": "text-center"
                },
            ],
            "dom": 'Hfrtip',
            "buttons": ['excel'],
            //"paging": false,
            "scrollY": 250,
            "pageLength": 5,
            "lengthMenu": [5, 20, 50, 100]
        });

        //on click ver más
        let tblProductoBody = $('#tblProducto tbody');
        tblProductoBody.on('click', 'tr td .btn-contenido', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalCotizacion(1, row.data()));
        });

        tblProductoBody.on('click', 'tr td .btn-requisito', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalCotizacion(2, row.data()));
        });

        tblProductoBody.on('click', 'tr td .btn-objetivo', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);
            row.child(abrirModalCotizacion(3, row.data()));
        });

        function abrirModalCotizacion(ventana, row) {
            let titulo = "";
            let contenido = "";
            let selected = row;

            switch (ventana) {
                case 1:
                    titulo = "CONTENIDO";
                    contenido = row.contenido;
                    break;
                case 2:
                    titulo = "REQUISITO";
                    contenido = row.requisito;
                    break;
                case 3:
                    titulo = "OBJETIVO";
                    contenido = row.objetivo;
                    break;
            }

            let modalC = $("#modalCotizacion");
            modalC.find('.modal-title').text(titulo);
            modalC.find('.modal-body').html(contenido);
            modalC.modal("show");

        }

        $('#cmbReferencia').change(function () {

            let valor = $(this).val();

            tblProducto.draw();
            tblProducto.ajax.reload();
            $('#tblOfertaEconomica tbody').empty();

            $('.seccion-servicios').hide();
            $('.seccion-horario').hide();
            $('.seccion-texto-servicio').hide();
            $('.seccion-oferta-tecnica').hide();
            $('.seccion-inspeccion').hide();
            $('.seccion-plazo-condiciones').hide();
            $('.seccion-observaciones').hide();

            $('.seccion-sede').hide();

            $('.seccion-obsadicional').hide();

            $('.seccion-otros').hide();
            $('.seccion-acciones').hide();
        });

        // Add event listener for opening and closing details
        $('#tblProducto tbody').on('click', 'tr td .btn-seleccionar', function () {
            var tr = $(this).closest('tr');
            var row = tblProducto.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(cargarProductoOferta(row.data()));
                tr.addClass('shown');
            }
        });


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
                {"data": "id"},
                {"data": "rut"},
                {"data": "razon_social"},
                {"data": "email"},
                {"data": "region"},
                {"data": "comuna"},
                {
                    "data": "Seleccionar",
                    "render": function (data, type, row) {
                        return '<button title="Seleccionar" class="btn btn-info btn-sm btn-seleccionar"><i class="fas fa-check"></i> Seleccionar </button>';
                    },
                    "width": 100,
                    "className": "text-center"
                }
            ],
            "dom": 'Hfrtip',
            "buttons": ['excel'],
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100]
        });

        // Array to track the ids of the details displayed rows
        var detailRows = [];

        // Add event listener for opening and closing details
        $('#tblEmpresa tbody').on('click', 'tr td .btn-seleccionar', function () {
            var tr = $(this).closest('tr');
            var row = tblEmpresa.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(mostrarBloqueCotizacion(row.data()));
                tr.addClass('shown');
            }
        });

        $("#formCotizacion").validate({
            rules: {
                cmbReferencia: {
                    required: true,
                    digits: true
                },
                cmbContacto: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                cmbReferencia: {
                    required: "Debe seleccionar la referencia",
                    digits: "Debe seleccionar la referencia"
                },
                cmbContacto: {
                    required: "Debe seleccionar el contacto",
                    digits: "Debe seleccionar el contacto"
                }
            },
            errorElement: 'span',
            errorClass: 'is-invalid invalid-feedback',
            highlight: function (element) {
                $(element).addClass('has_error is-invalid');
            },
            submitHandler: function (form) {

                $(".seccion-servicios").show();

                let referencia = $('#cmbReferencia').val();

                //column.visible( ! column.visible() );
                if (referencia == 1) {
                    tblProducto.column(4).visible(true);
                    tblProducto.column(5).visible(true);
                    tblProducto.column(6).visible(true);
                    tblProducto.column(7).visible(true);
                } else {
                    tblProducto.column(4).visible(false);
                    tblProducto.column(5).visible(false);
                    tblProducto.column(6).visible(false);
                    tblProducto.column(7).visible(false);
                }

                tblProducto.draw();
                tblProducto.ajax.reload();

                let alto = $("#containerOfertaEconomica").offset().top;

                $('html, body').animate({
                    scrollTop: alto
                }, 500, function () {
                });

            }
        });
    });

    function mostrarItemObservacion() {

        let items = $('#formProducto').serialize();

        if (items === "") {
            alertFail('Error', 'Debe seleccionar mínimo 1 servicio');
            return false;
        }

        let referencia = $('#cmbReferencia').val(); // Referencia ID

        let horario = $('.seccion-horario');
        let servicio = $('.seccion-texto-servicio');
        let oferta = $('.seccion-oferta-tecnica');

        let inspeccion = $('.seccion-inspeccion');
        let plazo = $('.seccion-plazo-condiciones');
        let observaciones = $('.seccion-observaciones');

        let sedecot = $('.seccion-sede');

        let obsadicional = $('.seccion-obsadicional');

        let otros = $('.seccion-otros').hide();

        let tabla1 = $('#tabla1'); //servicio tecnico 1
        let tabla2 = $('#tabla2'); //servicio tecnico 2
        let tabla3 = $('#tabla3'); //servicio tecnico 3
        let tabla4 = $('#tabla4'); //observacion 4
        let tabla5 = $('#tabla5'); //observacion 5

        let desc_servicio = $('#txtServicio');

        let acciones = $('.seccion-acciones');

        /*
        * Cada vez que seleccionemos la referencia, se limpian los campos chequeados.
        * */

        $('input[type=checkbox]').prop('checked', false);

        if (referencia !== 1){
            $('#formPlazoCondiciones input[type=checkbox]').prop('checked', true);
        }


        $('#txtOfertaTecnica').val('');
        $('#txtEntregaCondicion').val('');
        $('#txtObservacion').val('');

        tabla1.hide();
        tabla2.hide();
        tabla3.hide();
        tabla4.hide();
        tabla5.hide();

        acciones.show();

        //AL SELECCIONAR LA REFERENCIA, SE MUESTRA Y/O OCULTA CIERTOS ELEMENTOS DENTRO DEL FORMULARIO DE COTIZACIÓN

        switch (referencia) {
            //CAPACITACIÓN
            case "1":
                horario.show();
                servicio.hide();
                oferta.hide();
                inspeccion.hide();
                plazo.hide();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.show();

                tabla4.show();
                $('#formObservacion #tabla4 input[type=checkbox]').prop('checked', true);

                desc_servicio.val('');
                break;

            //ENSAYOS NO DESTRUCTIVOS
            case "2":
                horario.hide();
                servicio.show();
                oferta.show();
                inspeccion.show();
                plazo.show();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.hide();

                tabla1.show();
                tabla5.show();

                $('#formOfertaTecnica #tabla1 input[type=checkbox]').prop('checked', true);
                $('#formObservacion #tabla5 input[type=checkbox]').prop('checked', true);

                desc_servicio.val(cars[referencia]);
                break;

            //CALIFICACIÓN DE SOLDADOR
            case "3":
                horario.hide();
                servicio.show();
                oferta.show();
                inspeccion.show();
                plazo.show();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.hide();

                tabla1.show();
                tabla5.show();

                $('#formOfertaTecnica #tabla1 input[type=checkbox]').prop('checked', true);
                $('#formObservacion #tabla5 input[type=checkbox]').prop('checked', true);

                desc_servicio.val(cars[referencia]);
                break;

            //LABORATORIOS
            case "4":
                horario.hide();
                servicio.show();
                oferta.show();
                inspeccion.show();
                plazo.show();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.hide();

                tabla1.show();
                tabla5.show();

                $('#formOfertaTecnica #tabla1 input[type=checkbox]').prop('checked', true);
                $('#formObservacion #tabla5 input[type=checkbox]').prop('checked', true);

                desc_servicio.val(cars[referencia]);
                break;

            //CALIFICACIÓN PROCEDIMIENTO AWS
            case "5":
                horario.hide();
                servicio.show();
                oferta.show();
                inspeccion.show();
                plazo.show();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.hide();

                tabla2.show();
                tabla5.show();

                $('#formOfertaTecnica #tabla2 input[type=checkbox]').prop('checked', true);
                $('#formObservacion #tabla5 input[type=checkbox]').prop('checked', true);

                desc_servicio.val(cars[referencia]);
                break;

            //CALIFICACIÓN PROCEDIMIENTO ASME IX
            case "6":
                horario.hide();
                servicio.show();
                oferta.show();
                inspeccion.show();
                plazo.show();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.hide();

                tabla2.show();
                tabla5.show();

                $('#formOfertaTecnica #tabla2 input[type=checkbox]').prop('checked', true);
                $('#formObservacion #tabla5 input[type=checkbox]').prop('checked', true);

                desc_servicio.val(cars[referencia]);
                break;

            //CALIFICACIÓN PROCEDIMIENTO API
            case "7":
                horario.hide();
                servicio.show();
                oferta.show();
                inspeccion.show();
                plazo.show();
                observaciones.show();
                sedecot.show();

                obsadicional.show();

                otros.hide();

                tabla3.show();
                tabla5.show();

                $('#formOfertaTecnica #tabla3 input[type=checkbox]').prop('checked', true);
                $('#formObservacion #tabla5 input[type=checkbox]').prop('checked', true);

                desc_servicio.val(cars[referencia]);
                break;
            default:
                horario.hide();
                servicio.hide();
                oferta.hide();
                inspeccion.hide();
                plazo.hide();
                observaciones.hide();
                acciones.hide();
        }

        let alto = referencia == 1 ? $(".seccion-horario").offset().top : $(".seccion-texto-servicio").offset().top;

        $('html, body').animate({
            scrollTop: alto
        }, 500, function () {
        });
    }

    function cargarProductoOferta(item) {

        let htmlProducto = "";
        htmlProducto += '<tr>';
        htmlProducto += '<td><a href="javascript:void(0)" title="Quitar" class="btn btn-danger btn-sm" onclick="removerProducto(this);"><i class="far fa-trash-alt"></i></a></td>';
        htmlProducto += '<td>' + item.codigo_sap + '</td>';
        htmlProducto += '<td>' + item.codigo_sence + '</td>';
        htmlProducto += '<td>' + item.descripcion + '</td>';
        htmlProducto += '<td><input id="txtDetExt_' + item.id + '" name="txtDetExt_' + item.id + '" type="text" class="form-control" value="" maxlength="50">';
        htmlProducto += '<td><input id="txtCantidad_' + item.id + '" name="txtCantidad_' + item.id + '" type="text" class="form-control" value="1" onblur="calcularValorTotal(' + item.id + ');">';
        htmlProducto += '<input type="hidden" id="txtIdProducto[]" name="txtIdProducto[]" value="' + item.id + '">';
        htmlProducto += '</td>';
        htmlProducto += '<td><input id="txtPrecio_' + item.id + '" name="txtPrecio_' + item.id + '" type="text" class="form-control" value="' + item.precio + '" onblur="calcularValorTotal(' + item.id + ');"></td>';
        htmlProducto += '<td><input id="txtDescuento_' + item.id + '" name="txtDescuento_' + item.id + '" type="number" class="form-control" min="1" max="100" value="0" onblur="calcularValorTotal(' + item.id + ');"><span id="txt_error' + item.id + '"></span></td>';
        htmlProducto += '<td><input id="txtValorTotal_' + item.id + '" name="txtValorTotal_' + item.id + '" type="text" class="form-control" readonly value="' + item.precio + '" onblur="calcularValorTotal(' + item.id + ');"></td>';
        htmlProducto += '</tr>';

        $('#tblOfertaEconomica').append(htmlProducto);

    }

    function removerProducto(el) {
        let item = $(el).parent().parent();
        item.remove();
    }

    function calcularValorTotal(idProducto) {

        let cantidad = $('#txtCantidad_' + idProducto).val();
        let precio = $('#txtPrecio_' + idProducto).val();
        let descuento = $('#txtDescuento_' + idProducto).val();


        if (('<?= $_SESSION['USUARIO_TIPO_ID'] ?>' !== '1' && '<?= $_SESSION['USUARIO_TIPO_ID'] ?>' !== '2') && descuento > 0) {
            alertFail("Error", "Ud. no tiene permiso para aplicar descuentos.", function () {
                $('#txtDescuento_' + idProducto).val(0);
            });
            return false;
        }


        if (descuento < 0 || descuento > 100) {
            $("#txt_error" + idProducto).html("<i style='color: red;'>Descuento mal aplicado</i>");
            $(".btn-viewItemObs").prop("disabled", true);
        } else {
            $("#txt_error" + idProducto).html("");
            $(".btn-viewItemObs").prop("disabled", false);
        }

        let valor_total = ((precio * cantidad) / 100) * descuento;
        valor_total = (precio * cantidad) - valor_total;

        console.log("antes: "+valor_total);

        valor_total = Math.round(valor_total);

        console.log("ahora: "+valor_total);

        $('#txtValorTotal_' + idProducto).val(valor_total);
    }

    function mostrarBloqueCotizacion(data) {
        var selected = data; //tblEmpresa.row('.selected').data();

        if (selected !== undefined) {
            idEmpresaCotizacion = selected.id;

            $('#lblRutEmpresa').html(selected.rut);
            $('#lblRazonSocial').html(selected.razon_social);
            $('#lblDirección').html(selected.direccion);

            $('#lblNombreContacto').html('');
            $('#lblEmailContacto').html('');
            $('#lblTelefonoContacto').html('');

            cargarListaContacto(selected.id);

            $(".seccion-contacto").show();

            let alto = $("#containerDatoEmpresa").offset().top;

            $('html, body').animate({
                scrollTop: alto
            }, 500, function () {
            });

        } else {
            alertFail("Error", "Debe seleccionar un registro");
        }
    }

    function cargarListaContacto(idEmpresa) {
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: "<?= CONTROLLERS ?>/cotizacion/cotizacion.php",
            data: {
                acc: 3,
                idE: idEmpresa
            },
            error: function (e) {
            },
            success: function (res) {
                //var dataContacto = JSON.parse(res);
                listaContacto = JSON.parse(res);

                console.info(listaContacto);

                $('#cmbContacto').html('').append('<option value="">Seleccione Contacto</option>');
                $.each(listaContacto, function (index, value) {
                    $('#cmbContacto').append('<option value="' + value.id + '" >' + value.nombre + '</option>');
                })
            }
        });
    }

    function mostrarDatoContacto(valor) {

        if (valor !== "") {
            let index = listaContacto.map(function (e) {
                return e.id;
            }).indexOf(valor);
            let data = listaContacto[index];

            $('#lblNombreContacto').html(data.nombre);
            $('#lblEmailContacto').html(data.email);
            $('#lblTelefonoContacto').html(data.telefono);

        } else {
            $('#lblNombreContacto').html('');
            $('#lblEmailContacto').html('');
            $('#lblTelefonoContacto').html('');
        }
    }

    function guardarCotizacion() {

        let cotizacion = $('#formCotizacion').serialize();
        let items = $('#formProducto').serialize();
        let observacion = $('#formObservacion').serialize();
        let ofertaTecnica = $('#formOfertaTecnica').serialize();
        let plazoCondiciones = $('#formPlazoCondiciones').serialize();
        let inspecciones = $('#formInspecciones').serialize();

        let cmbReferencia = $('#cmbReferencia').val();
        let txtHorarioCurso = $('#txtHorarioCurso').val();
        let txtServicio = $('#txtServicio').val();
        let idSedeCot = $('#selectSede').val();
        let obsAdic = $('#txtObsAdicional').val();

        if (cmbReferencia != 1) {
            txtHorarioCurso = '';
        }

        if (items === "") {
            alertFail('Error', 'Debe seleccionar mínimo 1 servicio');
            return false;
        }

        if(idSedeCot == ""){
            alertFail('Error', 'Debe seleccionar una sede');
            return false;
        }

        if(idSedeCot == undefined){
            idSedeCot = "0";
        }

        //console.log("OBS: "+obsAdic);

        $("#btn_guardar_cot").attr("disabled", true);

        $.ajax({
            url: "<?= CONTROLLERS ?>/cotizacion/cotizacion.php",
            type: "POST",
            data: "acc=4&" + cotizacion
                + "&" + observacion
                + "&" + ofertaTecnica
                + "&" + plazoCondiciones
                + "&" + inspecciones
                + "&txtHorarioCurso=" + txtHorarioCurso
                + "&txtServicio=" + txtServicio
                + "&sedeCot=" + idSedeCot
                + "&obsAdic=" + obsAdic
                + "&idEmpresa=" + idEmpresaCotizacion
                + "&idUsuario=<?=$_SESSION['USUARIO_ID']?>"
                + "&idSede=<?=$_SESSION['USUARIO_SEDE_ID']?>"
                + "&" + items,
            error: function (e) {
                $("#btnGuardar").prop("disabled", false);
            },
            beforeSend: function () {
                $("#btnGuardar").prop("disabled", true);
                AlertLoading("Generando Cotización...", "Espere un momento por favor...");
            },
            success: function (data) {
                eval(data);

                if (response.respuesta == "OK") {
                    alertOk("Correcto", response.mensaje, function () {
                        window.open(response.url, "_blank");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    });
                } else {
                    alertFail("Error", response.mensaje);
                }
                $("#btnGuardar").prop("disabled", false);
            }
        });
    }


</script>
</body>

</html>
