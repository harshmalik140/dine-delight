<?php
include 'db.php';

// Add Category
if (isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $image = '';

    if (!empty($_FILES['category_image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['category_image']['name']);
        $image = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['category_image']['tmp_name'], $image);
    }

    $sql = "INSERT INTO categories (name, image) VALUES ('$name', '$image')";
    mysqli_query($conn, $sql);
    header("Location: admin-menu-management.php");
}

// Change Category Image
if (isset($_POST['update_image'])) {
    $id = $_POST['category_id'];
    if (!empty($_FILES['new_image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['new_image']['name']);
        $image = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['new_image']['tmp_name'], $image);
        mysqli_query($conn, "UPDATE categories SET image='$image' WHERE id=$id");
    }
    header("Location: admin-menu-management.php");
}

// Delete Category
if (isset($_GET['delete_category'])) {
    $id = $_GET['delete_category'];
    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    mysqli_query($conn, "DELETE FROM dishes WHERE category_id=$id");
    header("Location: admin-menu-management.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu Management - Dine Delight</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <li><a class="active" href="admin-menu-management.php">Menu Management</a></li>
                <li><a href="admin-order-management.php">Order Management</a></li>
                <li><a href="admin-users.php">Users</a></li>
                <li><a href="admin-settings.php">Settings</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <h1>Menu Management</h1>
            </header>

            <section class="report-section">
                <h2>Add New Category</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="category_name" placeholder="Category Name" required>
                    </div>
                    <div class="form-group">
                        <input type="file" name="category_image" accept="image/*">
                    </div>
                    <button type="submit" name="add_category" class="btn save-btn">Add Category</button>
                </form>
            </section>

            <section class="report-section">
                <h2>All Categories</h2>
                <table class="data-table order-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $catResult = mysqli_query($conn, "SELECT * FROM categories");
                        $sn = 1;
                        while ($cat = mysqli_fetch_assoc($catResult)):
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td>
                                <?php if (!empty($cat['image']) && file_exists($cat['image'])): ?>
                                    <img src="<?= $cat['image'] ?>" alt="<?= $cat['name'] ?>" style="height:50px; width:50px; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/50" alt="No Image" style="height:50px; width:50px; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($cat['name']) ?></td>
                            <td>
                                <a href="admin-dishes.php?category_id=<?= $cat['id'] ?>" class="btn view-btn">View Dishes</a>
                                <a href="admin-menu-management.php?delete_category=<?= $cat['id'] ?>" class="btn delete-btn" onclick="return confirm('Delete this category?')">Delete</a>

                                <form method="post" enctype="multipart/form-data" style="margin-top: 10px;">
                                    <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                                    <input type="file" name="new_image" accept="image/*" required>
                                    <button type="submit" name="update_image" class="btn edit-btn">Change Image</button>
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
