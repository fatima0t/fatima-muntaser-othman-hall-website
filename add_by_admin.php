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



// Check if the required parameters are set in the URL
if (isset($_GET['email'], $_GET['name'], $_GET['password'],$_GET['number'])) {
    $email = mysqli_real_escape_string($conn, $_GET["email"]);
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $password = mysqli_real_escape_string($conn, $_GET['password']);
    $number = mysqli_real_escape_string($conn, $_GET['number']);
    // Generate a random token key
$tokenKey = bin2hex(random_bytes(32));




    // Check if the email already exists in the user table
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the email already exists, set an error message and redirect to the admin page
        $_SESSION['error_message'] = "Error: Email already exists in the database.";
        header("Location: admin_page.php");
        exit();
    } else {
        // Prepare the SQL queries to insert the data
        $stmt = $conn->prepare("INSERT INTO user (name, email, password,number,reset) VALUES (?, ?, ?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $password,$number,$tokenKey);

        if ($stmt->execute() ) {
            // If the insertions are successful, check if there's a row in the user_request table with the same email
            // and update the 'a/r' column to '0'
            $stmt3 = $conn->prepare("UPDATE user_request SET `a/r`='0' WHERE email=?");
            $stmt3->bind_param("s", $email);
            $stmt3->execute();

            // Set a success message in the session and redirect to the admin page
            $_SESSION['error_message1'] = "User created successfully.";
            header("Location: admin_page.php");
            exit();
        } else {
            // If there's an error, print the error message
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $stmt3->close();
} else {
    // If the required parameters are not set, print an error message
    echo "Missing required parameters in the URL.";
}
?>