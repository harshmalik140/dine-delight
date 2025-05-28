<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - Dine Delight</title>
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
                <li><a href="admin-settings.php">Settings</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <h1>Users Management</h1>
            </header>
            <section class="users-management">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM users");
                        while ($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= ucfirst($row['role'] ?? 'Customer') ?></td>
                            <td>
                                <form method="POST" action="admin-delete-user.php" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                    <button class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
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
