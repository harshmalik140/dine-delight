<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to order!'); window.location.href='user-login.html';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['final_order_btn'])) {
    $dish_id = $_POST['dish_id'];
    $price = $_POST['price'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = $_POST['payment_method'];

    $sql = "INSERT INTO orders (user_id, dish_id, total_price, address, payment_method)
            VALUES ('$user_id', '$dish_id', '$price', '$address', '$payment_method')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Order placed successfully!'); window.location.href='user-categories.php';</script>";
    } else {
        echo "<script>alert('Failed to place order.'); window.history.back();</script>";
    }

} elseif (isset($_POST['order_btn'])) {
    // Old fallback (not used anymore but just in case)
    $dish_id = $_POST['dish_id'];
    $price = $_POST['price'];
    header("Location: order-details.php");
    exit;
} else {
    echo "<script>alert('Invalid access.'); window.history.back();</script>";
}
?>
