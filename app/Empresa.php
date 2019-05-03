<?php
include_once "Database.php";

class Empresa
{

    private $db;
    private $table;
    public $idE;
    public $idU;
    public $idP;
    public $idC;
    public $razon_social;
    public $cmbTipoEmpresa;
    public $txtRazonSocial;
    public $txtNombreFantasia;
    public $txtRut;
    public $txtGiro;
    public $txtEmail;
    public $txtTelefono;
    public $txtPaginaWeb;
    public $cmbRegion;
    public $cmbComuna;
    public $txtDireccion;
    public $chkActivo;
    public $txtNombre;
    public $txtCargo;
    public $txtCelular;
    public $cmbSede;
    public $cmbTipoPersonal;

    function __construct($arr = '')
    {
        $this->db = new Database();
        $this->table = "empresa";
        $this->table_contacto = "contacto";
        $this->table_personal = "empresa_personal";
        $this->razon_social = "";
        /* EMPRESA - CONTACTO - PERSONAL */
        $this->idE = isset($arr['idE']) ? intval($arr['idE']) : '';
        $this->txtEmail = isset($arr['txtEmail']) ? $this->db->db_real_escape_string($arr['txtEmail']) : '';
        $this->txtTelefono = isset($arr['txtTelefono']) ? $this->db->db_real_escape_string($arr['txtTelefono']) : '';
        /* EMPRESA - CONTACTO */
        $this->txtRut = isset($arr['txtRut']) ? $this->db->db_real_escape_string($arr['txtRut']) : '';
        /* EMPRESA - CONTACTO - PERSONAL */
        $this->chkActivo = isset($arr['chkActivo']) && ($arr['chkActivo'] == "on" || $arr['chkActivo'] == 1) ? 1 : 0;
        /* CONTACTO - PERSONAL */
        $this->idU = isset($arr['idU']) ? intval($arr['idU']) : '';
        $this->txtNombre = isset($arr['txtNombre']) ? $this->db->db_real_escape_string($arr['txtNombre']) : '';
        /* EMPRESA */
        $this->cmbTipoEmpresa = isset($arr['cmbTipoEmpresa']) ? intval($arr['cmbTipoEmpresa']) : '';
        $this->txtRazonSocial = isset($arr['txtRazonSocial']) ? $this->db->db_real_escape_string($arr['txtRazonSocial']) : '';
        $this->txtNombreFantasia = isset($arr['txtNombreFantasia']) ? $this->db->db_real_escape_string($arr['txtNombreFantasia']) : '';
        $this->txtGiro = isset($arr['txtGiro']) ? $this->db->db_real_escape_string($arr['txtGiro']) : '';
        $this->txtPaginaWeb = isset($arr['txtPaginaWeb']) ? $this->db->db_real_escape_string($arr['txtPaginaWeb']) : '';
        $this->cmbRegion = isset($arr['cmbRegion']) ? intval($arr['cmbRegion']) : '';
        $this->cmbComuna = isset($arr['cmbComuna']) ? intval($arr['cmbComuna']) : '';
        $this->txtDireccion = isset($arr['txtDireccion']) ? $this->db->db_real_escape_string($arr['txtDireccion']) : '';
        /* CONTACTO */
        $this->idC = isset($arr['idC']) ? intval($arr['idC']) : '';
        $this->txtCargo = isset($arr['txtCargo']) ? $this->db->db_real_escape_string($arr['txtCargo']) : '';
        $this->txtCelular = isset($arr['txtCelular']) ? $this->db->db_real_escape_string($arr['txtCelular']) : '';
        $this->cmbSede = isset($arr['selectSede']) ? $this->db->db_real_escape_string($arr['selectSede']) : '';
        /* PERSONAL */
        $this->idP = isset($arr['idP']) ? intval($arr['idP']) : '';
        $this->cmbTipoPersonal = isset($arr['cmbTipoPersonal']) ? intval($arr['cmbTipoPersonal']) : '';

    }

