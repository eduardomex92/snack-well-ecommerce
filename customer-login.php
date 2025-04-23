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
                        <h2>Customer Login</h2>
                    </legend>
                <form action="login-success.php" method="post">
                        <input type="hidden" name="type" value="A">
                        <label>Username:</label>
                        <br>
                        <input type="text" id="cUserName" name="cUsername" required>
                        <br>
                        <label for="password">Password:</label>
                        <br>
                        <input type="password" id="c_Password" name="cPassword" required>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <br>
                        <a href="create-account.php">Sign Up!</a>
                    </form>
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