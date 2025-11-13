<?php
class Database
{
    private $host = "localhost";
    private $db_name = "patitas_seguras";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection()
    {
        if ($this->conn) {
            return $this->conn; // si ya está conectada, la reutiliza
        }

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            // no hacer echo aquí, para no romper respuestas JSON
            error_log("Error de conexión DB: " . $e->getMessage());
            $this->conn = null;
        }

        return $this->conn;
    }

    // acceso rápido sin instanciar
    public static function conectar()
    {
        $db = new self();
        return $db->getConnection();
    }
}
