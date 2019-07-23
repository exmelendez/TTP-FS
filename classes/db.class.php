<?php

class DbConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $dbConnection;

    protected function connect() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "iex";
        
        try {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbConnection = $pdo;

        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
        
    }

    protected function getDbConn() {
        return $this->dbConnection;
    }

    protected function closeConn() {
        $this->dbConnection = null;
    }
}