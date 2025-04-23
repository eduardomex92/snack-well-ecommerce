<?php
session_start();
require_once("connect-db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];

    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['cPassword'];

    // Check if password fields were filled
    if (!empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword !== $confirmPassword) {
            echo "Passwords do not match.";
            exit;
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE customer 
                SET fName = :fName, lName = :lName, phone = :phone, address = :address,
                    city = :city, state = :state, zip = :zip, email = :email, password = :password
                WHERE customer_id = :customer_id";

        $statement = $db->prepare($sql);
        $statement->bindValue(':password', $hashedPassword);
    } else {
        // No password change
        $sql = "UPDATE customer 
                SET fName = :fName, lName = :lName, phone = :phone, address = :address,
                    city = :city, state = :state, zip = :zip, email = :email
                WHERE customer_id = :customer_id";

        $statement = $db->prepare($sql);
    }

    // Bind shared values
    $statement->bindValue(':fName', $fName);
    $statement->bindValue(':lName', $lName);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':zip', $zip);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':customer_id', $customer_id);

    if ($statement->execute()) {
        header("Location: customer-account.php?status=updated");
        exit;
    } else {
        echo "Error updating information.";
    }
}
?>
