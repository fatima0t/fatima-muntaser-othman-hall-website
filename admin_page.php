<?php

@include 'dbconfig.php';

// Start the session
session_start();
$email = $_SESSION["email"];

// Check if the user's session is valid and they are logged in
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    // If the session is not valid, redirect the user to the login page
    header("Location: login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $number = isset($_POST["number"]) ? $_POST["number"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $token = bin2hex(random_bytes(32));
    
    $hash = password_hash($token, PASSWORD_DEFAULT);
    

    $sql = "INSERT INTO user (name, email,number, password, reset) 
            VALUES ('$name', '$email', '$number','$password', $hash)";

    
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>طلبات الدخول</title>
    <link rel="stylesheet" type="text/css" href="css/admin_page.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
</head>
<body>

    
<div class="container">
    
    <?php
    

    if (isset($_SESSION['error_message'])) {
        echo "<div class='error-container' >";
        echo "<h2>  المستخدم موجود مسبقًا</h2>";
        
        echo "</div>";

        // Clear the error message from the session
        unset($_SESSION['error_message']);
    }
    ?>
    <?php
    

    if (isset($_SESSION['error_message1'])) {
        echo "<div class='error-container'>";
        echo "<h2>تم قبول الحساب الجديد بنجاح</h2>";
        
        echo "</div>";

        // Clear the error message from the session
        unset($_SESSION['error_message1']);
    }
    ?>
<table class="table">
            <thead>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
           
          
    
        <th>
            <i class="fas fa-user"></i> <!-- Icon for name -->
            الاسم
        </th>
        <th>
            <i class="fas fa-envelope"></i> <!-- Icon for email -->
            البريد الالكتروني
        </th>
        <th>
            <i class="fas fa-phone"></i> <!-- Icon for phone -->
            رقم الهاتف
        </th>
        <th>
            <i class="fas fa-lock"></i> <!-- Icon for password -->
            كلمة السر
        </th>
        <th>
            <i class="fas fa-cogs"></i> <!-- Icon for operations -->
            العمليات
        </th>
    </tr>
</thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM user_request WHERE `a/r`=1 ";
                $result = $conn->query($sql);

                if ($result === false) {
                    // Handle the query error
                    echo "Error executing the query: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['number']; ?></td>
                                <td><?php echo $row['password']; ?></td>
                                
                                <td>
                                    <button class="btn btn-primary">
                                    <a href="add_by_admin.php?email=<?php echo $row['email']; ?>&name=<?php echo $row['name']; ?>&password=<?php echo $row['password']; ?>&number=<?php echo $row['number']; ?>" >قبول</a> <button class="btn btn-primary">
                                    <a href="delete_admin.php?removeid=<?php echo $row['id']; ?>" >رفض</a>
                                    </button>
                                </td>
                                
                                    
                                
                            </tr>
                            
                            <?php
                        }
                    } else {
                       /* echo "No records found.";*/
                    }
                }
                ?>

                
            </tbody>
        </table>
       