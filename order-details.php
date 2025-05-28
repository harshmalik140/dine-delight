<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'order-details.php';
    $_SESSION['order_data'] = $_POST;
    header("Location: user-login.html");
    exit;
}

if (isset($_SESSION['order_data'])) {
    $_POST = $_SESSION['order_data'];
    unset($_SESSION['order_data']);
}

if (!isset($_POST['dish_id']) || !isset($_POST['price'])) {
    header("Location: user-categories.php");
    exit;
}

$dish_id = $_POST['dish_id'];
$price = $_POST['price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details - Dine Delight</title>
    <link rel="stylesheet" href="user-hero.css">
    <style>
        .form-container {
            max-width: 600px;
            color: black;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.92);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        label {
            font-weight: bold;
            margin: 10px 0 5px;
            display: block;
        }

        textarea, input[type="radio"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            background-color: #ff6347;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #e3533f;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <h1>Dine Delight</h1>
        </div>
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="user-index.html">Home</a></li>
                <li><a href="user-about.html">About Us</a></li>
                <li><a href="user-categories.php">Categories</a></li>
                <li><a href="user-contact.html">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="user-logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="user-login.html">Login</a></li>
                    <li><a href="user-register.html">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="form-container">
            <h2>Confirm Your Order</h2>
            <form method="post" action="place-order.php">
                <input type="hidden" name="dish_id" value="<?= htmlspecialchars($dish_id) ?>">
                <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">

                <label for="address">Delivery Address:</label>
                <textarea name="address" id="address" required></textarea>

                <label>Payment Method:</label>
                <input type="radio" name="payment_method" value="COD" checked> Cash on Delivery

                <button type="submit" name="final_order_btn">Place Order</button>
            </form>
        </div>
    </section>
</main>
</body>
</html>
