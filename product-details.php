<?php
session_start();
require_once("connect-db.php");


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
$productId = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE product_id = :product_id";
$statement = $db->prepare($sql);
$statement->bindValue(':product_id', $productId, PDO::PARAM_INT);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

if (!$product) {
    echo "<p>Product not found.</p>";
    exit();
}
} else {
    echo "<p>Invalid request.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>

<body>
    <div class="container my-5">
        <?php include "header.php"; ?>
        
        <div class="row">
            <div class="col-md-6">
                <img src="images/<?php echo $product['image_url']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="lead">$<?php echo number_format($product['price'], 2); ?></p>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                <form action="add-to-cart.php" method="post" class="mt-4">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" min="1" value="1" class="form-control w-25" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                </form>
            </div>
        </div>

        <div class="mt-5">
            <?php include "footer.php"; ?>
        </div>
    </div>
</body>
</html>
