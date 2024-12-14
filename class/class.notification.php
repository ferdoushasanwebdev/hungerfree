<?php
include_once("./db/db.php");

class Notification
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->createConnection();
    }

    public function insertNotification($sender, $receiver, $postId, $type)
    {
        $isRead = 0;
        $sql = "INSERT INTO notifications (not_sender, not_receiver, not_post, not_type, not_read, not_date) VALUES (?, ?, ?, ?, ?, NOW())";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiisi", $sender, $receiver, $postId, $type, $isRead);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Notification added successfully.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function fetchNotificationById($userId)
    {
        $sql = "SELECT 
                notifications.*, 
                users.user_name AS sender_name
            FROM 
                notifications
            INNER JOIN 
                users ON users.user_id = notifications.not_sender
            INNER JOIN 
                posts ON posts.post_id = notifications.not_post
            WHERE 
                notifications.not_receiver = ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
    }

    public function updateNotificationStatus($id)
    {
        $isRead = 1;
        $sql = "UPDATE notifications SET not_read=? WHERE not_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $isRead, $id);

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
