<?php
class Database {
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $modoDesarrollo;
    var $status;
    var $conex;
    var $results, $map;

    function __construct () {
        $this->hostname = "localhost";
        $this->database = "rateinc";
        $this->username = "root";
        $this->password = "";
        $this->modoDesarrollo = true;
        $this->Conex();
    }

    function Conex(){
        if(!($Conn = @mysqli_connect($this->hostname,$this->username,$this->password,$this->database))){
            $this->status = 0;
            echo mysqli_connect_error($Conn);
            exit();
        }

        $this->status = 1;
        $this->conex = $Conn;
    }

    function db_query ($query) {
        if($this->status == 1) {

            $texto = ($this->modoDesarrollo)? " =>[".$query."]\n\n".mysqli_error($this->conex):'';

            $result = $this->conex->query($query) or die ("Error: un problema mientras se ejecutaba esta consulta.".$texto);
            return $result;
        }
        //end mySQL
    } //end db_query()
    function db_query_insert_id ($query) {
        if($this->status == 1) {
            $texto = ($this->modoDesarrollo)? " =>[".$query."]\n\n".mysqli_error($this->conex):'';
            $result = $this->conex->query($query) or die ("Error: un problema mientras se ejecutaba esta consulta.".$texto);

            return mysqli_insert_id($this->conex);
        }
        //end mySQL
    } //end db_query()

    function db_numrows($result) { // cantidad de registros de una tabla.
        switch($this->status) {
            case 1: //mySQL
                return mysqli_num_rows($result);

        } //end switch
    } // end db_numrows()

    function db_numfield ($result) { // cantidad de campos de una tabla
        switch($this->status) {
            case 1: //mySQL
                return mysqli_num_fields($result);

        } //end switch
    } // end db_numfield()

    function db_nameTables () { // nombres de tablas
        switch($this->status) {
            case 1: //mySQL
                $tableList = array();
                $res = mysqli_query($this->conn,"SHOW TABLES");
                while($cRow = mysqli_fetch_array($res))
                {
                    $tableList[] = $cRow[0];
                }
                return $tableList;
        } //end switch
    } // end db_nameTables()

    function db_fetch_array ($result) { // registros de una tabla.

        switch($this->status) {
            case 1: //mySQL
                return mysqli_fetch_array($result);
        } //end switch
    } //end db_fetch_array()

    function db_fetch_object ($result){
        switch($this->status) {
            case 1: //mySQL
                return mysqli_fetch_object($result);
        } //end switch
    }// end db_fetch_object()

    function db_fetch_assoc ($result){	// Recupera una fila de resultados como un array asociativo
        switch($this->status) {
            case 1: //mySQL
                return mysqli_fetch_assoc($result);
        } //end switch
    }// end db_fetch_object()

    function db_fetch_fields($result){	// Recupera los nombres de los campos de una tabla
        switch($this->status) {
            case 1: //mySQL
                return mysqli_fetch_fields($result);
        } //end switch
    }// end db_fetch_field()

    function db_real_escape_string ($result){
        return mysqli_real_escape_string($this->conex,$result);
    }

    function esNum($numero){ // devuelve true si es un numero, de lo contrario false
        if(intval($numero) && is_numeric($numero)){
            return true;
        }else{
            return false;
        }
    }

    function getError()
    {
        return mysqli_error($this->conex);
    }

    function fecha($fech, $wsHora, $wsEntrada = "input"){ //entrega una fecha formateada
        //$fech -> fecha
        //$wsHora -> valor boooleano, si "true" = pone hora en la fecha
        //$wsEntrada -> valor booleano, si "input" = fecha para grabar en bdd, si es "output" = fecha para mostrar sacada de bdd
        if($fech!=""){
            $fech = str_replace("/","-",$fech);
            if(is_null($fech)){	return "";}
            if(strtolower($fech) == "null" ){	return "";}
            if($fech == "null" ){	return "";}
            if($fech == "00-00-0000" || $fech == "0000-00-00"){	return "";}
            if($fech == "00-00-0000 00:00:00" || $fech == "0000-00-00 00:00:00"){	return "";}

            $str="";
            if($wsEntrada== "input"){
                $str = "Y-m-d";
            }else if($wsEntrada== "output"){
                $str = "d-m-Y";
            }
            if($wsHora){ // true
                $str .= " H:i:s";
            }
            $fech = date($str,strtotime($fech));
            return ($fech);
        }else{
            return "";
        }
    }// fin fecha

    function convertText($content){
        if(!mb_check_encoding($content, 'UTF-8')
            OR !($content === mb_convert_encoding(mb_convert_encoding($content, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {

            $content = mb_convert_encoding($content, 'UTF-8');

            if (mb_check_encoding($content, 'UTF-8')) {
                // log('Converted to UTF-8');
            } else {
                // log('Could not converted to UTF-8');
            }
        }
        return $content;
    }
    //-------------------------------------------------------------------------------------------------------------------------------------------------------
    function comparar_fechas($fecha, $fecha_comparar = null){
        if($fecha_comparar == null){
            $fecha_comparar = date("Y-m");
        }

        $fecha = strtotime($fecha);
        $fecha_comparar = strtotime($fecha_comparar);

        if($fecha == $fecha_comparar){
            return 0;
        }else if($fecha < $fecha_comparar){
            return -1;
        }else if($fecha > $fecha_comparar){
            return 1;
        }

        return false;
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------------------

    function generaUrl($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ /.';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby--_';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);

        $cadena = preg_replace('/[^A-Za-z0-9-]+/','-',$cadena);
        $cadena = strtolower($cadena);

        return utf8_encode($cadena);
    }

    //-------------------------------------------------------------------------------------------------------------------------------------------------------

    function logArch($nombreArchivo, $contenidoArchivo){
        if (!file_exists("_tmp/")) {
            if(!mkdir("_tmp/", 0777, true)) {
                exit();
            }
        }
        $archivo= "_tmp/".$nombreArchivo;
        $fch= fopen($archivo, "w");
        fwrite($fch, $contenidoArchivo);
        fclose($fch);
    }

    function getRealIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        } else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_X_FORWARDED"])){
            return $_SERVER["HTTP_X_FORWARDED"];
        } else if (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_FORWARDED"])){
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    function Close(){
        @mysqli_free_result($result);
        @mysqli_close($this->conex);
    }

}