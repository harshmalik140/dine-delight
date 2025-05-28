<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // First, check if it's the admin email
    if ($email === "admin@dinedelight.com") {
        // Check admin credentials from settings table
        $stmt = $conn->prepare("SELECT admin_password FROM settings WHERE admin_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($admin_hashed_password);
            $stmt->fetch();

            if (password_verify($password, $admin_hashed_password)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_email'] = $email;

                header("Location: admin-dashboard.php");
                exit();
            } else {
                echo "Invalid admin password.";
            }
        } else {
            echo "Admin account not found.";
        }

        $stmt->close();
    } else {
        // Regular user login
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;

                if (isset($_POST['redirect_after_login']) && !empty($_POST['redirect_after_login'])) {
                    header("Location: " . $_POST['redirect_after_login']);
                    exit();
                }

                header("Location: user-index.html");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
