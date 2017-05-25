<?php
class DBConnection{

    private $conn;

    public function __construct(){
    }
    public function Connect(){
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=dbprova', 'root', '123456');
            $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            echo "Connectado";

        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function Query($sql){
        return $this->conn->prepare($sql);
    }
}
?>
