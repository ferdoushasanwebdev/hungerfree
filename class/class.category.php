<?php
include_once("./db/db.php");

class Category
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->createConnection();
    }

    public function fetchCategories()
    {
        $sql = "SELECT * FROM categories";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }
}
