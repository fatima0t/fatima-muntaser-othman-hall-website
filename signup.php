<?php
// Start the session
session_start();
include "dbconfig.php";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    $sql = "SELECT * FROM user_request WHERE email='$email'"; 
    $result = mysqli_query($conn, $sql); 
    $num = mysqli_num_rows($result); 

    if ($num == 0) { 
        if ($password == $cpassword) { 
            $hash = password_hash($password, PASSWORD_DEFAULT); 
            $sql = "INSERT INTO user_request(name, email, number, password, date) VALUES('$name', '$email', '$number', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql); 
            $error[] = 'تم ارسال الطلب، سيتم التواصل معك عند قبولك'; 
        } else {  
            $error[] = "كلمتا السر غير مطابقتان";  
        }       
    } 

    if ($num > 0) { 
        $error[] = "لقد قمت بتقديم طلب، أو لديك حساب مسبقًا";  
    }  
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>انشاء حساب</title>
    <link rel="stylesheet" type="text/css" href="css/login&signup.css">

    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="img">
            <img src="photo/undraw_with_love_re_1q3m.svg">
        </div>
        <div class="login-content">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <img src="photo/undraw_welcome_cats_thqn.svg">                
                <br>
                <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">'.$error.'</span>';
                    }
                };
                ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <input type="text" id="name" name="name" placeholder="أدخل اسمك" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="div">
                        <input type="email" id="email" name="email" placeholder="أدخل بريدك الالكتروني" required>
                    </div>
                </div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="div">
                        <input type="text" id="number" name="number" placeholder="أدخل رقم هاتفك" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" id="password" name="password" placeholder="أدخل كلمة السر" required>
                        <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" id="cpassword" name="cpassword" placeholder="أعد ادخال كلمة السر" required>
                        <i class="fas fa-eye" id="toggleCPassword" style="cursor: pointer;"></i>
                    </div>
                </div>
                <br>
                <input type="submit" class="btn" value="انشاء حساب">
                <p>هل لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    document.getElementById('toggleCPassword').addEventListener('click', function () {
        const cpasswordInput = document.getElementById('cpassword');
        const type = cpasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        cpasswordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>
</html>