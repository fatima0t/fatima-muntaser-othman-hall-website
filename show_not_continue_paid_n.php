<!--done-->
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
?>

<!DOCTYPE html>
<html lan="ar" dir="rtl">
<head>
  <title>لم يدفع كاملًا</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

  <link rel="stylesheet" type="text/css" href="css/paid.css"> 
  <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  
</head>
<body>
  <div class="container">
    <form method="POST" action="">

    <?php
  
    
    

    $sql = "SELECT * FROM north WHERE `ramount`!=0  AND `delete`=1";
    $result = $conn->query($sql);

    if ($result === false) {
      // Handle the query error
      echo "Error executing the query: " . $conn->error;
    } else {
      
      if ($result->num_rows > 0) {
        
        // Display the search results
        /*echo "<h2>Search Results:</h2>"; */
       
        /*echo "<h2>Search Results:</h2>";*/
        echo "<table class='container0' id='myTable'>";
        echo "<thead><tr>";
        echo "<th>الاسم</th>";
        echo "<th>التاريخ</th>";
        echo "<th>اليوم</th>";
        echo "<th> وقت البداية</th>";
        echo "<th>وقت النهاية </th>";
        echo "<th>المبلغ كاملًا</th>";
        echo "<th> المبلغ المدفوع</th>";
        echo "<th> المبلغ المتبقي</th>";
        echo "<th>الملاحظات</th>";
        echo "<th>رقم الوصل</th>";
        echo "</tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["name"] . "</td>";
          echo "<td>" . $row["date"] . "</td>";
          echo "<td>" . $row["day"] . "</td>";
          echo "<td>" . $row["stime"] . "</td>";
          echo "<td>" . $row["etime"] . "</td>";
          echo "<td>" . $row["aamount"] . "</td>";
          echo "<td>" . $row["pamount"] . "</td>";
          echo "<td>" . $row["ramount"] . "</td>";
          echo "<td class='notes-column'>" . $row["notes"] . "</td>";
          echo "<td>" . $row["numb"] . "</td>";
          echo "</tr>";
        }

        echo "</tbody></table>";
        
        
      } else {
        echo "<p>No one found.</p>";
      }
    }
  
  ?>
      
    

      <a href="north_hall.php"> رجوع </a>
    </form>
  </div>

  
  <script>
$(document).ready(function() {
  $('#myTable').DataTable({
    language: {
      "sEmptyTable":     "لا توجد بيانات متاحة في الجدول",
      "sInfo":           "عرض _START_ إلى _END_ من _TOTAL_ مدخلات",
      "sInfoEmpty":      "عرض 0 إلى 0 من 0 مدخلات",
      "sInfoFiltered":   "(تصفية من _MAX_ مدخلات إجمالية)",
      "sLengthMenu":     "عرض _MENU_ مدخلات",
      "sLoadingRecords": "جارٍ التحميل...",
      "sProcessing":     "جارٍ المعالجة...",
      "sSearch":         "بحث:",
      "sZeroRecords":    "لم يتم العثور على أي سجلات",
      "oPaginate": {
        "sFirst":    "الأول",
        "sLast":     "الأخير",
        "sNext":     "التالي",
        "sPrevious": "السابق"
      },
      "oAria": {
        "sSortAscending":  ": تفعيل لترتيب العمود تصاعديًا",
        "sSortDescending": ": تفعيل لترتيب العمود تنازليًا"
      }
    }
  });
});
</script>
</body>
</html>


