<?php
include_once("./db/db.php");

class Post
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->createConnection();
    }

    public function createPost($userId, $foodName, $categoryId, $details, $imageName)
    {
        $fileArray = $this->uploadFile($imageName);
        $fileName = $fileArray['fileName'];
        $fileTemp = $fileArray['fileTemp'];
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO posts (user_id, post_food, cat_id, post_details, post_photo, post_date, post_approved) 
                VALUES (?, ?, ?, ?, ?, NOW(), 1)"
            );
            $stmt->bind_param("isiss", $userId, $foodName, $categoryId, $details, $fileName);

            if ($stmt->execute()) {
                move_uploaded_file($fileTemp, "uploads/post/" . $fileName);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function uploadFile($file)
    {
        if (is_array($file)) {
            $fileName = $file['name'];
            $fileTemp = $file['tmp_name'];

            $exts = ['png', 'jpg', 'jpeg'];

            $a = explode(".", $fileName);
            $fileExtension = strtolower(end($a));

            if (in_array($fileExtension, $exts) == false) {
                $_SESSION['message'] = "Invalid file.";
                exit;
            } else {
                return ['fileName' => $fileName, 'fileTemp' => $fileTemp];
            }
        } else {
            return $file;
        }
    }

    public function fetchPosts()
    {
        try {
            $sql = "SELECT * FROM users INNER JOIN posts on users.user_id = posts.user_id INNER JOIN categories ON posts.cat_id = categories.cat_id ORDER BY posts.post_date DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $_SESSION['message'] = "No post found.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function fetchPostsByUserId($id)
    {
        try {
            $sql = "SELECT * FROM users INNER JOIN posts on users.user_id = posts.user_id INNER JOIN categories ON posts.cat_id = categories.cat_id WHERE users.user_id = ? ORDER BY posts.post_date DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $_SESSION['message'] = "No post found.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function fetchPostsById($id)
    {
        try {
            $sql = "SELECT * FROM users INNER JOIN posts on users.user_id = posts.user_id INNER JOIN categories ON posts.cat_id = categories.cat_id WHERE posts.post_id = ? ORDER BY posts.post_date DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $_SESSION['message'] = "No post found.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }
}
