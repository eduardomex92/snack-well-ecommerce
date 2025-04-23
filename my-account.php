<?php
session_start();
require_once("connect-db.php");

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Optional: Get customer info
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT fName FROM customer WHERE customer_id = :id";
$statement = $db->prepare($sql);
$statement->bindValue(":id", $customer_id);
$statement->execute();
$user = $statement->fetch( PDO::FETCH_ASSOC);
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>

<div class="container mt-4">
    <?php include "header.php"; ?>

    <h2>Welcome, <?php echo htmlspecialchars($user['fName']); ?>!</h2>
    <p>Here’s what you can do from your account:</p>

    <div class="list-group">
        <a href="customer-orders.php" class="list-group-item list-group-item-action">
            🧾 View Order History
        </a>
        <a href="update-account.php" class="list-group-item list-group-item-action">
            🛠 Update Account Info
        </a>
        <a href="contact.php" class="list-group-item list-group-item-action">
            📬 Contact Support
        </a>
        <a href="logout.php" class="list-group-item list-group-item-action text-danger">
            🚪 Log Out
        </a>
    </div>

    <?php include "footer.php"; ?>
</div>

</body>
</html>
