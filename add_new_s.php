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

?>
<?php

if (isset($_POST['submit'])) {
        
    $name = $_POST['name'];
    $date =  $_POST['date'];
    $day =  $_POST['day'];
    $stime= $_POST['stime'];
	$etime= $_POST['etime'];
  $aamount= $_POST['aamount'];
    $pamount= $_POST['pamount'];
	$ramount= $_POST['ramount'];
    $notes= $_POST['notes'];
    
    

    

    $sql= "SELECT * FROM south WHERE (date= '$date') AND (( '$stime' BETWEEN stime And etime ) 
    OR ( '$etime' BETWEEN stime And etime ) 
    OR ( etime BETWEEN '$stime' And '$etime' ) 
    OR ( etime BETWEEN '$stime' And '$etime' )) ";
    $result = $conn->query($sql);
    if ($result->num_rows>0){
            $error[]= "هذا الموعد محجوز";
    }
    else{
            $sql="INSERT INTO south(name,date,day,stime,etime,aamount,pamount,ramount,notes) 
            VALUES('$name','$date','$day','$stime','$etime','$aamount','$pamount','$ramount','$notes')";
            $conn->query($sql);
            $error[]= "تمت الإضافة بنجاح";

        }
    }
;
?>



<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اضافة جديد</title>
    <link rel="stylesheet" type="text/css" href="css/edit_information.css">
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">



</head>
<body>
    <div class="container">

    <div class="img">
    <img src="photo/Add files-cuate.svg">
		</div>
        <form action="" method="post">
            <!--<h3>Edit Information</h3>-->
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                        echo '<br>';
                    }
                }
            ?>
            
                
                الاسم: <input type="text" name="name" autocomplete="off" required ">

             <!--   <label for="date">Date:</label> -->
               التاريخ: <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>">
               
                اليوم: <input type="text" id=" day " name="day" autocomplete="off" required ">

                
                 وقت البداية: <input type="time" id=" start time" name="stime" autocomplete="off" required ">

               
                وقت النهاية : <input type="time" id="end time" name="etime" autocomplete="off" required">

                 المبلغ كاملًا: <input type="number" id="paid" name="aamount" autocomplete="off" required ">

                
                المبلغ المدفوع : <input type="number" id="paid" name="pamount" autocomplete="off" required ">

                
                 المبلغ المتبقي:<input type="number" id="paid" name="ramount" autocomplete="off" required ">

                
                الملاحظات: <input type="text"  name="notes" autocomplete="off" required">
                
                 
                <input type="submit" name="submit" value=" اضافة جديد" class="form-btn">
                <a href="south_hall.php"> رجوع </a>
            </form>
        </form>
    </div>
</body>
</html>