<?php
// user-dishes.php
session_start();
include 'db.php';

if (!isset($_GET['category_id'])) {
    header("Location: user-categories.php");
    exit;
}
$category_id = $_GET['category_id'];
$category = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE id=$category_id"));
$dishes = mysqli_query($conn, "SELECT * FROM dishes WHERE category_id=$category_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dishes - Dine Delight</title>
    <link rel="stylesheet" href="categories.css">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <h1>Dine Delight</h1>
        </div>
        <nav>
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
    <section class="categories">
        <div class="categories-content">
            <h2><?= htmlspecialchars($category['name']) ?> Dishes</h2>
            <div class="categories-grid">
                <?php while ($dish = mysqli_fetch_assoc($dishes)): ?>
                    <div class="category">
                        <img src="<?= 'uploads/' . $dish['image'] ?>" alt="<?= htmlspecialchars($dish['name']) ?>">
                        <h3><?= htmlspecialchars($dish['name']) ?></h3>
                        <p>Price: $<?= number_format($dish['price'], 2) ?></p>

                        <form method="post" action="order-details.php">
                            <input type="hidden" name="dish_id" value="<?= $dish['id'] ?>">
                            <input type="hidden" name="price" value="<?= $dish['price'] ?>">
                            <button type="submit">Order</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</main>
</body>
</html>
