<!--done-->

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
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <title>البحث</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/search.css"> 
  <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  
</head>
<body>
  <div class="container">
  <div class="img">
			<img src="photo/undraw_season_change_f99v.svg">
		</div>
    
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <br>
      
    
      <label for="date">حدد التاريخ</label>
      <input type="date" id="date" name="date">
      <br><br>
      <label for="time">حدد وقت البداية  :</label>
      <input type="time" id="stime" name="stime" step="60">
      <br><br>
      <label for="time">  حدد وقت النهاية:</label>
      <input type="time" id="etime" name="etime" step="60">
      <br><br>
      <!--<button type="submit">Search</button>-->
      <input type="submit" name="submit" value="ابحث">
     
      
      <?php
include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])) {
  $date = isset($_GET['date']) ? $_GET['date'] : '';
  $stime = isset($_GET['stime']) ? date('H:i:s', strtotime($_GET['stime'])) : '';
  $etime = isset($_GET['etime']) ? date('H:i:s', strtotime($_GET['etime'])) : '';

  $sql = "SELECT * FROM south WHERE (date= '$date') AND (( '$stime' BETWEEN stime And etime ) 
          OR ( '$etime' BETWEEN stime And etime ) 
          OR ( etime BETWEEN '$stime' And '$etime' ) 
          OR ( etime BETWEEN '$stime' And '$etime' )) ";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<p>هذا الموعد محجوز</p>";
  } else {
    echo "<p>يمكنك حجز هذا الموعد </p>";
  }
}
?>
<a href="south_hall.php"> رجوع </a>
    </form>
   
  </div>

  
  <!--<a href="south_hall.php"><button>Back</button></a>-->

</body>
</html>


