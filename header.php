<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$adminLoggedIn = isset($_SESSION["admin_id"]) && isset($_SESSION["admin-login"]) && $_SESSION["admin-login"] == true;
$customerLoggedIn = isset($_SESSION["customer_id"]) && isset($_SESSION["customer-login"]) && $_SESSION["customer-login"] == true;
?>
<header class="site-header">
    <div class="header-top-content">
        <img src="images/Logos_Icons/logos/snackwell-logo.jpg" alt="Snack Well Logo" id="logo-small">
    </div>
    <div class="header-center-content">
        <img src="images/Logos_Icons/logos/snackwell-TypeLogo.jpg" alt="Snack Well Logo" id="header-logo">
    </div>
    <div class="header-top-links">
        <ul class="list-unstyled text-end mb-0">
            <?php if ($adminLoggedIn): ?>
                <li><a href="logout.php" class="text-decoration-none fw-bold text-primary">Log out</a></li>
            <?php elseif ($customerLoggedIn): ?>
                <li><a href="logout.php" class="text-decoration-none fw-bold text-primary">Log out</a></li>
                <li>
                    <a href="cart.php">
                        <img src="images/Logos_Icons/Icons/cart-icon.jpg" alt="Cart Icon" class="cart-icon">
                        <br>
                        Cart
                    </a>
                </li>
            <?php else: ?>
                <li><a href="customer-login.php">Login</a></li>
                <li><a href="create-account.php">Sign Up</a></li>
                <li><a href="cart.php">
                        <img src="images/Logos_Icons/Icons/cart-icon.jpg" alt="Cart Icon" class="cart-icon">
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <form class="d-flex search-bar w-100" action="search-results.php" method="get" style="max-width: 280px;">
        <input class="form-control me-2" type="search" name="query" placeholder="Search products..." aria-label="Search"
            required>
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
</header>

<!-- navigation bar -->
<nav class="bg-light border-top border-bottom mt-3">
    <ul class="nav justify-content-center flex-wrap gap-3 py-2">
        <?php
        if ($adminLoggedIn) {
            echo '
        <li class="nav-item"><a class="nav-link active" href="admin-manage-products.php">Manage Products</a></li>
        <li class="nav-item"><a class="nav-link active" href="admin-add-product.php">Add Products</a></li>
        <li class="nav-item"><a class="nav-link active" href="admin-orders.php">View Orders History</a></li>
        <li class="nav-item"><a class="nav-link active" href="admin-contacts.php">Contact Messages</a></li>
      ';
        } elseif ($customerLoggedIn) {
            echo '
        <li class="nav-item"><a class="nav-link active" href="my-account.php">My Account</a></li>
        <li class="nav-item"><a class="nav-link active" href="products.php">Order Now</a></li>
        <li class="nav-item"><a class="nav-link active" href="customer-orders.php">Order History</a></li>
        <li class="nav-item"><a class="nav-link active" href="update-account.php">Update Account</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
      ';
        } else {
            echo '
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link active" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
      ';
        }
        ?>
    </ul>
</nav>