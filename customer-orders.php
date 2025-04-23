<?php
session_start();
require_once("connect-db.php");

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$sql = "SELECT * FROM orders WHERE customer_id = :customer_id ORDER BY date_ordered DESC";
$stmt = $db->prepare($sql);
$stmt->bindValue(':customer_id', $customer_id);
$stmt->execute();
$orders = $stmt->fetchAll();
$stmt->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>

<div class="container mt-4">
    <?php include "header.php"; ?>
    
    <h2>My Orders</h2>

    <?php if (empty($orders)): ?>
        <p>You haven’t placed any orders yet.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo date("F j, Y, g:i a", strtotime($order['date_ordered'])); ?></td>
                    <td><?php echo ucfirst($order['status']); ?></td>
                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                    <td>
                        <a href="order-confirmation.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-outline-primary">
                            View Details
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php include "footer.php"; ?>
</div>

</body>
</html>
