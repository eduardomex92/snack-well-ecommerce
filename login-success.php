<?php
session_start();
require_once("connect-db.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $success = false;
    
    if($_POST["type"] == "A") {
        $type = "A";
        $cUsername = $_POST["cUsername"];
        $password = $_POST["cPassword"];
        $success = true;

    }else if($_POST["type"] == "B") {
        $type = "B";
        $email = strtolower(trim($_POST["admin_email"]));
        $password = $_POST["admin_password"];
        $success = true;
    }
    if($success) {
        if($type == "A") {
            $sql = "SELECT * FROM customer WHERE username = :cUsername";
            $statement = $db->prepare($sql);
            $statement->bindValue(":cUsername", $cUsername);
            $statement->execute();
            $customer = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();

            if($customer && password_verify($password, $customer["password"])) {
                $_SESSION["customer-login"] = true;
                $_SESSION["customer_id"] = $customer["customer_id"];
                $_SESSION["customer_name"] = $customer["fName"] . " " . $customer["lName"];
                if (isset($_COOKIE['guest_cart'])) {
                    $guestCart = json_decode($_COOKIE['guest_cart'], true);
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    foreach ($guestCart as $productId => $item) {
                        if (isset($_SESSION['cart'][$productId])) {
                            $_SESSION['cart'][$productId]['quantity'] += $item['quantity'];
                        } else {
                            $_SESSION['cart'][$productId] = $item;
                        }
                    }
                    setcookie("guest_cart", "", time() - 3600, "/");
                }
                $message = "Welcome " . $_SESSION["customer_name"];
                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 3000);
                </script>
                <?php
                } else {
                $_SESSION["customer-login"] = false;
                unset($_SESSION["customer_id"]);
                $message = "Invalid username or password";
                ?>
            <script>
                setTimeout(function() {
                    window.location.href = "customer-login.php";
                }, 3000);
            </script>
            <?php
            }
        }else if($type == "B"){
            $sql = "SELECT * FROM admin WHERE admin_email = :admin_email";
            $statement = $db->prepare($sql);
            $statement->bindValue(":admin_email", $email, PDO::PARAM_STR);
            $statement->execute();
            $admin = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();

    if($admin && password_verify($password, $admin["admin_password"])) {
            $_SESSION["admin-login"] = true;
            $_SESSION["admin_id"] = $admin["admin_id"];
            $_SESSION["admin_name"] = $admin["admin_name"];
            $message = "<h1>Login Success</h1><br>Welcome " . $_SESSION["admin_name"];
        ?>
        <script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 3000);
        </script>
        <?php
    } else {
        $_SESSION["admin-login"] = false;
        unset($_SESSION["admin_id"]);
        $message = "<h1>Login Failed</h1><br>Invalid email or password";
        ?>
        <script>
            setTimeout(function() {
                window.location.href = "admin-login.php";
            }, 3000);
        </script>
        <?php
    }}
}
}
?>

<!DOCTYPE html>
<!-- Login success for admin and customer-->
<html lang="en">
<?php include "includes/head.php"; ?>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <?php include "header.php";?>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <p><?php echo $message;?></p>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <?php include "footer.php";?>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
</html>