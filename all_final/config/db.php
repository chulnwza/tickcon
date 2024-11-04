<?php
class MyDB {
    private $conn;

    function __construct() {
        $servername = "database-3.chaocgea2ln5.us-east-1.rds.amazonaws.com"; // ใส่ RDS endpoint
        $username = "admin"; // ใส่ชื่อผู้ใช้ RDS
        $password = "Natta123$"; // ใส่รหัสผ่าน RDS
        $dbname = "database-3"; // ใส่ชื่อฐานข้อมูล

        // สร้างการเชื่อมต่อ
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // เช็คการเชื่อมต่อ
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connected successfully to RDS";
    }

    function close() {
        $this->conn->close();
    }
}

// สร้างออบเจ็กต์ของ MyDB
$db = new MyDB();
?>