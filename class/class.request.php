<?php
include_once("./db/db.php");
include_once("./class/class.notification.php");
include_once("./class/class.history.php");

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

        // Check if a request already exists
        $checkSql = "SELECT * FROM requests WHERE post_id = ? AND req_user = ? AND req_receiver = ?";
        try {
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bind_param("iii", $postId, $userId, $receiver);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                // If a request already exists
                $_SESSION['message'] = "A request for this post already exists.";
                return;
            }
        } catch (\Throwable $th) {
            echo "Error checking existing request: " . $th->getMessage();
            return;
        }

        // Proceed with insertion if no existing request is found
        $sql = "INSERT INTO requests (post_id, req_user, req_receiver, req_accepted, req_donated) VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiii", $postId, $userId, $receiver, $accepted, $donated);

            if ($stmt->execute()) {
                // Add a notification for the request
                $notObj = new Notification();
                $notObj->insertNotification($userId, $receiver, $postId, "request");
                $_SESSION['message'] = "Request added successfully.";
            }
        } catch (\Throwable $th) {
            echo "Error inserting request: " . $th->getMessage();
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

    public function deleteRequest($postId, $userId)
    {
        // Check if the request exists
        $checkSql = "SELECT * FROM requests WHERE post_id = ? AND req_user = ?";
        try {
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bind_param("ii", $postId, $userId);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows === 0) {
                // If no matching request is found
                $_SESSION['message'] = "No such request exists.";
                return false;
            }
        } catch (\Throwable $th) {
            echo "Error checking existing request: " . $th->getMessage();
            return false;
        }

        // Proceed to delete the request if it exists
        $sql = "DELETE FROM requests WHERE post_id = ? AND req_user = ?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $postId, $userId);

            if ($stmt->execute()) {
                // Delete the associated notification
                $notObj = new Notification();
                $notObj->deleteNotification($postId, $userId);
                $_SESSION['message'] = "Request deleted successfully.";
                return true;
            } else {
                $_SESSION['message'] = "Failed to delete the request.";
                return false;
            }
        } catch (\Throwable $th) {
            echo "Error deleting request: " . $th->getMessage();
            return false;
        }
    }


    public function acceptRequest($reqId, $postId, $userId, $receiver)
    {
        $isAccept = 1;
        $sql = "UPDATE requests SET req_accepted=? WHERE req_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $isAccept, $reqId);

            if ($stmt->execute()) {
                $notObj = new Notification();
                $notObj->insertNotification($userId, $receiver, $postId, "accept");
                $_SESSION['message'] = "Save changed.";
            } else {
                $_SESSION['message'] = "Something went wrong.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function completeDonation($reqId, $postId, $userId, $receiver)
    {
        $isDonate = 1;
        $sql = "UPDATE requests SET req_donated=? WHERE req_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $isDonate, $reqId);

            if ($stmt->execute()) {
                $notObj = new Notification();
                $notObj->insertNotification($userId, $receiver, $postId, "donated");

                $histObj = new History();
                $histObj->insertHistory($postId);
                $_SESSION['message'] = "Save changed.";
            } else {
                $_SESSION['message'] = "Something went wrong.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }
}
