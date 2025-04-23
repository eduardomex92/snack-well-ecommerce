<?php
session_start();
require_once("connect-db.php");

$sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
$statement = $db->prepare($sql);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

if (isset($_SESSION['customer_id']) && isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else if (isset($_COOKIE['guest_cart'])) {
    $decodedCart = json_decode($_COOKIE['guest_cart'], true);
    if (is_array($decodedCart)) {
        $cart = $decodedCart;
    } else {
        $cart = [];
    }
} else {
    $cart = [];
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="container">
        <?php include "header.php"; ?>
        <h2 class="mt-4">Your Cart</h2>

        <?php if (empty($cart)) { ?>
            <p>Your cart is empty.</p>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $key => $item) {
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><img src="images<?php echo $item['image_url']; ?>" class="img-fluid" width="80" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                    <form action="remove-from-cart.php" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <?php
            $shipping = 0;
            if ($total < 25) {
                $shipping = 5;
            } else if ($total < 35) {
                $shipping = 3;
            }
            $grandTotal = $total + $shipping;
            ?>

            <div class="alert alert-secondary mt-4">
                <h4>Subtotal: $<?php echo number_format($total, 2); ?></h4>
                <h4>Shipping: $<?php echo number_format($shipping, 2); ?></h4>
                <h3 class="text-success">Grand Total: $<?php echo number_format($grandTotal, 2); ?></h3>
            </div>

            <a href="checkout.php" class="btn btn-success w-100">Proceed to Checkout</a>
        <?php } ?>
        <?php include "footer.php"; ?>
    </div>
</body>
</html>