<?php
include "dbconfig.php";

session_start();
$email = $_SESSION["email"];

// Check if the user's session is valid and they are logged in
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    // If the session is not valid, redirect the user to the login page
    header("Location: login.php");
    exit;
}
$id = $_GET['updateid'];

// Prepare the SQL query to fetch the row
$sql = "SELECT * FROM requestguest WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo "Error executing query: " . $stmt->error;
    exit;
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header('location:HallType.php');
    exit;
}

$row = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $day = $_POST['day'];
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];
    $aamount = $_POST['aamount'];
    $pamount = $_POST['pamount'];
    $ramount = $_POST['ramount'];
    $notes = $_POST['notes'];
    $hall = $_POST['hall'];

    
           
    $sql = "";
    if ($hall == "الشمالية") {
        $sql = "SELECT * FROM south WHERE (date= '$date') AND (( '$stime' BETWEEN stime AND etime ) 
        OR ( '$etime' BETWEEN stime AND etime ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ))";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
             $error[] = "This date & time is taken!";
         } else {
        $sql="INSERT INTO south(name,date,day,stime,etime,aamount,pamount,ramount,notes) 
            VALUES('$name','$date','$day','$stime','$etime','$aamount','$pamount','$ramount','$notes')";
         }

    } elseif ($hall == "الجنوبية") {
        $sql = "SELECT * FROM north WHERE (date= '$date') AND (( '$stime' BETWEEN stime AND etime ) 
        OR ( '$etime' BETWEEN stime AND etime ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ))";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
             $error[] = "This date & time is taken!";
         } else {
        $sql="INSERT INTO north(name,date,day,stime,etime,aamount,pamount,ramount,notes) 
            VALUES('$name','$date','$day','$stime','$etime','$aamount','$pamount','$ramount','$notes')";
         }
    } elseif ($hall == "الوسطى") {
        $sql = "SELECT * FROM center WHERE (date= '$date') AND (( '$stime' BETWEEN stime AND etime ) 
        OR ( '$etime' BETWEEN stime AND etime ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ) 
        OR ( etime BETWEEN '$stime' AND '$etime' ))";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
             $error[] = "This date & time is taken!";
             
         } else {
        $sql="INSERT INTO center(name,date,day,stime,etime,aamount,pamount,ramount,notes) 
            VALUES('$name','$date','$day','$stime','$etime','$aamount','$pamount','$ramount','$notes')";
         }
    }

    $result = $conn->query($sql);

    $sql_delete = "UPDATE requestguest SET `delete`='0' WHERE stime='$stime' AND etime='$etime'  AND date='$date'";
    $conn->query($sql_delete);
    header('location:request.php');
}
?>

<!DOCTYPE html>
<html lang="ar" dir="ltl">
<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="update.css">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/edit_information.css"> 
    <title> قبول الطلب</title>
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    

    

</head>
<body>
    <div class="container">

    <div class="img">
			<img src="photo/Update-pana.svg">
		</div>
        <form action="" method="post">
            <!--<h3>Edit Information</h3>-->
           
            <form action="#" method="post">
            <?php

if(isset($error)){
    foreach($error as $error){
    echo '<span class="error-msg">'.$error.'</span>';
};
};
?>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <!--<label for="name">Name:</label> -->
                الاسم: <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>">

             <!--   <label for="date">Date:</label> -->
               التاريخ: <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>">
                
               اليوم: <input type="text" id="day" name ="day" value="<?php echo $row['day']; ?>">
                
                وقت البداية: <input type="time" id=" start time" name="stime" value="<?php echo $row['stime']; ?>">

               
                وقت النهاية : <input type="time" id="end time" name="etime" value="<?php echo $row['etime']; ?>">

                
                المبلغ كاملًا : <input type="number" id="paid" name="aamount" value="">


                المبلغ المدفوع : <input type="number" id="paid" name="pamount" value="">

                
                المبلغ المتبقي :<input type="number" id="paid" name="ramount" value="">

                اسم القاعة :<input type="text" id="hall" name="hall" value="<?php echo $row['hall'];?>">


                
             ملاحظات <input type="text"  name="notes" value="">
                <!--<textarea id="notes" name="notes"><?php echo $row['notes']; ?></textarea> -->
                 
                <input type="submit" name="submit" value="التحديث والقبول" class="form-btn">

                <a href="HallType.php"> رجوع </a>
            </form>
        </form>
    </div>
</body>
</html>