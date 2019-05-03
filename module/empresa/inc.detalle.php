<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";

$empresa = new Empresa();
$dataEmpresa = $empresa->getInfoEmpresa($_GET['id']);
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th colspan="2" class="bg-grey">Datos de la empresa seleccionada</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Tipo de empresa</th>
        <td><?= $dataEmpresa->tipo_empresa_descripcion; ?></td>
    </tr>
    <tr>
        <th>Razón Social</th>
        <td><?= $dataEmpresa->razon_social; ?></td>
    </tr>
    <tr>
        <th>Nombre de fantasía</th>
        <td><?= $dataEmpresa->nombre_fantasia; ?></td>
    </tr>
    <tr>
        <th>RUT </th>
        <td><?= $dataEmpresa->rut; ?></td>
    </tr>
    <tr>
        <th>Giro</th>
        <td><?= $dataEmpresa->giro; ?></td>
    </tr>
    <tr>
        <th>Teléfono</th>
        <td><?= $dataEmpresa->telefono; ?></td>
    </tr>
    <tr>
        <th>Página Web</th>
        <td><?= $dataEmpresa->sitioweb; ?></td>
    </tr>
    <tr>
        <th>Región</th>
        <td><?= $dataEmpresa->region; ?></td>
    </tr>
    <tr>
        <th>Comuna</th>
        <td><?= $dataEmpresa->comuna; ?></td>
    </tr>
    <tr>
        <th>Dirección</th>
        <td><?= $dataEmpresa->direccion; ?></td>
    </tr>
    </tbody>
</table>
<hr>
<div class="text-right">
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
</div>
