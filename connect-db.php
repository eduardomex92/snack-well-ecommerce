<?php
    $dsn = "mysql:host=localhost;dbname=snack_well_db";
    $username="root";
    $password="";
    try{
        $db=new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
        echo "connection failed" . $e->getMessage();
    }
?>
