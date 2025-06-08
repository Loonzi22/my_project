<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "blog_db";
    public $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Připojení selhalo: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
