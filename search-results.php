<?php
session_start();
require_once("connect-db.php");

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

$products = [];

if ($query !== '') {
    $sql = "SELECT * FROM products WHERE name LIKE :query OR description LIKE :query";
    $statement = $db->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $statement->bindValue(':query', $searchTerm, PDO::PARAM_STR);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="container">
        <?php include "header.php"; ?>

        <h2 class="my-4">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

        <?php if (empty($products)) { ?>
            <p>No products found.</p>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                                <form action="add-to-cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="number" name="quantity" min="1" value="1" class="form-control mb-2" required>
                                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>

        <?php include "footer.php"; ?>
    </div>
</body>
</html>
