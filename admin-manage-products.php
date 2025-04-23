<?php
require_once("admin-auth.php");
require_once("connect-db.php");

$sql = "SELECT * FROM products";
$statement = $db->prepare($sql);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();
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
                $barProducts = array_filter($products, fn($p) => $p['category_id'] == 1);
                foreach ($barProducts as $product): ?>
                    <div class="card product-card">
                        <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body d-grid gap-2">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">
                                <strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?><br>
                                <strong>Stock:</strong> <?php echo $product['stock_quantity']; ?>
                            </p>
                            <a href="admin-update-product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary btn-sm w-100 mb-2">Edit</a>
                            <form action="admin-process-delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="my-4">
        <h3>Cereals</h3>
        <div class="product-slider-wrapper">
            <div class="product-slider">
                <?php
                $cerealProducts = array_filter($products, fn($p) => $p['category_id'] == 2);
                foreach ($cerealProducts as $product): ?>
                    <div class="card product-card">
                        <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body d-grid gap-2">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">
                                <strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?><br>
                                <strong>Stock:</strong> <?php echo $product['stock_quantity']; ?>
                            </p>
                            <a href="admin-update-product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary btn-sm w-100 mb-2">Edit</a>
                            <form action="admin-process-delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
</div>
</body>
</html>
