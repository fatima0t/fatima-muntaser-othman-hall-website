<?php
// Start the session

include "dbconfig.php";
session_start();
$email = $_SESSION["email"];

// Check if the user's session is valid and they are logged in
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    // If the session is not valid, redirect the user to the login page
    header("Location: login.php");
    exit;
}



if(isset($_GET['removeid'])){

    $id=$_GET['removeid'];

    $sql= "UPDATE requestguest SET `delete`='0' where id=$id";
    $result=mysqli_query($conn,$sql);
    if($result){
        
        header('location:request.php');
    }
}


?>