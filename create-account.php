<!-- Updated Responsive Version of create-account.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <?php include "header.php"; ?>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="row justify-content-center my-5">
            <div class="col-12 col-md-10 col-lg-6">
                <fieldset class="p-4 bg-light rounded shadow-sm">
                    <legend class="mb-4"><h2>Customer Registration</h2></legend>
                    <form action="process-account.php" method="post">
                        <div class="mb-3">
                            <label for="cFirstName" class="form-label">First Name:</label>
                            <input type="text" id="cFirstName" name="fName" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cLastName" class="form-label">Last Name:</label>
                            <input type="text" id="cLastName" name="lName" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cPhone" class="form-label">Phone:</label>
                            <input type="text" id="cPhone" name="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cAddress" class="form-label">Address:</label>
                            <input type="text" id="cAddress" name="address" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cCity" class="form-label">City:</label>
                            <input type="text" id="cCity" name="city" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cState" class="form-label">State:</label>
                            <input type="text" id="cState" name="state" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cZip" class="form-label">Zip:</label>
                            <input type="text" id="cZip" name="zip" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cEmail" class="form-label">E-mail:</label>
                            <input type="email" id="cEmail" name="email" class="form-control" required>
                            <span id="email-status" class="form-text"></span>
                        </div>

                        <div class="mb-3">
                            <label for="cUsername" class="form-label">Username:</label>
                            <input type="text" id="cUsername" name="cUsername" class="form-control" required>
                            <span id="username-status" class="form-text"></span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password:</label>
                            <input type="password" id="confirmPassword" name="cPassword" class="form-control" required>
                            <span id="password-status" class="form-text"></span>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary w-100">Create Account</button>
                        </div>

                        <div class="text-center">
                            <a href="customer-login.php">Already have an account? Log In</a>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5">
            <div class="col-12">
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>

    <!-- jQuery Validation Script -->
    <script>
        $(document).ready(function() {
            // Username check
            $("#cUsername").on("keyup", function() {
                var username = $(this).val();
                if (username.length > 3) {
                    $.post("check-availability.php", { username: username }, function(response) {
                        if (response === "Taken") {
                            $("#username-status").html('<span class="text-danger">Username is taken ❌</span>');
                        } else {
                            $("#username-status").html('<span class="text-success">Username is available ✅</span>');
                        }
                    });
                } else {
                    $("#username-status").html('');
                }
            });

            // Email check
            $("#cEmail").on("keyup", function() {
                var email = $(this).val();
                if (email.includes("@")) {
                    $.post("check-availability.php", { email: email }, function(response) {
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

            // Password match check
            $("#password, #confirmPassword").on("keyup", function() {
                var password = $("#password").val();
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
