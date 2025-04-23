<?php
session_start();
?>
<!DOCTYPE html>
<!-- Customer Login Page-->
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
                <fieldset>
                    <legend>
                        <h2>Administrator Login</h2>
                    </legend>
                <form action="login-success.php" method="post">
                        <input type="hidden" name="type" value="B">
                        <label>Administrator E-mail:</label>
                        <br>
                        <input type="text" id="Admin_Email" name="admin_email" required>
                        <br>
                        <label for="password">Password:</label>
                        <br>
                        <input type="password" id="Admin_Password" name="admin_password" required>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <br>
                    </form>
                    <a href="create-admin.php">Create Admin Account</a>
                </fieldset>
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
</body>
</html>