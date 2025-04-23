<?php
session_start();
require_once("connect-db.php");

require_once("admin-auth.php");

// Handle status update form
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = $_POST['status'];

    $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':status' => $newStatus,
        ':order_id' => $orderId
    ]);
}

// Handle filtering
$filterStatus = $_GET['status'] ?? '';
$params = [];
$whereClause = '';

if (!empty($filterStatus)) {
    $whereClause = "WHERE o.status = :status";
    $params[':status'] = $filterStatus;
}

$sql = "SELECT o.*, c.fName, c.lName
        FROM orders o
        JOIN customer c ON o.customer_id = c.customer_id
        $whereClause
        ORDER BY o.date_ordered DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();
$stmt->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>

<div class="container mt-4">
    <?php include "header.php"; ?>

    <h2>All Customer Orders</h2>

    <!-- filter Form -->
    <form method="GET" class="mb-3 d-flex align-items-end gap-3">
        <div>
            <label for="status" class="form-label">Filter by Status:</label>
            <select name="status" id="status" class="form-select">
                <option value="">-- All --</option>
                <option value="pending" <?php if ($filterStatus == "pending") echo "selected"; ?>>Pending</option>
                <option value="shipped" <?php if ($filterStatus == "shipped") echo "selected"; ?>>Shipped</option>
                <option value="delivered" <?php if ($filterStatus == "delivered") echo "selected"; ?>>Delivered</option>
                <option value="canceled" <?php if ($filterStatus == "canceled") echo "selected"; ?>>Canceled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Apply Filter</button>
        <a href="admin-orders.php" class="btn btn-secondary">Reset</a>
    </form>

    <?php if (empty($orders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Update</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($order['fName'] . ' ' . $order['lName']); ?></td>
                    <td><?php echo date("F j, Y, g:i a", strtotime($order['date_ordered'])); ?></td>
                    <td><?php echo ucfirst($order['status']); ?></td>
                    <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                    <td>
                        <form method="POST" class="d-flex">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="status" class="form-select form-select-sm me-2">
                                <?php
                                $statuses = ['pending', 'shipped', 'delivered', 'canceled'];
                                foreach ($statuses as $status) {
                                    $selected = $status === $order['status'] ? 'selected' : '';
                                    echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-sm btn-success">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="order-confirmation.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-outline-primary">
                            View
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
