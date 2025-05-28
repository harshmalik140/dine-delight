<?php
include 'db.php'; // Make sure this has your DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Dine Delight</title>
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
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="categories">
            <div class="categories-content">
                <h2>Our Categories</h2>
                <div class="categories-grid">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_assoc($result)):
                        $image = (!empty($row['image']) && file_exists($row['image'])) ? $row['image'] : 'https://via.placeholder.com/250x150';
                    ?>
                        <div class="category">
                            <a href="user-dishes.php?category_id=<?= $row['id'] ?>" style="text-decoration:none;">
                                <img src="<?= $image ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                                <h3><?= htmlspecialchars($row['name']) ?></h3>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
