<?php
require_once "../../config/app.php";
require_once "../../app/Usuario.php";
require_once "../../app/Localidad.php";
require_once "../../app/Sede.php";

$usuario = new Usuario();
$localidad = new Localidad();
$sedes = new Sede();

$id = intval($_GET['id']);

$dataUsuario = $usuario->getInfoUsuario($id);
$listadoPermisos = $usuario->ListadoPermisos();
$permisoUsuario = $usuario->PermisosporAccion($id);

/*echo "<pre>";
print_r($permisoUsuario);
echo "</pre>";*/

?>

<form id="formAccion" autocomplete="off" method="post">

    <div id="accordion">
      <div class="card">
        <div class="card-header" id="headingOne" align="center">
          <h5 class="mb-0">
            <a href="#permisos_empresa" data-toggle="collapse" style="color: white">Empresa</a>
          </h5>
        </div>

        <div id="permisos_empresa" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Acción</th>
                    <th>Permitir</th>
                </tr>
                <?php
                    foreach ($listadoPermisos as $key => $value) {
                        if($listadoPermisos[$key]->id_modulo == 1){ // 1 empresa
                            echo "<tr>";
                                echo "<td>".$value->accion."</td>";

                                if(in_array($value->id_permiso, $permisoUsuario)){
                                    $checked = "checked";
                                }else{
                                    $checked = "";
                                }
                                echo "<td><input type='checkbox' id='chkPermiso".$value->id_permiso."' name='chkPermiso[]' value='".$value->id_permiso."' ".$checked."></td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </table>
          </div>
        </div>

      </div>

      <div class="card">
        <div class="card-header" id="headingTwo" align="center">
          <h5 class="mb-0">
            <a href="#permisos_cotizacion" data-toggle="collapse" style="color: white">Cotización</a>
          </h5>
        </div>
        <div id="permisos_cotizacion" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
          <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Acción</th>
                    <th>Permitir</th>
                </tr>
                <?php
                    foreach ($listadoPermisos as $key => $value) {
                        if($listadoPermisos[$key]->id_modulo == 2){ // 2 cotizacion
                            echo "<tr>";
                                echo "<td>".$value->accion."</td>";

                                if(in_array($value->id_permiso, $permisoUsuario)){
                                    $checked = "checked";
                                }else{
                                    $checked = "";
                                }
                                echo "<td><input type='checkbox' id='chkPermiso".$value->id_permiso."' name='chkPermiso[]' value='".$value->id_permiso."' ".$checked."></td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </table>
          </div>
        </div>
      </div>
    </div>



    <hr>
    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-info btn-sm" id="btnGuardarPermiso">Guardar</button>
    </div>
</form>

<!-- AJAX -->
<script>
    
    $(document).ready(function(){

        //guardado y update de permisos
        $("#btnGuardarPermiso").on("click", function(){
            
            const formData = $("#formAccion").serialize();
            console.info(formData);

            $.ajax({
                url: "<?= CONTROLLERS ?>/usuario.php",
                type: "POST",
                data: "acc=5&idU=<?=$id?>&"+formData,
                error: function (e) {
                    $("#btnGuardarPermiso").prop("disabled", false);
                    console.info(e);
                },
                beforeSend: function () {
                    $("#btnGuardarPermiso").prop("disabled", true);
                },
                success: function (data) {
                    $("#btnGuardarPermiso").prop("disabled", false);
                    $.globalEval(data);
                    //console.info(data);
                    if (response.respuesta == "OK") {
                        alertOk("Correcto", response.mensaje);
                        $("#modalUsuario").modal("hide");
                    }else{
                        alertFail("Error", response.mensaje);
                    }
                }
            });

        });

    });

</script>