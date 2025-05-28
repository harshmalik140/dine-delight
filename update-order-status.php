<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);

    $update = "UPDATE orders SET status = 'Completed' WHERE id = $orderId";
    if (mysqli_query($conn, $update)) {
        header("Location: admin-order-management.php");
        exit();
    } else {
        echo "Failed to update order status.";
    }
} else {
    echo "Invalid request.";
}
?>
