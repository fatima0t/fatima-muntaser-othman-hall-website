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
$sql = "SELECT * FROM north WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo "Error executing query: " . $stmt->error;
    exit;
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header('location:north_hall.php');
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
    $numb = $_POST['numb'];

    $sql = "UPDATE north 
        SET name = ?, date = ?, day = ?, stime = ?, etime = ?, aamount = ?,pamount = ?, ramount = ?, notes = ?, numb= ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $name, $date, $day, $stime, $etime, $aamount, $pamount, $ramount, $notes, $numb, $id);

    if ($stmt->execute()) {
        echo 'Update successful';
        header('location:edit_information_n.php');
    } else {
        echo 'Error updating record: ' . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>التحديث</title>
    <link rel="stylesheet" type="text/css" href="css/edit_information.css">
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

    

</head>
<body>
    <div class="container">

    <div class="img">
			<img src="photo/update-pana.svg">
		</div>
        <form action="" method="post">
            <!--<h3>Edit Information</h3>-->
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    }
                }
            ?>
            <form action="#" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <!--<label for="name">Name:</label> -->
               الاسم: <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>">

             <!--   <label for="date">Date:</label> -->
               التاريخ: <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>">

               اليوم: <input type="text" id="day" name="day" value="<?php echo $row['day']; ?>">

                وقت البداية : <input type="time" id=" start time" name="stime" value="<?php echo $row['stime']; ?>">

               
                وقت النهاية : <input type="time" id="end time" name="etime" value="<?php echo $row['etime']; ?>">

                
                المبلغ كاملًا : <input type="number" id="paid" name="aamount" value="<?php echo $row['aamount']; ?>">

                  المبلغ المدفوع: <input type="number" id="paid" name="pamount" value="<?php echo $row['pamount']; ?>">

                
                المبلغ المتبقي :<input type="number" id="paid" name="ramount" value="<?php echo $row['ramount']; ?>">

                
                الملاحظات : <input type="text"  name="notes" value="<?php echo $row['notes']; ?>">
                <!--<textarea id="notes" name="notes"><?php echo $row['notes']; ?></textarea> -->
                رقم الوصل : <input type="text" id="numb" name="numb" value="<?php echo $row['numb']; ?>">
                <input type="submit" name="submit" value="التحديث الان  " class="form-btn">
            </form>
        </form>
    </div>
</body>
</html>