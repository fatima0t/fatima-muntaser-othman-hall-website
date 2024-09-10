<?php

include "dbconfig.php";

$errors = []; // تعريف المتغير كصفيف

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $reset = $conn->real_escape_string($_POST["reset"]);

    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_reset = $row["reset"];

        if ($reset == $stored_reset) {
            header("Location: ok1.php?email=" . urlencode($email));
            exit;
        } else {
            $errors[] = "الكود خاطئ";
        }
    } else {
        $errors[] = "البريد الإلكتروني غير موجود في قاعدة بياناتنا";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>تغيير كلمة السر</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/forgetpassword.css">
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
</head>

<body>
    <div class="container">
        <div class="img">
            <img src="photo/Fingerprint-bro.svg">
        </div>
        <div class="login-content">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <?php if (!empty($errors)) { ?>
                    <div class="error-msg">
                        <?php foreach ($errors as $error) { echo htmlspecialchars($error) . "<br>"; } ?>
                    </div>
                <?php } ?>

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
                        <input type="password" id="reset" name="reset" placeholder="أدخل الكود الخاص بك" required>
                        <button type="button" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <input type="submit" name="submit" class="btn" value="تحقق">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('reset');
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