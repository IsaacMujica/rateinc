<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";
require_once "../../app/Sede.php";

$empresa = new Empresa();
$sede = new Sede();

$id = intval($_GET['id']);
$idU = intval($_GET['idU']);

$arr = array("idE" => $id);

//$dataContacto = $empresa->getInfoEmpresaContacto($arr);
$dataEmpresaContacto = $empresa->getListaContacto($arr);
$nombre_empresa = $empresa->getInfoEmpresa($id);

//echo $id . "<br><br>";
//
/*
echo "<pre>";
echo "idE ";
print_r($id);
echo "</pre>";

echo "<pre>";
echo "idU ";
print_r($idU);
echo "</pre>";

echo "<pre>";
echo "SESSION";
print_r($_SESSION);
echo "</pre>";

echo "<pre>";
echo "dataEmpresaContacto";
print_r($dataEmpresaContacto);
echo "</pre>";
*/
?>

<div style="margin-bottom: 10px;">
	<span style="font-size: 20px">Empresa: <?php echo $nombre_empresa->razon_social; ?></span>
</div>
<hr>

<a style="margin-bottom: 20px;" href="javascript:void(0)" title="Editar Personal" class="btn btn-info btn-sm" data-title="Personal" onclick="abrirModalEmpresaContacto(1);"><i class="fas fa-plus-square"></i> Crear </a>
<table class="table table-bordered table-striped table-contacto">
	<thead>
		<tr>
            <th>Estado</th>
            <th>Nombre</th>
            <th>Sede</th>
			<th>Correo</th>
			<th>Teléfono</th>
            <th>Accion</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if (count($dataEmpresaContacto) == 0)
			echo '<tr><td align="center" colspan="5"><b>No tiene contactos asociados</b></td></tr>';
		foreach ($dataEmpresaContacto as $key => $value)
		{
			/*echo $key;
			echo "<br>";
			var_dump( $value);
			echo "<br>";*/
			echo "<tr>";
                if ($value->activo == 1)
                    echo "<td>".'<span class="badge badge-success">Activo</span>'."</td>";
                else
                    echo "<td>".'<span class="badge badge-danger">Inactivo</span>'."</td>";
                echo "<td>".$value->nombre."</td>";
                echo "<td>".$value->sede_name."</td>";
				echo "<td>".$value->email."</td>";
				echo "<td>".$value->telefono."</td>";
                echo "<td>".$value->accion."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
</table>

<!-- <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modalEmpresa">Cerrar</button>
</div> -->