    public function getListaEmpresa($req = '')
    {
        $rows = array();
        $qry = "SELECT
                e.`emp_id` AS 'id',
                e.`emp_rut` AS 'rut',
                e.`emp_razon_social` AS 'razon_social',
                e.`emp_nombre_fantasia` AS 'nombre_fantasia',
                e.`emp_giro` AS 'giro',
                e.`emp_sitioweb` AS 'sitioweb',
                e.`emp_email` AS 'email',
                e.`emp_region_id` AS 'region_id',
                r.`reg_descripcion` AS 'region',
                e.`emp_comuna_id` AS 'comuna_id',
                c.`com_descripcion` AS 'comuna',
                e.`emp_direccion` AS 'direccion',
                e.`emp_telefono` AS 'telefono',
                e.`emp_activo` AS 'activo',
                e.`emp_fecha_creacion` AS 'fecha_creacion',
                e.`emp_fecha_modificacion` AS 'fecha_modificacion'
              FROM
                `empresa` e
                LEFT JOIN comuna c ON e.`emp_comuna_id` = c.`com_id` 
                LEFT JOIN `region` r ON e.`emp_region_id` = r.`reg_id`;";

        $res = $this->db->db_query($qry);
        while ($row = $this->db->db_fetch_object($res)) {
            $row->rut = str_replace(".", "", $row->rut);
            $row->razon_social = ucwords(strtolower($row->razon_social));
            $row->nombre_fantasia = ucwords(strtolower($row->nombre_fantasia));
            $row->comuna = ucwords(strtolower($row->comuna));
            $row->fecha_creacion = date("d-m-Y", strtotime($row->fecha_creacion));
            array_push($rows, $row);
        }

        $result['data'] = $rows;
        echo json_encode($result);
    }

    public function getTipoEmpresa()
    {
        $rows = array();
        $qry = "SELECT
              emptip_id AS 'id',
              emptip_desc AS 'descripcion',
              emptip_activo AS 'activo',
              emptip_fecha_creacion AS 'fecha_creacion'
              FROM empresa_tipo
              WHERE emptip_activo = '1'";

        $res = $this->db->db_query($qry);

        while ($reg = $this->db->db_fetch_object($res)) {
            array_push($rows, $reg);
        }

        return $rows;

    }

    public function getInfoEmpresa($idE)
    {
        $qry = "SELECT
                e.`emp_id` AS 'id',
                e.`emp_tipo` AS 'tipo_empresa',
                e.`emp_rut` AS 'rut',
                e.`emp_razon_social` AS 'razon_social',
                e.`emp_nombre_fantasia` AS 'nombre_fantasia',
                e.`emp_giro` AS 'giro',
                e.`emp_sitioweb` AS 'sitioweb',
                e.`emp_email` AS 'email',
                e.`emp_region_id` AS 'region_id',
                r.`reg_descripcion` AS 'region',
                e.`emp_comuna_id` AS 'comuna_id',
                c.`com_descripcion` AS 'comuna',
                e.`emp_direccion` AS 'direccion',
                e.`emp_telefono` AS 'telefono',
                e.`emp_activo` AS 'activo',
                e.`emp_fecha_creacion` AS 'fecha_creacion',
                e.`emp_fecha_modificacion` AS 'fecha_modificacion',
                ep.emptip_desc AS 'tipo_empresa_descripcion'
              FROM
                `empresa` e
                LEFT JOIN comuna c ON e.`emp_comuna_id` = c.`com_id` 
                LEFT JOIN `region` r ON e.`emp_region_id` = r.`reg_id`
                LEFT JOIN empresa_tipo ep ON ep.emptip_id = e.emp_tipo
              WHERE e.`emp_id` = " . intval($idE) . ";";

        $res = $this->db->db_query($qry);
        $rows = array();

        while ($row = $this->db->db_fetch_object($res)) {
            $row->razon_social = ucwords(strtolower($row->razon_social));
            $row->nombre_fantasia = ucwords(strtolower($row->nombre_fantasia));
            $row->fecha_creacion = date("d-m-Y", strtotime($row->fecha_creacion));
            array_push($rows, $row);
        }

        return $rows[0];
    }

