<?php
include_once("./db/db.php");

class History
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->createConnection();
    }

    public function insertHistory($postId)
    {
        $sql = "INSERT INTO histories (hist_post) VALUES (?)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $postId);


            if ($stmt->execute()) {
                $_SESSION['message'] = "Category added successfully.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function countHistory()
    {
        $sql = "SELECT COUNT(*) AS row_count FROM  histories";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['row_count']; // Return the row count
            }
            return 0; // Return 0 if no rows are found
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function countHistoryById($id)
    {
        $sql = "SELECT COUNT(*) AS row_count FROM posts INNER JOIN histories ON post_id = hist_post WHERE user_id=?";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['row_count']; // Return the row count
            }
            return 0; // Return 0 if no rows are found
        } catch (\Throwable $th) {
            echo ($th);
        }
    }


    public function fetchDonationByDivisions()
    {
        $sql = "SELECT 
                users.user_division AS division, 
                COUNT(posts.post_id) AS donation_count
            FROM 
                users
            INNER JOIN 
                posts ON users.user_id = posts.user_id
            INNER JOIN
                histories ON posts.post_id = histories.hist_post
            GROUP BY 
                users.user_division";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $divisions = [];
            while ($row = $result->fetch_assoc()) {
                $divisions[] = $row;
            }

            return $divisions;
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
            return [];
        }
    }

    public function fetchHistoryByDate()
    {
        $sql = "SELECT 
                DATE_FORMAT(hist_date, '%Y-%m') AS month, 
                COUNT(*) AS history_count
            FROM 
                histories
            GROUP BY 
                DATE_FORMAT(hist_date, '%Y-%m')";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $historyByDate = [];
            while ($row = $result->fetch_assoc()) {
                $historyByDate[] = $row;
            }

            return $historyByDate;
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage(); // Debugging purpose
            return [];
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
