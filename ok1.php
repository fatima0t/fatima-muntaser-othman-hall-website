
<?php
include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_GET["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Verify the reset code
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
            if ($password === $cpassword) {
                // Hash the new password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Update the password in the database
                $sql = "UPDATE user SET password = '$hashed_password' WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    $errors[] =  "تم اعادة تعيين كلمة السر";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $errors[] =  "كلمتا السر غير متطابقتان";
            }
        } 
     else {
        echo "البريد الإلكتروني غير موجود";
    }
}
    

?>
<!DOCTYPE html>
<html lan="ar" dir="rtl" >
<head>
  <title>تغيير كلمة السر</title>
  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
 



  <link rel="stylesheet" type="text/css" href="css/forgetpassword1.css">





</head>

 
  
  
  

  <body>
	<!--<img class="wave" src="photo/b.jpg"> -->
	<div class="container">
		<div class="img">
			<img src="photo/GDPR-amico.svg">
		</div>
		<div class="login-content">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?email=" . $_GET["email"]);?>">
								
                <?php if (!empty($errors)) { ?>
        <div class="error-msg ">
            <?php foreach ($errors as $error) { echo $error . "<br>"; } ?>
        </div>
    <?php } ?>
<?php
   if (isset($_SESSION['logout_success'])) {
    echo "<div style='color: green;'>You have been logged out successfully.</div>";
    unset($_SESSION['logout_success']);
}
?>
               <div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	
           		    	<input type="password" id="password" name="password" placeholder="أدخل كلمة السر الجديدة " required>
            	   </div>

            	</div>

              <div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	
           		    	<input type="password" id="cpassword" name="cpassword" placeholder="أعد ادخال كلمة السر  " required>
            	   </div>
                 
            	</div>
<br>
            	<input type="submit" class="btn" value=" تغيير كلمة السر">
				
            </form>
        </div>
    </div>
</body>
</html>



      
    
</body>
</html>