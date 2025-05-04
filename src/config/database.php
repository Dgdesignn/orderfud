<?php
class Database{
    private $host = 'localhost';
    private $user = 'root';
    private $dbname = 'apporder';
    private $password = '';
   

    private $conn;

    public function getConnection(){
        $this->conn=null;
        try {
            $this->conn = new PDO("mysql:host=127.0.0.1;port=5406;dbname=orderfud", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOEexception $error) {
            echo "Connection error ",$error;
        }

        
    }
}


?>