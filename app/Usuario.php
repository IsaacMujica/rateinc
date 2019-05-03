<?php
include_once "Database.php";

class Usuario
{

    private $db;
    private $login;
    private $salt;
    private $table;

    /**
     * Usuario constructor.
     */
    function __construct()
    {
        $this->db = new Database();
        //$this->login = new Login();
        $this->salt = "7p69tiDcjRKhYJlN1Wf48";
        $this->table = "users";
    }

    function updateQuestions($validate)
    {
        $validate = intval($validate);
        $result = array();
        $qry = "SELECT * FROM questions";

        $res = $this->db->db_query($qry);

        while ($row = $this->db->db_fetch_object($res)) {
          if ($row->validate != "default") {
            $row->validate = explode($row->validate)
            if ($validate >= intval($row->validate[0]) && $validate <= intval($row->validate[1])) {
              array_push($result, $row->description);
            }
          }
        }

        echo "var r = {'resultado': 'OK', response: '". json_encode($result) ."'};";

    }

}
