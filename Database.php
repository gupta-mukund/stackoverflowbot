<?php
class Database
{
    private $host = "localhost";
    private $username = "proghelper";
    private $password = "";
    private $db = "my_proghelper";
    private $conn;

    private static $instance;

    function __construct()
    {
        $this->connectToDB();
    }

    private function connectToDB()
    {
        $connection_string = "mysql:host=$this->host;dbname=$this->db;charset=UTF8";

        try {
            $this->conn = new PDO($connection_string, $this->username, $this->password);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public static function getDatabase()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function setStatus($chat_id, $status)
    {
        $result = $this->fetchChat($chat_id);
        if ($result->rowCount() > 0) {
            $this->updateStatus($chat_id, $status);
        } else {
            $this->createStatus($chat_id, $status);
        }
    }

    public function getChatStatus($chat_id)
    {
        $result = $this->fetchChat($chat_id);
        if ($result->rowCount() > 0) {
            $record = $result->fetch();
            return $record["status"];
        } else {
            return null;
        }
    }

    private function fetchChat($chat_id)
    {
        $select_query = "SELECT * FROM status WHERE client_id = ?";
        $stmt = $this->conn->prepare($select_query);
        $stmt->bindValue(1, $chat_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    private function updateStatus($chat_id, $new_status)
    {
        $update_query = "UPDATE status SET status=? WHERE client_id=?";

        $stmt = $this->conn->prepare($update_query);
        $stmt->bindValue(1, $new_status, PDO::PARAM_STR);
        $stmt->bindValue(2, $chat_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function createStatus($chat_id, $status)
    {
        $insert_query = "INSERT INTO status(`client_id`, `status`) VALUES (?, ?)";
        $stmt = $this->conn->prepare($insert_query);
        $stmt->bindValue(1, $chat_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $status, PDO::PARAM_STR);
        $stmt->execute();
    }
}