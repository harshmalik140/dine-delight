<?php
include 'db.php';

// Get total users
$userResult = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$userData = mysqli_fetch_assoc($userResult);

// Get total orders
$orderResult = mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM orders");
$orderData = mysqli_fetch_assoc($orderResult);

// Get total revenue
$revenueResult = mysqli_query($conn, "SELECT SUM(total_price) AS total_revenue FROM orders WHERE status = 'Completed'");
$revenueData = mysqli_fetch_assoc($revenueResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Dine Delight</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 30px;
}

.card {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #444;
    font-weight: 600;
}

.card p {
    font-size: 28px;
    color: #008080;
    font-weight: bold;
}

.card:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Dine Delight</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php" class="active">Dashboard</a></li>
                <li><a href="admin-menu-management.php">Menu Management</a></li>
                <li><a href="admin-order-management.php">Order Management</a></li>
                <li><a href="admin-users.php">Users</a></li>
                <li><a href="admin-settings.php">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <h1>Admin Dashboard</h1>
            </header>
            <section class="dashboard-cards">
                <div class="card">
                    <h3>Total Users</h3>
                    <p><?= $userData['total_users'] ?></p>
                </div>
                <div class="card">
                    <h3>Total Orders</h3>
                    <p><?= $orderData['total_orders'] ?></p>
                </div>
                <div class="card">
                    <h3>Total Revenue</h3>
                    <p>$<?= number_format($revenueData['total_revenue'], 2) ?></p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