    public function setNuevaEmpresa($arr)
    {
        if ($this->existeRut($this->txtRut, $this->idE)) {
            echo "var r = {'titulo': 'Error', 'resultado': 'FAIL', 'mensaje': 'El RUT ya se encuentra registrado'};";
            exit ();
        }

        //echo "<pre>";
        //print_r($arr['cmbTipoPersonal']);
        //echo "</pre>";


       /*ob_start();
       print_r($arr);                                               
       $cont_arch = ob_get_contents();
       ob_end_clean();
       $this->db->logArch("obtenerDatos.txt",$cont_arch);*/


        //exit();

        $activo = isset($arr['chkActivo']) ? $this->chkActivo : 1;


        $qry = "INSERT INTO $this->table (
                emp_tipo,
                emp_rut,
                emp_razon_social,
                emp_nombre_fantasia,
                emp_giro,
                emp_sitioweb,
                emp_email,
                emp_region_id,
                emp_comuna_id,
                emp_direccion,
                emp_telefono,
                emp_activo,
                emp_fecha_creacion
              )
              VALUES
                (
                  $this->cmbTipoEmpresa,
                  '$this->txtRut',
                  '$this->txtRazonSocial',
                  '$this->txtNombreFantasia',
                  '$this->txtGiro',
                  '$this->txtPaginaWeb',
                  '$this->txtEmail',
                  $this->cmbRegion,
                  $this->cmbComuna,
                  '$this->txtDireccion',
                  '$this->txtTelefono',
                  $activo,
                  NOW()
                );";

        $idEmp = $this->db->db_query_insert_id($qry);

        if ($idEmp > 0) {

            if($arr['cmbTipoPersonal'][0] != ""){

                for($n = 0; $n < count($arr['cmbTipoPersonal']); $n++){

                    $qry = "INSERT INTO $this->table_personal (
                            empper_personal_tipo_id,
                            empper_empresa_id,
                            empper_nombre,
                            empper_email,
                            empper_telefono,
                            empper_activo,
                            empper_usuario_id,
                            empper_fecha_creacion
                          )
                          VALUES
                          (
                              '". $arr['cmbTipoPersonal'][$n]."',
                              $idEmp,
                              '". $arr['txtNombre'][$n] ."',
                              '". $arr['txtEmail'][$n] ."',
                              '". $arr['txtTelefono'][$n] ."',
                              1,
                              $this->idU,
                              NOW()
                            );";
                    $res = $this->db->db_query($qry);

                }

            }

