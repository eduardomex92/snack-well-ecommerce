<?php
session_start();
require_once("connect-db.php");

// Redirect if order ID not provided
if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = filter_var($_GET['order_id'], FILTER_VALIDATE_INT);
if (!$order_id) {
    echo "<div class='container mt-4'><h4>Invalid order ID.</h4></div>";
    exit();
}


// Get order + customer
$sql = "SELECT o.*, c.fName, c.lName
        FROM orders o
        JOIN customer c ON o.customer_id = c.customer_id
        WHERE o.order_id = :order_id";
$statement = $db->prepare($sql);
$statement->bindValue(':order_id', $order_id);
$statement->execute();
$order = $statement->fetch();
$statement->closeCursor();

if (!$order) {
    echo "<div class='container mt-4'><h4>Order not found.</h4></div>";
    exit();
}

// Get cart items
$sqlItems = "SELECT ci.*, p.name, p.image_url
             FROM cart_items ci
             JOIN products p ON ci.product_id = p.product_id
             WHERE ci.cart_id = :cart_id";
$statement = $db->prepare($sqlItems);
$statement->bindValue(':cart_id', $order['cart_id']);
$statement->execute();
$items = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>

<div class="container mt-4">
    <?php include "header.php"; ?>

    <?php if (isset($_GET['payment']) && $_GET['payment'] === 'success'): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your payment was completed via PayPal.
        </div>
    <?php endif; ?>

    <h2>Thank You for Your Order!</h2>
    <p>Hi <?php echo htmlspecialchars($order['fName']); ?>, your order #<?php echo $order_id; ?> has been received.</p>
    <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
    <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($order['date_ordered'])); ?></p>

    <h4 class="mt-4">Order Summary</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><img src="images<?php echo $item['image_url']; ?>" width="80" alt=""></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h5>Total: $<?php echo number_format($order['total_price'], 2); ?></h5>

    <a href="index.php" class="btn btn-primary mt-3">Return to Home</a>

    <?php include "footer.php"; ?>
</div>

</body>
</html>
