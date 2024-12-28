<?php
include_once("./db/db.php");

class User
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->createConnection();
    }

    public function login($phone, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_phone = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $result = $result->fetch_all(MYSQLI_ASSOC);

                if (password_verify($password, $result[0]['user_password'])) {
                    if ($result[0]['user_approved'] == false) {
                        header("Location: message.php");
                    } else {
                        session_start();
                        $_SESSION['user_id'] = $result[0]['user_id'];
                        $_SESSION['user_name'] = $result[0]['user_name'];
                        $_SESSION['user_phone'] = $result[0]['user_phone'];
                        $_SESSION['user_email'] = $result[0]['user_email'];
                        $_SESSION['user_district'] = $result[0]['user_district'];
                        $_SESSION['user_division'] = $result[0]['user_division'];
                        $_SESSION['user_role'] = $result[0]['user_role'];

                        header("Location: dashboard.php");
                    }
                } else {
                    session_start();
                    $_SESSION['message'] = "Invalid phone number or password.";
                }
            } else {
                session_start();
                $_SESSION['message'] = "Invalid phone number or password.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function signUp($name, $phone, $email, $password, $file, $role)
    {
        $fileArray = $this->uploadFile($file);
        $fileName = $fileArray['fileName'];
        $fileTemp = $fileArray['fileTemp'];
        $approved = 0;
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        try {
            $this->uploadFile($file);
            $sql = "SELECT * FROM users WHERE user_phone = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                session_start();
                $_SESSION['error'] = "User already exists.";
            } else {
                $sql = "INSERT INTO users (user_name, user_phone, user_email, user_password, user_file, user_role, user_approved) VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssssssi", $name, $phone, $email, $hashed_password, $fileName, $role, $approved);

                if ($stmt->execute()) {
                    move_uploaded_file($fileTemp, "uploads/certificate/" . $fileName);
                    header("Location: message.php");
                }
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

    public function fetchUserById($userid)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                session_start();
                $_SESSION['message'] = "No users found.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function fetchUnapprovedUsers()
    {
        $approved = 0;
        try {
            $sql = "SELECT * FROM users WHERE user_approved = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $approved);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $_SESSION['message'] = "No pending users.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function updateUser($userid, $name, $email, $address, $district, $division, $newpassword, $confirmpassword, $photo)
    {
        $fileArray = $this->uploadFile($photo);
        if (is_array($fileArray)) {
            $fileName = $fileArray['fileName'];
            $fileTemp = $fileArray['fileTemp'];
        } else {
            $fileName = $photo;
        }

        try {
            if (!empty($newpassword) && !empty($confirmpassword)) {
                if ($newpassword == $confirmpassword) {
                    $password = password_hash($newpassword, PASSWORD_BCRYPT);
                    $sql = "UPDATE users SET user_name=?, user_email=?, user_address=?, user_district=?, user_division=?, user_password=?, user_photo=? WHERE user_id=?";

                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sssssssi", $name, $email, $address, $district, $division, $password, $fileName, $userid);

                    if ($stmt->execute()) {
                        if (isset($fileTemp)) {
                            move_uploaded_file($fileTemp, "uploads/photo/" . $fileName);
                        }
                        $_SESSION['message'] = "saved change.";
                        $_SESSION['user_name'] = $name;
                        $_SESSION['user_email'] = $email;
                    }
                } else {
                    $_SESSION['message'] = "password not matched.";
                    $this->conn->close();
                }
            } else {
                $sql = "UPDATE users SET user_name=?, user_email=?, user_address=?, user_district=?, user_division=?, user_photo=? WHERE user_id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssssssi", $name, $email, $address, $district, $division, $fileName, $userid);

                if ($stmt->execute()) {
                    if (isset($fileTemp)) {
                        move_uploaded_file($fileTemp, "uploads/photo/" . $fileName);
                    }
                    $_SESSION['message'] = "saved change.";
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                }
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function approveUser($userid)
    {
        $approved = 1;
        try {
            $sql = "UPDATE users SET user_approved=? WHERE user_id=?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $approved, $userid);

            if ($stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF']);
            } else {
                $_SESSION['message'] = "Something went wrong.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function removeUser($userid)
    {
        try {
            $sql = "DELETE FROM users WHERE user_id=?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userid);

            if ($stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF']);
            } else {
                $_SESSION['message'] = "Something went wrong.";
            }
        } catch (\Throwable $th) {
            echo ($th);
        }
    }

    public function countDonor()
    {
        $role = "donor";
        try {
            $sql = "SELECT COUNT(*) AS donor_count FROM users WHERE user_role=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $role);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['donor_count']; // Return the count of donors
            } else {
                $_SESSION['message'] = "Something went wrong.";
                return 0; // Return 0 if query execution fails
            }
        } catch (\Throwable $th) {
            echo ($th);
            return 0; // Return 0 in case of an exception
        }
    }
}
