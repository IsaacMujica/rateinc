<?php
require_once "Database.php";
require_once "Correo.php";
include_once "../config/app.php";

class Login {
    private $db;
    private $correo;
    private $table;
    var $salt;

    function __construct(){
        $this->db = new Database();
        $this->correo = new Correo();
        $this->table = "users";
        $this->salt = '7p69tiDcjRKhYJlN1Wf48';
    }

    function login($usuario, $password){
        $this->destruyeSesiones();
        $passw = $this->encriptPass($password);

        $qry = "SELECT
                  *
                FROM
                  $this->table
                WHERE mail = '" .$this->db->db_real_escape_string($usuario). "'
                  AND password = '". $passw ."'
                  AND active = 1
                LIMIT 1";

        $result = $this->db->db_query($qry);

        if($this->db->db_numrows($result) > 0) {

            session_name('sessionCetiAlumnoIntranet');
            if(@session_start() == false){session_destroy();session_start();}

            if (!isset($_SESSION['USUARIO_ID'])){

                $usuario = $this->db->db_fetch_array($result);

                $_SESSION['USUARIO_EMAIL']      = $usuario['mail'];
                $_SESSION['USUARIO_ID']         = $usuario['id'];

            }
            return 1;
        } else {
            $this->destruyeSesiones();
            return 0;
        }
    }

    public function destruyeSesiones(){
        session_name('sessionCetiAlumnoIntranet');
        if(@session_start() == false){session_destroy();session_start();}

        unset($_SESSION['USUARIO_EMAIL']);
        unset($_SESSION['USUARIO_ID']);
        session_destroy();
        return 1;
    }

    function cambioPassword($id, $pwActual, $pwNuevo, $pwNuevoConf){

        if($this->compruebaPassword($id, $pwActual)){
            if(!strcmp($pwNuevo, $pwNuevoConf)){
                $pass = $this->encriptPass($pwNuevo);
                $qry = "UPDATE
                          $this->table
                        SET
                          `password` = '".$pass."'
                        WHERE `id` = '".intval($id)."'
                          AND active = 1;";

                if ($this->db->db_query($qry)) {
                    echo "var response = {'respuesta': 'OK', 'mensaje': 'La contraseña ha sido cambiada correctamente.'};";
                } else {
                    echo "var response = {'respuesta': 'FAIL', 'mensaje': 'Hubo un error al momento de cambiar la contraseña, intente nuevamente.'};";
                }
            } else {
                echo "var response = {'respuesta': 'FAIL', 'mensaje': 'Las contraseñas no coinciden, intente nuevamente.'};";
            }
        }else{
            echo "var response = {'respuesta': 'FAIL', 'mensaje': 'La contraseña actual no es correcta.'};";
        }

    }

    private function compruebaPassword($id, $pword){

        $pass = $this->encriptPass($pword);
        $qry = "SELECT
                  id
                FROM
                  $this->table
                WHERE `id` = '".intval($id)."'
                  AND `password` = '".$pass."'
                  AND active = 1
                LIMIT 1;";

        $rs = $this->db->db_query($qry);
        if($this->db->db_numrows($rs) > 0){
            return true;
        }else{
            return false;
        }
    }

    function generarNuevaClave($email){

        $qry = "SELECT
                  *
                FROM
                  $this->table
                WHERE `usu_email` = '".$this->db->db_real_escape_string($email)."'
                  AND active = 1
                LIMIT 1;";

        $rs = $this->db->db_query($qry);
        $numRow = $this->db->db_numrows($rs);

        if($numRow == 0){
            echo "var response = {'respuesta': 'FAIL', 'mensaje': 'El e-mail ingresado no existe.'};";
        }else{
            $row = $this->db->db_fetch_object($rs);
            $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $cad = "";

            for($i=0; $i<8; $i++)
                $cad .= substr($str, rand(0, 62),1);

            $newPasswd = $cad;
            $pass = $this->encriptPass($newPasswd);

            $change = "UPDATE
                          $this->table
                        SET
                          `password` = '".$pass."'
                        WHERE `id` = '".$row->id."';";

            if($this->db->db_query($change)){

                $template = file_get_contents(APP_PUBLIC . "/templates/usuario/recupera-clave.html");

                $body = str_replace("[EMAIL]", $email, $template);
                $body = str_replace("[CLAVE]", $newPasswd, $body);

                if ($this->correo->enviaCorreo("Recuperación de contraseña", $email, $body, $template))
                    echo "var response = {'respuesta': 'OK', 'mensaje': 'La contraseña ha sido cambiada correctamente, revise su correo'};";
                else
                    echo "var response = {'respuesta': 'FAIL', 'mensaje': 'Hubo un error al recuperar la contraseña, intente nuevamente.'};";

            }else{
                echo "var response = {'respuesta': 'FAIL', 'mensaje': 'Hubo un error al recuperar la contraseña, intente nuevamente.'};";
            }
        }
    }

    function encriptPass($pass){
        return  base64_encode(hash_hmac('md5', $pass, $this->salt));
    }

    private function Close(){
        @mysql_free_result($this->result);
        @mysql_close($this->conex);
    }//end close

    /*function getPermisosUsuario($idU){

        $rows = array();
        $qry = "SELECT usuacc_accion_id AS 'idAccion'
                FROM usuario_accion
                WHERE usuacc_id = '".$idU."'
                ORDER BY idAccion ASC";

        $exe = $this->db->db_query($qry);



        while($arr = $this->db->db_fetch_object($exe)){

            //habilitación de permisos
            //$_SESSION['PERMISOS'][$arr->idAccion];
            //$_SESSION['PERMISOS'][] = $arr->idAccion;

            array_push($rows, $arr->idAccion);
        }

        return $rows;

    }*/

}
