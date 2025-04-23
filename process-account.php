<?php
session_start();
require_once("connect-db.php");

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = trim($_POST["fName"]);
    $lName = trim($_POST["lName"]);
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);
    $city = trim($_POST["city"]);
    $state = trim($_POST["state"]);
    $zip = trim($_POST["zip"]);
    $email = strtolower(trim($_POST["email"]));
    $username = trim($_POST["cUsername"]);
    $password = $_POST["password"];
    $cPassword = $_POST["cPassword"];

    //check if username or email already exists
    $sql = "select * from customer where username = :username or email = :email";

    $statement = $db->prepare($sql);
    $statement->bindValue(":username", $username);
    $statement->bindValue(":email", $email);

    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if ($customer) {
        $message = "❌ Username or email already exists.";
        header("refresh:3; url=create-account.php");
        exit;
    } elseif ($password !== $cPassword) {
        $message = "⚠️ Passwords do not match.";
        header("refresh:3; url=create-account.php");
        exit;
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "insert into customer (fName, lName, phone, address, city, state, zip, email, username, password) values (:fName, :lName, :phone, :address, :city, :state, :zip, :email, :username, :password)";

        $statement = $db->prepare($sql);
        $statement->bindValue(":fName", $fName);
        $statement->bindValue(":lName", $lName);
        $statement->bindValue(":phone", $phone);
        $statement->bindValue(":address", $address);
        $statement->bindValue(":city", $city);
        $statement->bindValue(":state", $state);
        $statement->bindValue(":zip", $zip);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":username", $username);
        $statement->bindValue(":password", $hashedPassword);

        $statement->execute();
        $statement->closeCursor();

        $message = "✅ Account created successfully. Redirecting to login...";
        ?>
        <script>
            setTimeout(function () {
                window.location.href = "customer-login.php";
            }, 3000);
        </script>
        <?php
    }
} ?>

<!DOCTYPE html>
<!-- Customer Login Page-->
<html lang="en">

<?php include "includes/head.php"; ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php include("header.php"); ?>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="alert alert-primary" role="alert">
                    <?php echo $message; ?>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>

</html>