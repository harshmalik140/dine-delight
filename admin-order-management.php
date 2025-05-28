<?php
include 'db.php';

$query = "
    SELECT 
        o.id AS order_id,
        u.name AS customer_name,
        d.name AS dish_name,
        o.total_price,
        o.status,
        o.address,
        o.payment_method,
        o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN dishes d ON o.dish_id = d.id
    ORDER BY o.id DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Dine Delight</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Dine Delight</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="admin-menu-management.php">Menu Management</a></li>
                <li><a href="admin-order-management.php">Order Management</a></li>
                <li><a href="admin-users.php">Users</a></li>
                <li><a href="admin-settings.php
                ">Settings</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <h1>Order Management</h1>
            </header>
            <section class="order-management">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Dish</th>
                            <th>Total</th>
                            <th>Address</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td><?= htmlspecialchars($order['dish_name']) ?></td>
                            <td>$<?= htmlspecialchars($order['total_price']) ?></td>
                            <td><?= nl2br(htmlspecialchars($order['address'])) ?></td>
                            <td><?= htmlspecialchars($order['payment_method']) ?></td>
                            <td><span class="status <?= strtolower($order['status']) ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                            <td>
                                <?php if (strtolower($order['status']) !== 'completed'): ?>
                                <form method="post" action="update-order-status.php" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <button type="submit" class="btn complete-btn">Mark as Complete</button>
                                </form>
                                <?php else: ?>
                                    <span style="color: green;">✔ Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
