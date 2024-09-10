
<?php
include "dbconfig.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];
    $hall = $_POST['hall'];
	$day = $_POST['day'];
    $signInDateTime = date('Y-m-d H:i:s');

    $sql = "";
    if ($hall == "الجنوبية") {
        $sql = "SELECT * FROM south WHERE (date= '$date') AND (( '$stime' BETWEEN stime AND etime ) 
        OR ( '$etime' BETWEEN stime AND etime ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ))";
    } elseif ($hall == "الشمالية") {
        $sql = "SELECT * FROM north WHERE (date= '$date') AND (( '$stime' BETWEEN stime AND etime ) 
        OR ( '$etime' BETWEEN stime AND etime ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ))";
    } elseif ($hall == "الوسطى") {
        $sql = "SELECT * FROM center WHERE (date= '$date') AND (( '$stime' BETWEEN stime AND etime ) 
        OR ( '$etime' BETWEEN stime AND etime ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ))";
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $error[] = "هذا الموعد محجوز";
    } else {
		$insert = "INSERT INTO requestguest(name, date, day, stime, etime, hall, reservetime) 
           VALUES ('$name', '$date', '$day', '$stime', '$etime', '$hall', '$signInDateTime')";
        $conn->query($insert);
        $error[] = "شكرًا لك لإستخدام موقعنا، تم إضافة طلبك بنجاح";
    }
}
?>
<!DOCTYPE html>
<html lang="ar"  >
<head>
	<title>حجز القاعة</title>
	
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/reserve.css"> 
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <div class="container">

	<?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">'.$error.'</span>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
                }
            }
            ?>
			
        <div class="instructions">
		<h3><i class="fas fa-info-circle"></i> تعليمات:</h3>
            <ol>
                <li>قم بتعبئة النموذج الموجود بالأسفل</li>
                <li>عند الانتهاء قم بالنقر على تقديم طلب</li>
                <li>في حالة التقديم لحجز قاعة محجوزة مسبقًا سيتم اعلامك بهذا</li>
                <li>يرجى العلم بأن هذا الطلب طلب شكلي سيستمر فقط لمدة 12 ساعة وبعد انتهاء هذه المدة سيتم حذف الطلب لذلك قبل انتهاء فترة الطلب قم بزيارة مبنى البلدية لتأكيد حجزك</li>
                <li>في حالة تقديم طلبين في نفس الوقت تعطى الاولوية لمن يقوم بتأكيد الحجز أولًا</li>
            </ol>
        </div>

        <div class="img">
            <img src="photo/Starman-cuate.png">
        </div>
        
        <form action="" method="post">
		
		<i class="fas fa-user"></i>
        أدخل اسمك الثلاثي<input type="text" name="name" required>
			
		
            <br>
			<i class="fas fa-calendar-alt"></i>
            أدخل تاريخ الحجز <input type="date" name="date" autocomplete="off" required lang="ar">
            <br>
			<i class="fas fa-calendar-day"></i>
           أدخل اليوم <input type="text" name="day" autocomplete="off" required lang="ar">
		  <br>
		  <i class="fas fa-clock"></i>
           أدخل وقت البداية <input type="time" name="stime" autocomplete="off" required lang="ar">
            <br>
			<i class="fas fa-clock"></i>
            أدخل وقت النهاية <input type="time" name="etime" autocomplete="off" required lang="ar">
            <br>
            <div class="form-field">
			<i class="fas fa-building"></i>
                <label for="hall">اختر اسم القاعة</label>
                <select name="hall" id="hall" required>
                    <option value=""></option>
                    <option value="الجنوبية">القاعة الجنوبية</option>
                    <option value="الشمالية">القاعة الشمالية</option>
                    <option value="الوسطى">القاعة الوسطى</option>
                </select>
            </div>
            <br>
            <input type="submit" name="submit" value="تقديم الطلب" class="form-btn">
        </form>
    </div>
</body>
</html>