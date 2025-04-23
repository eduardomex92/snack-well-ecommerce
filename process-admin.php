<?php
session_start();

require_once("connect-db.php");
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = trim($_POST["admin_fName"]);
    $lName = trim($_POST["admin_lName"]);
    $adminName = $fName . " " . $lName;
    $email = strtolower(trim($_POST["admin_email"]));
    $password = $_POST["password"];
    $cPassword = $_POST["cPassword"];

    $sql = "SELECT * FROM admin WHERE admin_email = :admin_email";

    $statement = $db->prepare($sql);
    $statement->bindValue(":admin_email", $email);

    $statement->execute();
    $admin = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if ($admin) {
        $message = "❌ Email already exists.";
        header("refresh:3; url=index.php");
        exit;
    } elseif ($password !== $cPassword) {
        $message = "⚠️ Passwords do not match.";
        header("refresh:3; url=index.php");
        exit;
    } else {

        //hash password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (admin_name, admin_email, admin_password) VALUES(:adminName, :admin_email, :password)";

        $statement = $db->prepare($sql);
        $statement->bindValue(":adminName", $adminName);
        $statement->bindValue(":admin_email", $email);
        $statement->bindValue(":password", $hashedPassword);
        $statement->execute();
        $statement->closeCursor();
        $message = "✅ Account created successfully. Redirecting to login...";
        ?>
        <script>
            setTimeout(function () {
                window.location.href = "admin-login.php";
            }, 5000);
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