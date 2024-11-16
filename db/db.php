<?php

class Database
{
    private $servername;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    function __construct()
    {
        $config = include("./db/config.php");
        $this->servername = $config['servername'];
        $this->dbname = $config['dbname'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    public function createConnection()
    {
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if ($this->conn) {
                return $this->conn;
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }
}

$db = new Database();
$db->createConnection();
