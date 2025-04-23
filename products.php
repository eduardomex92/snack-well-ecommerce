<?php
session_start();
require_once("connect-db.php");

$message = "";
$sql = "SELECT * FROM products";
$statement = $db->prepare($sql);

if ($statement->execute()) {
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
} else {
    $message = "Error loading products";
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "includes/head.php"; ?>

<body>
    <div class="container-fluid px-5">
    <?php include "header.php"; ?>
        <div class="my-4">
            <h3>Bars</h3>
            <div class="product-slider-wrapper">
                <div class="product-slider">
                    <?php
                    $barProducts = array_filter($products, function ($product) {
                        return $product['category_id'] == 1;
                    });
                    foreach ($barProducts as $product) { ?>
                        <div class="card" style="width: 16rem; flex: 0 0 auto;">
                            <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top"
                                alt="<?php echo $product['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </h5>
                                <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                                <form action="add-to-cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="number" name="quantity" min="1" value="1" class="form-control mb-2"
                                        required>
                                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="my-4">
            <h3>Cereals</h3>
            <div class="product-slider-wrapper">
                <div class="product-slider">
                    <?php
                    $cerealProducts = array_filter($products, function ($product) {
                        return $product['category_id'] == 2;
                    });
                    foreach ($cerealProducts as $product) { ?>
                        <div class="card" style="width: 16rem; flex: 0 0 auto;">
                            <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top"
                                alt="<?php echo $product['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </h5>
                                <p class="card-text">$<?php echo number_format($product['price'], 2); ?></p>
                                <form action="add-to-cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="number" name="quantity" min="1" value="1" class="form-control mb-2"
                                        required>
                                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </div>
</body>

</html>