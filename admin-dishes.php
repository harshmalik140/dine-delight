<?php
include 'db.php';

$upload_dir = 'uploads/';

// Add Dish
if (isset($_POST['add_dish'])) {
    $name = $_POST['dish_name'];
    $price = $_POST['dish_price'];
    $category_id = $_POST['dish_category'];
    $image = '';

    if ($_FILES['dish_image']['name']) {
        $image = basename($_FILES['dish_image']['name']);
        $target_file = $upload_dir . $image;
        move_uploaded_file($_FILES['dish_image']['tmp_name'], $target_file);
    }

    $sql = "INSERT INTO dishes (name, price, category_id, image) VALUES ('$name', '$price', '$category_id', '$image')";
    mysqli_query($conn, $sql);
    header("Location: admin-dishes.php?category_id=$category_id");
}

// Delete Dish
if (isset($_GET['delete_dish'])) {
    $id = $_GET['delete_dish'];
    $cat_id = $_GET['cat_id'];
    mysqli_query($conn, "DELETE FROM dishes WHERE id=$id");
    header("Location: admin-dishes.php?category_id=$cat_id");
}

// Update Dish Image
if (isset($_POST['update_dish_image'])) {
    $dish_id = $_POST['dish_id'];
    $cat_id = $_POST['cat_id'];

    if ($_FILES['new_dish_image']['name']) {
        $image = basename($_FILES['new_dish_image']['name']);
        $target_file = $upload_dir . $image;
        move_uploaded_file($_FILES['new_dish_image']['tmp_name'], $target_file);
        mysqli_query($conn, "UPDATE dishes SET image='$image' WHERE id=$dish_id");
    }

    header("Location: admin-dishes.php?category_id=$cat_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dish Management - Dine Delight</title>
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
                <h1>Dish Management</h1>
            </header>

            <section class="report-section">
                <?php if (isset($_GET['category_id'])):
                    $category_id = $_GET['category_id'];
                    $category = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE id=$category_id"));
                ?>
                    <h2>Manage Dishes in Category: <?= htmlspecialchars($category['name']) ?></h2>

                    <!-- Add Dish Form -->
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="dish_category" value="<?= $category_id ?>">
                        <div class="form-group">
                            <input type="text" name="dish_name" placeholder="Dish Name" required>
                            <input type="number" step="0.01" name="dish_price" placeholder="Price" required>
                            <input type="file" name="dish_image" accept="image/*" required>
                            <button type="submit" name="add_dish" class="btn save-btn">Add Dish</button>
                        </div>
                    </form>

                    <!-- Dish Table -->
                    <table class="data-table order-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Image</th>
                                <th>Dish Name</th>
                                <th>Price</th>
                                <th>Change Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $dishResult = mysqli_query($conn, "SELECT * FROM dishes WHERE category_id=$category_id");
                        $sn = 1;
                        while ($dish = mysqli_fetch_assoc($dishResult)): ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td>
                                    <?php if ($dish['image'] && file_exists("uploads/{$dish['image']}")): ?>
                                        <img src="uploads/<?= $dish['image'] ?>" style="height:50px; width:50px; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50" style="height:50px; width:50px; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($dish['name']) ?></td>
                                <td>$<?= number_format($dish['price'], 2) ?></td>
                                <td>
                                    <form method="post" enctype="multipart/form-data" style="display:inline;">
                                        <input type="hidden" name="dish_id" value="<?= $dish['id'] ?>">
                                        <input type="hidden" name="cat_id" value="<?= $category_id ?>">
                                        <input type="file" name="new_dish_image" accept="image/*" required>
                                        <button type="submit" name="update_dish_image" class="btn edit-btn">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="admin-dishes.php?delete_dish=<?= $dish['id'] ?>&cat_id=<?= $category_id ?>" class="btn delete-btn" onclick="return confirm('Delete dish?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h2>Please select a category from <a href="admin-menu-management.php">Menu Management</a> to manage dishes.</h2>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>
