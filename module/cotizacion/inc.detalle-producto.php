<?php
require_once "../../config/app.php";
require_once "../../app/Producto.php";

$producto = new Producto();
$dataProducto = $producto->getInfoProducto($_GET['id']);

echo "<pre>";
//print_r($dataProducto);
echo "</pre>";
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th colspan="2" class="bg-grey">Datos del servicio seleccionado</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Tipo Cotización</th>
        <td><?= $dataProducto->tipo_cotizacion ?></td>
    </tr>
    <tr>
        <th>Código SAP</th>
        <td><?= $dataProducto->codigo_sap ?></td>
    </tr>
    <tr>
        <th>Código SENCE</th>
        <td><?= $dataProducto->codigo_sence ?></td>
    </tr>
    <tr>
        <th>Descripción</th>
        <td><?= $dataProducto->descripcion ?></td>
    </tr>
    <tr>
        <th>Precio</th>
        <td><?= $dataProducto->precio ?></td>
    </tr>
    <tr>
        <th>OT</th>
        <td><?= $dataProducto->ot ?></td>
    </tr>
    <tr>
        <th>Horas</th>
        <td><?= $dataProducto->horas ?></td>
    </tr>
    <tr>
        <th>Objetivo</th>
        <td><?= $dataProducto->objetivo ?></td>
    </tr>
    </tbody>
</table>
<hr>
<div class="text-right">
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
</div>
