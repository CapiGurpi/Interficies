<?php
// model/db.php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "next_level_sports"; // Le ponemos este nombre porque nuestra base de datos se llama así por si lo veis luego.
    public $conn;

    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>