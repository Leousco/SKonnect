<?php
class Database {
    private $host = "localhost";
    private $db_name = "skonnect";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "<h3 style='color:red;'>Connection error:</h3> " . $exception->getMessage();
        }
        return $this->conn;
    }
}

/* ===== DEBUG CHECK ===== */
$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "<h2 style='color:green;'>✅ Database Connected Successfully</h2>";
} else {
    echo "<h2 style='color:red;'>❌ Database Connection Failed</h2>";
}
?>