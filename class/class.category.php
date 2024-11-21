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

    public function insertCategories($cat_name, $cat_duration)
    {
        $sql = "INSERT INTO categories (cat_name, cat_duration) VALUES (?, ?)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $cat_name, $cat_duration);


            if ($stmt->execute()) {
                $_SESSION['message'] = "Category added successfully.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
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

    public function fetchCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE cat_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function updateCategory($catId, $name, $duration)
    {
        $sql = "UPDATE categories SET cat_name=?, cat_duration=? WHERE cat_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $duration, $catId);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Save changed.";
            } else {
                $_SESSION['message'] = "Something went wrong.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE cat_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Deleted successfully.";
            } else {
                $_SESSION['message'] = "Something went wrong.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }
}
