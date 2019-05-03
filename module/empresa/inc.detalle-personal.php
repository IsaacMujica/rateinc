<?php
require_once "../../config/app.php";
require_once "../../app/Empresa.php";

$empresa = new Empresa();

$id = intval($_GET['id']);
$idU = intval($_GET['idU']);

$arr = array("idE" => $id);

$dataPersonal = $empresa->getListaPersonal($arr);
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
echo "dataPersonal";
print_r($dataPersonal);
echo "</pre>";
*/
?>
<a style="margin-bottom: 20px;" href="javascript:void(0)" title="Editar Personal" class="btn btn-info btn-sm" data-title="Personal" onclick="abrirModalEmpresaPersonal(1);"><i class="fas fa-plus-square"></i> Crear </a>
<table class="table table-bordered table-striped table-personal">
	<thead>
		<tr>
            <th>Estado</th>
			<th>Tipo de Personal</th>
			<th>Nombre</th>
			<th>Correo</th>
            <th>Teléfono</th>
            <th>Accion</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if (count($dataPersonal) == 0)
			echo '<tr><td align="center" colspan="6"><b>No tiene personal asociado</b></td></tr>';
		foreach ($dataPersonal as $key => $value) {
			echo "<tr>";
                if ($value->activo == 1)
                    echo "<td>".'<span class="badge badge-success">Activo</span>'."</td>";
                else
                    echo "<td>".'<span class="badge badge-danger">Inactivo</span>'."</td>";
				echo "<td>".$value->personal_tipo_nombre."</td>";
				echo "<td>".$value->nombre."</td>";
				echo "<td>".$value->email."</td>";
                echo "<td>".$value->telefono."</td>";
                echo "<td>".$value->accion."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
</table>