            if($arr['txtNombreC'][0] != ""){

                for($c = 0; $c < count($arr['txtNombreC']); $c++){

                    $qry1 = "INSERT INTO $this->table_contacto (
                            con_nombre,
                            con_rut,
                            con_email,
                            con_cargo,
                            con_telefono,
                            con_celular,
                            con_sucursal_id,
                            con_empresa_id,
                            con_usuario_id,
                            con_activo,
                            con_fecha_creacion
                          )
                          VALUES
                            (
                              '". $arr['txtNombreC'][$c]."',
                              '',
                              '". $arr['txtEmailC'][$c]."',
                              '". $arr['txtCargoC'][$c]."',
                              '". $arr['txtTelefonoC'][$c]."',
                              '". $arr['txtCelularC'][$c]."',
                              '". $arr['selectSedeC'][$c]."',
                               $idEmp,
                              $this->idU,
                              1,
                              NOW()
                            );";
                    $res = $this->db->db_query($qry1);

                }

            }


            echo "var r = {'titulo': 'Correcto', 'resultado': 'OK', 'mensaje': 'La empresa ha sido ingresada correctamente'};";
        } else {
            echo "var r = {'titulo': 'Error', 'resultado': 'FAIL', 'mensaje': 'La empresa no pudo ser creada, intentar nuevamente.'};";
        }
    }

    public function setActualizacionEmpresa($arr)
    {
        if ($this->existeRut($this->txtRut, $this->idE)) {
            echo "var r = {'titulo': 'Error', 'resultado': 'FAIL', 'mensaje': 'El RUT ya se encuentra registrado'};";
            exit ();
        }

        $activo = isset($arr['chkActivo']) ? $this->chkActivo : 'emp_activo';

        $qry = "UPDATE $this->table
              SET
                emp_tipo               =  $this->cmbTipoEmpresa,
                emp_rut                = '$this->txtRut',
                emp_razon_social       = '$this->txtRazonSocial',
                emp_nombre_fantasia    = '$this->txtNombreFantasia',
                emp_giro               = '$this->txtGiro',
                emp_sitioweb           = '$this->txtPaginaWeb',
                emp_email              = '$this->txtEmail',
                emp_region_id          =  $this->cmbRegion,
                emp_comuna_id          =  $this->cmbComuna,
                emp_direccion          = '$this->txtDireccion',
                emp_telefono           = '$this->txtTelefono',
                emp_activo             =  $activo,
                emp_fecha_modificacion =  NOW()
              WHERE emp_id = $this->idE;";

        if ($this->db->db_query($qry)) {
            echo "var r = {'titulo': 'Correcto', 'resultado': 'OK', 'mensaje': 'La empresa ha sido ingresada correctamente'};";
        } else {
            echo "var r = {'titulo': 'Error', 'resultado': 'FAIL', 'mensaje': 'La empresa no pudo ser creada, intentar nuevamente.'};";
        }
    }

    public function setEstadoEmpresa()
    {
        $response = array();

        $qry = "UPDATE $this->table
              SET
                emp_activo               =  $this->chkActivo,
                emp_fecha_modificacion   =  NOW()
              WHERE emp_id = $this->idE;";
        //$response['qry'] = $qry;

        $res = $this->db->db_query($qry);
        $response['titulo'] = "Actualizado";

        if ($res) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "Se ha actualizado el estado correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";
    }

    /* END EMPRESAS */

    /*************************** CONTACTOS ****************************/

    public function getListaContacto($arr, $json = false)
    {
        $where = "";
        $where .= isset($arr['idC']) ? " AND con_id = " . intval($arr['idC']) . " " : "";

        $qry = "SELECT
                con_id AS 'id',
                con_nombre AS 'nombre',
                con_rut AS 'rut',
                con_email AS 'email',
                con_cargo AS 'cargo',
                con_telefono AS 'telefono',
                con_celular AS 'celular',
                con_sucursal_id AS 'sucursal_id',
                sede.sed_descripcion AS 'sede_name',
                con_empresa_id AS 'empresa_id',
                con_usuario_id AS 'usuario_id',
                con_activo AS 'activo',
                con_fecha_creacion AS 'fecha_creacion'
              FROM
                $this->table_contacto
              LEFT JOIN sede ON sede.sed_id = con_sucursal_id
              WHERE con_empresa_id = " . intval($arr['idE']) . $where . ";";

        $res = $this->db->db_query($qry);
        $rows = array();

        while ($row = $this->db->db_fetch_object($res)) {
            $row->nombre = ucwords(strtolower($row->nombre));
            $row->fecha_creacion = date("d-m-Y", strtotime($row->fecha_creacion));
            $row->accion = '<a href="javascript:void(0)" title="Editar Personal" class="btn btn-info btn-sm" data-title="Personal" onclick="abrirModalEmpresaContacto(2,' . $row->id . ');"><i class="fas fa-user-tie"></i> Editar </a>';
            array_push($rows, $row);
        }

        if ($json)
            echo json_encode($rows);
        else {
            if (isset($arr['idC']))
                return $rows[0];
            else
                return $rows;
        }
    }

    public function getInfoContacto($req = '', $json = false)
    {
        $rows = array();
        $qry = "SELECT
                con_id AS 'id',
                con_nombre AS 'nombre',
                con_rut AS 'rut',
                con_email AS 'email',
                con_cargo AS 'cargo',
                con_telefono AS 'telefono',
                con_celular AS 'celular',
                con_sucursal_id AS 'sucursal_id',
                con_empresa_id AS 'empresa_id',
                con_usuario_id AS 'usuario_id',
                con_fecha_creacion AS 'fecha_creacion'
              FROM
                $this->table_contacto;";

        $res = $this->db->db_query($qry);
        while ($row = $this->db->db_fetch_object($res)) {
            $row->nombre = ucwords(strtolower($row->nombre));
            $row->fecha_creacion = date("d-m-Y", strtotime($row->fecha_creacion));
            array_push($rows, $row);
        }

        return $rows;
    }

    public function setNuevoContacto()
    {
        $response = array();

        $qry = "INSERT INTO $this->table_contacto (
                con_nombre,
                con_rut,
                con_email,
                con_cargo,
                con_telefono,
                con_celular,
                con_sucursal_id,
                con_empresa_id,
                con_usuario_id,
                con_activo,
                con_fecha_creacion
              )
              VALUES
                (
                  '$this->txtNombre',
                  '$this->txtRut',
                  '$this->txtEmail',
                  '$this->txtCargo',
                  '$this->txtTelefono',
                  '$this->txtCelular',
                  '$this->cmbSede',
                  $this->idE,
                  $this->idU,
                  $this->chkActivo,
                  NOW()
                );";
        $res = $this->db->db_query_insert_id($qry);
        $response['titulo'] = "Correcto";
        if ($res > 0) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "El contacto ha sido guardado correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";

    }

    public function setActualizacionContacto()
    {
        $response = array();

        $qry = "UPDATE $this->table_contacto
              SET
                con_nombre      = '$this->txtNombre',
                con_rut         = '$this->txtRut',
                con_email       = '$this->txtEmail',
                con_cargo       = '$this->txtCargo',
                con_telefono    = '$this->txtTelefono',
                con_celular     = '$this->txtCelular',
                con_sucursal_id = '$this->cmbSede',
                con_empresa_id  =  $this->idE,
                con_usuario_id  =  $this->idU,
                con_activo      =  $this->chkActivo
              WHERE con_id = $this->idC;";

        $res = $this->db->db_query($qry);
        $response['titulo'] = "Actualizado";

        if ($res) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "Sus datos se han actualizado correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";
    }

    public function setEstadoContacto()
    {
        $response = array();

        $qry = "UPDATE $this->table_contacto
              SET
                con_activo =  $this->chkActivo
              WHERE con_id = $this->idC;";
        //$response['qry'] = $qry;

        $res = $this->db->db_query($qry);
        $response['titulo'] = "Actualizado";

        if ($res) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "Se ha actualizado el estado correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";
    }

    /* END CONTACTO */

    /*************************** PERSONAL ***************************/

    public function getListaPersonal($arr, $json = false)
    {
        $where = "";
        $where .= isset($arr['tipo_p']) ? " AND empper_personal_tipo_id = " . intval($arr['tipo_p']) . " " : "";
        $where .= isset($arr['idP']) ? " AND empper_id = " . intval($arr['idP']) . " " : "";

        $qry = "SELECT
                empper_id AS 'id',
                empper_personal_tipo_id AS 'personal_tipo_id',
                emppertip_nombre AS 'personal_tipo_nombre',
                empper_empresa_id AS 'empresa_id',
                emp_razon_social AS 'empresa_nombre',
                empper_nombre AS 'nombre',
                empper_email AS 'email',
                empper_telefono AS 'telefono',
                empper_activo AS 'activo',
                empper_usuario_id AS 'usuario_id',
                empper_fecha_creacion AS 'fecha_creacion'
              FROM
                $this->table_personal
                LEFT JOIN $this->table ON empper_empresa_id = emp_id
                LEFT JOIN empresa_personal_tipo ON empper_personal_tipo_id = emppertip_id
              WHERE empper_empresa_id = " . intval($arr['idE']) . " " . $where . ";";

        $res = $this->db->db_query($qry);
        $rows = array();

        while ($row = $this->db->db_fetch_object($res)) {
            $row->nombre = ucwords(strtolower($row->nombre));
            $row->fecha_creacion = date("d-m-Y", strtotime($row->fecha_creacion));
            $row->accion = '<a href="javascript:void(0)" title="Editar Personal" class="btn btn-info btn-sm" data-title="Personal" onclick="abrirModalEmpresaPersonal(2,' . $row->id . ');"><i class="fas fa-user-tie"></i> Editar </a>';
            //$row->accion .= '<a href="javascript:void(0)" title="Estado" class="btn btn-info btn-sm" onclick="cambiarEstadoEmpresa();" idP="$row->id"><i class="fas fa-toggle-on"></i> Deshabilitar </a>';
            array_push($rows, $row);
        }
        //$rows['qry'] = $qry;

        if ($json)
            echo json_encode($rows);
        else {
            if (isset($arr['idP']))
                return $rows[0];
            else
                return $rows;
        }
    }

    public function setNuevoPersonal($json = false)
    {
        $response = array();
        $qry = "INSERT INTO $this->table_personal (
                empper_personal_tipo_id,
                empper_empresa_id,
                empper_nombre,
                empper_email,
                empper_telefono,
                empper_activo,
                empper_usuario_id,
                empper_fecha_creacion
              )
              VALUES
                (
                  $this->cmbTipoPersonal,
                  $this->idE,
                  '$this->txtNombre',
                  '$this->txtEmail',
                  '$this->txtTelefono',
                  $this->chkActivo,
                  $this->idU,
                  NOW()
                );";
        $res = $this->db->db_query_insert_id($qry);
        $response['titulo'] = "Correcto";
        if ($res > 0) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "Sus datos han sido guardados correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";
    }

    public function setActualizacionPersonal()
    {
        $response = array();

        $qry = "UPDATE $this->table_personal
              SET
                empper_personal_tipo_id =  $this->cmbTipoPersonal,
                empper_empresa_id       =  $this->idE,
                empper_nombre           = '$this->txtNombre',
                empper_email            = '$this->txtEmail',
                empper_telefono         = '$this->txtTelefono',
                empper_activo           =  $this->chkActivo,
                empper_usuario_id       =  $this->idU
              WHERE empper_id = $this->idP;";

        $res = $this->db->db_query($qry);
        $response['titulo'] = "Actualizado";

        if ($res) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "Sus datos se han actualizado correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";
    }

    public function setEstadoPersonal()
    {
        $response = array();

        $qry = "UPDATE $this->table_personal
              SET
                empper_activo =  $this->chkActivo
              WHERE empper_id = $this->idP;";
        //$response['qry'] = $qry;

        $res = $this->db->db_query($qry);
        $response['titulo'] = "Actualizado";

        if ($res) {
            $response['resultado'] = "OK";
            $response['mensaje'] = "Se ha actualizado el estado correctamente.";
        } else {
            $response['resultado'] = "FALSE";
            $response['mensaje'] = "Ha ocurrido un error al actualizar, por favor intente nuevamente mas tarde.";
        }
        echo "var r = " . json_encode($response) . ";";
    }

    /* END EMPRESAS */

    public function getListaPersonalTipo($json = false)
    {
        $qry = "SELECT
                emppertip_id AS 'id',
                emppertip_nombre AS 'nombre'
              FROM
                empresa_personal_tipo
              WHERE emppertip_activo = 1;";

        $res = $this->db->db_query($qry);
        $rows = array();

        while ($row = $this->db->db_fetch_object($res)) {
            //$row->nombre = ucwords(strtolower($row->nombre));
            //$row->fecha_creacion = date("d-m-Y", strtotime($row->fecha_creacion));
            array_push($rows, $row);
        }

        if ($json)
            echo json_encode($rows);
        else
            return $rows;
    }

    /* END PERSONAL */

    private function existeRut($rut, $id)
    {
        $qry = "SELECT
                  COUNT(*) AS 'cant'
                FROM
                  empresa
                WHERE emp_rut = '" . $rut . "'
                  AND emp_id NOT IN (".$id.");";

        $res = $this->db->db_query($qry);
        $desc = $this->db->db_fetch_object($res);

        if ($desc->cant > 0)
            return true;
        else
            return false;
    }


}