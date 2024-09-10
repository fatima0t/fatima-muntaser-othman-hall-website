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

$sql = "SELECT name, password,reset FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $password = $row["password"];
    $reset = $row["reset"];

    
} else {
    // Handle the case where no rows were returned
    echo "No user found with the provided email.";
}
$stmt->close();




?>


<!DOCTYPE html>
<html lang="ar" dir="rtl>
<head>
   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall Type</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
   <link rel="stylesheet" type="text/css" href="css/halltype.css"> 
   <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
   <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

   <style>
   body {
    font-family: 'Cairo', sans-serif;
    background-image: url('photo/darkness.png');
    background-repeat: no-repeat;
    background-size: cover;
    font-size: small;
    text-align: left;
}

.container {
    position: relative;
    min-height: 90vh; /* Use vh for better responsiveness */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1% 5%; /* Use percentages for padding */
}

.container .content {
    text-align: center;
}

.container .content h3 {
    font-size: 1.2em; /* Use em for responsive font sizes */
    color: #333;
    background-color: #e7dcdc;
    border-radius: 5px;
}

.container .content p {
    font-size: 1em; /* Use em for responsive font sizes */
    color: #fff;
    font-weight: bold;
}

.container .content h1 {
    font-size: 2em; /* Use em for responsive font sizes */
    color: #fff;
}

.container .content h1 span {
    color: crimson;
}

.container .content p {
    font-size: 1.5em; /* Use em for responsive font sizes */
    margin-bottom: 20px;
}

.container .button {
    min-width: 80%; /* Use percentage for width */
    max-width: 300px; /* Limit maximum width */
    min-height: 60px;
    display: inline-block; 
    font-size: 1.2em; /* Use em for responsive font sizes */
    text-transform: uppercase;
    text-align: center;
    letter-spacing: 1.3px;
    font-weight: bold;
    color: #313133;
    background: linear-gradient(90deg, #07ff66 0%, #07ff66 100%);
    border: none;
    border-radius: 1000px;
    box-shadow: 10px 5px 5px #e7dcdc;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    outline: none;
    padding: 10px;
    font-family: 'Cairo', sans-serif;
}

.button:hover, 
.button:focus {
    color: #313133;
    transform: translateY(-6px);
}

@media screen and (max-width: 767px) {
    .container {
        flex-direction: column; /* Stack elements vertically */
        padding: 5%; /* More padding for mobile */
    }

    .button {
        width: 100%; /* Full width for buttons */
        margin: 10px 0; /* Spacing between buttons */
        font-size: 1em; /* Adjust font size for mobile */
    }

    .container .content h1 {
        font-size: 1.5em; /* Smaller font for mobile */
    }

    .container .content p {
        font-size: 1em; /* Smaller font for mobile */
    }

    .container .content h3 {
        font-size: 1em; /* Smaller font for mobile */
    }
}
</style>

</head>
<body>
<div class="container">


<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <div class="content">

        <h1>  السلام عليكم <?php echo $name; ?> </h1>
        <p>  هذا رمز إعادة تعيين كلمة السر الخاصة بك الرجاء الإحتفاظ به جيدًا وعدم فقدانه</p>
        <h3 > <?php echo $reset ?> </h3>
            <form action="south_hall.php" method="post">
                <input class="button" type="submit" id="south-hall" value="القاعة الجنوبية">
            </form>
            <br>
            <form action="north_hall.php" method="post">
                <input class="button" type="submit" id="north-hall" value="القاعة الشمالية">
            </form>
            <br>
            <form action="center_hall.php" method="post">
                <input class="button" type="submit" id="central-hall" value="القاعة الوسطى">
            </form>
            <br>
            <form action="request.php" method="post">
                <input class="button" type="submit" id="request" value="طلبات الحجز">
            </form>
            <br>
            <form action="admin_page.php" method="post">
                <input class="button" type="submit" id="admin_page" value="طلبات الدخول">
            </form>
            <br>
            <form action="logout.php" method="post">
                <input class="button" type="submit" id="logout" value="تسجيل الخروج ">
            </form>
            

    
            <br>
        </div>
        
    </div>
</body>
</html>