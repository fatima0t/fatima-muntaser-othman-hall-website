<?php
session_start(); // بدء الجلسة
include "dbconfig.php";

$errors = []; // تعريف المتغير كصفيف

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $select = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];
        
        if (password_verify($password, $stored_password)) {
            $_SESSION["email"] = $email;
            header("Location: HallType.php");
            exit;
        } else {
            $errors[] = "البريد الالكتروني أو كلمة السر غير صحيحة";
        }
    } else {
        $errors[] = "البريد الالكتروني أو كلمة السر غير صحيحة";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" type="text/css" href="css/login&signup.css">
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="icon" href="photo\icons8-palestine-48.png" type="image/png">
</head>
<body>
    <div class="container">
        <div class="img">
            <img src="photo/undraw_with_love_re_1q3m.svg">
        </div>
        <div class="login-content">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <img src="photo/undraw_welcome_cats_thqn.svg">                
                <?php if (!empty($errors)) { ?>
                    <div style="color: red; font-weight: bold;">
                        <?php foreach ($errors as $error) { echo htmlspecialchars($error) . "<br>"; } ?>
                    </div>
                <?php } ?>
                <?php
                if (isset($_SESSION['logout_success'])) {
                    echo "<div style='color: green;'>You have been logged out successfully.</div>";
                    unset($_SESSION['logout_success']);
                }
                ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="div">
                        <input type="email" id="email" name="email" placeholder="أدخل البريد الالكتروني" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input type="password" id="password" name="password" placeholder="أدخل كلمة السر" required>
                        <button type="button" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <br>
                <a href="ch_pass.php">هل نسيت كلمة السر؟</a>
                <input type="submit" class="btn" value="تسجيل الدخول">
                <p>ليس لديك حساب؟ <a href="signup.php">انشاء حساب</a></p>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>