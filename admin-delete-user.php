<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
}

header('Location: admin-users.php');
exit;
