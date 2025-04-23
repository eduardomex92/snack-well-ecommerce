<?php
require_once("connect-db.php");

if(isset($_POST["username"])) {
    $username = trim($_POST["username"]);

    $sql = "SELECT * FROM customer WHERE username = :username";
    $statement = $db->prepare($sql);

    $statement->bindValue(":username", $username);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if($customer) {
        echo "Taken";
     }else {
        echo "Available";
     }
     exit;
}

if(isset($_POST["email"])) {
    $email = trim($_POST["email"]);

    $sql = "SELECT * FROM customer WHERE email = :email";
    $statement = $db->prepare($sql);

    $statement->bindValue(":email", $email);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if($customer) {
        echo "Taken";
     }else {
        echo "Available";
     }
     exit;
}


if(isset($_POST["admin_email"])){
   $email = strtolower(trim($_POST["admin_email"]));

   $sql = "SELECT * FROM admin WHERE admin_email = :admin_email";

   $statement = $db->prepare($sql);

   $statement->bindValue("admin_email", $email);
   $statement->execute();
   $admin = $statement->fetch(PDO::FETCH_ASSOC);
   $statement->closeCursor();

   if($admin) {
      echo "Taken";
   } else {
      echo "Available";
   }
   exit;
}
?>