<?php
include_once("./db/db.php");
include_once("./class/class.notification.php");

class Request
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->createConnection();
    }

    public function insertRequest($postId, $userId, $receiver)
    {
        $accepted = 0;
        $donated = 0;
        $sql = "INSERT INTO requests (post_id, req_user, req_receiver req_accepted, req_donated) VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiii", $postId, $userId, $receiver, $accepted, $donated);


            if ($stmt->execute()) {
                $notObj = new Notification();
                $notObj->insertNotification($userId, $receiver, $postId, "request");
                $_SESSION['message'] = "Request added successfully.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function fetchRequestByUserId($postId, $userId)
    {
        $sql = "SELECT * FROM requests WHERE post_id=? AND req_user=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $postId, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                //return $result->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function fetchRequestById($postId)
    {
        $sql = "SELECT * FROM requests INNER JOIN users ON req_user = user_id WHERE post_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $postId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
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
