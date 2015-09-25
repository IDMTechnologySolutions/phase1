<?php

class core_db extends PDO {

    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
    private $result;

    public function __construct() {
        $this->engine = 'mysql';
        $this->host = 'localhost';
        $this->database = 'idm_international';
        $this->user = 'chaminda_idmsubs';
        $this->pass = '1qaz2wsx!';

        $dns = $this->engine . ':dbname=' . $this->database . ";host=" . $this->host;
        parent::__construct($dns, $this->user, $this->pass);
    }

    public function getResult() {
        return $this->result;
    }

}
//sql details array for datatables
$sql_details = array(
    'user' => 'chaminda_idmsubs',
    'pass' => '1qaz2wsx!',
    'db' => 'idm_international',
    'host' => 'localhost'
);
?>
