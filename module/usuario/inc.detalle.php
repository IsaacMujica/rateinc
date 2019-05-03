<?php
require_once "../../config/app.php";
require_once "../../app/Usuario.php";

$usuario = new Usuario();
$dataUsuario = $usuario->getInfoUsuario($_GET['id']);
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th colspan="2" class="bg-grey">Datos de usuario seleccionada</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Tipo de usuario</th>
        <td><?= $dataUsuario->usuario_tipo ?></td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td><?= $dataUsuario->nombre ?></td>
    </tr>
    <tr>
        <th>Apellido</th>
        <td><?= $dataUsuario->apellido ?></td>
    </tr>
    <tr>
        <th>RUT </th>
        <td><?= $dataUsuario->rut ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= $dataUsuario->email ?></td>
    </tr>
    <tr>
        <th>Cargo</th>
        <td><?= $dataUsuario->profesion ?></td>
    </tr>
    <tr>
        <th>Teléfono</th>
        <td><?= $dataUsuario->telefono ?></td>
    </tr>
    <tr>
        <th>Celular</th>
        <td><?= $dataUsuario->celular ?></td>
    </tr>
    <tr>
        <th>Sede</th>
        <td><?= $dataUsuario->sede ?></td>
    </tr>
    </tbody>
</table>
<hr>
<div class="text-right">
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
</div>
