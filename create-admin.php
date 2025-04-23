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
                        <h2>Administrator Registration</h2>
                    </legend>
                <form action="process-admin.php" method="post">
                        <input type="hidden" name="type" value="Admin">
                        <label>First Name:</label>
                        <br>
                        <input type="text" id="admin_fName" name="admin_fName" required>
                        <br>
                        <label>Last Name:</label>
                        <br>
                        <input type="text" id="Admin_lName" name="admin_lName" required>
                        <br>
                        <label>E-mail</label>
                        <br>
                        <input type="email" id="admin_Email" name="admin_email" required>
                        <span id="email-status"></span>
                        <br>
                        <label for="password">Password:</label>
                        <br>
                        <input type="password" id="admin_password" name="password" required>
                        <br>
                        <label for="password">Confirm Password:</label>
                        <br>
                        <input type="password" id="confirmPassword" name="cPassword" required>
                        <span id="password-status"></span>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">Create Account</button>
                        <br>
                        <br>
                        <a href="admin-login.php">Log In</a>
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
    <script>
        $(document).ready(function(){
            // Check email availability
            $("#admin_Email").on("keyup", function() {
                var email = $(this).val();
                if (email.includes("@")) {
                    $.post("check-availability.php", { admin_email: email }, function(response) {
                        if (response === "Taken") {
                            $("#email-status").html('<span class="text-danger">Email is already in use ❌</span>');
                        } else {
                            $("#email-status").html('<span class="text-success">Email is available ✅</span>');
                        }
                    });
                } else {
                    $("#email-status").html('');
                }
            });
            // ✅ Check if passwords match
            $("#admin_password, #confirmPassword").on("keyup", function() {
            var password = $("#admin_password").val();
            var confirmPassword = $("#confirmPassword").val();

            if (password.length < 6) {
                $("#password-status").html('<span class="text-danger">Password must be at least 6 characters ❌</span>');
            } else if (password !== confirmPassword) {
                $("#password-status").html('<span class="text-danger">Passwords do not match ❌</span>');
            } else {
                $("#password-status").html('<span class="text-success">Passwords match ✅</span>');
            }
        });

        });
    </script>
</body>
</html>