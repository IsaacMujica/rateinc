<?php
require_once "../../config/app.php";
require_once "../../app/Sede.php";

$sede = new Sede();
$datos_sede = $sede->getInfoSede($_GET['id']);
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th colspan="2" class="bg-grey">Datos de la sede seleccionada</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <th>Sede</th>
            <td><?= $datos_sede->descripcion ?></td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?= $datos_sede->direccion ?></td>
        </tr>
        <tr>
            <th>Encargado</th>
            <td><?= $datos_sede->encargado ?></td>
        </tr>
    </tbody>
</table>
<hr>
<div class="text-right">
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
</div>
