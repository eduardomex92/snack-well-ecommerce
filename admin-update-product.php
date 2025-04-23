<?php
require_once("admin-auth.php");
require_once("connect-db.php");

$product = null;
$error = "";

// Load product details
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);


    $sql = "SELECT * FROM products WHERE product_id = :id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':id', $productId, PDO::PARAM_INT);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if (!$product) {
        $error = "Product not found.";
    }
} else {
    $error = "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
<div class="container my-5">
    <?php include "header.php"; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($product): ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <fieldset>
                    <legend>Edit Product</legend>
                    <form action="admin-process-update.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                        <h5><strong>Name:</strong> <?php echo htmlspecialchars($product['name']); ?></h5>
                        <p><strong>Category:</strong>
                            <?php echo ($product['category_id'] == 1) ? "Bars" : "Cereal"; ?></p>
                        <p><strong>Image:</strong><br>
                            <img src="images/<?php echo $product['image_url']; ?>" alt="Product Image" width="150">
                        </p>

                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description" rows="5" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        <br>

                        <label for="price">Price:</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $product['price']; ?>" required>
                        <br>

                        <label for="stock">Stock Quantity:</label>
                        <input type="number" class="form-control" name="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required>
                        <br>

                        <button type="submit" class="btn btn-success">Update Product</button>
                    </form>

                    <hr>

                    <form action="admin-process-delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" class="btn btn-danger">Delete Product</button>
                    </form>
                </fieldset>
            </div>
            <div class="col-md-1"></div>
        </div>
    <?php endif; ?>

    <?php include "footer.php"; ?>
</div>
</body>
</html>
