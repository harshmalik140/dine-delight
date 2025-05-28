<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = $_POST['site_name'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    // Hash the password securely before storing
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE settings SET site_name=?, admin_email=?, admin_password=? WHERE id=1");
    $stmt->bind_param("sss", $site_name, $admin_email, $hashed_password);
    
    if ($stmt->execute()) {
        $message = "Settings updated successfully!";
    } else {
        $message = "Error updating settings.";
    }
}

// Fetch current settings (excluding password for security)
$settings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT site_name, admin_email FROM settings WHERE id = 1"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Dine Delight</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Dine Delight</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin-dashboard.php">Dashboard</a></li>
            <li><a href="admin-menu-management.php">Menu Management</a></li>
            <li><a href="admin-order-management.php">Order Management</a></li>
            <li><a href="admin-users.php">Users</a></li>
            <li><a href="admin-settings.php" class="active">Settings</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <h1>Settings</h1>
        </header>
        <section class="settings">
            <?php if ($message): ?>
                <p style="color: green;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="site-name">Site Name</label>
                    <input type="text" id="site-name" name="site_name" value="<?= htmlspecialchars($settings['site_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="admin-email">Admin Email</label>
                    <input type="email" id="admin-email" name="admin_email" value="<?= htmlspecialchars($settings['admin_email']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">New Admin Password</label>
                    <input type="password" id="password" name="admin_password" placeholder="Enter new password" required>
                </div>
                <button type="submit" class="btn save-btn">Save Changes</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>
