<!--done -->
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["month"]) && isset($_POST["year"])) {
        $selectedMonth = $_POST["month"];
        $selectedYear = $_POST["year"];

        // Prepare and execute SQL query
        $sql = "SELECT `name`, `date`,`day`, `stime`, `etime`, `aamount`,`pamount`, `ramount`, `notes` , `numb` FROM south WHERE MONTH(date) = ? AND YEAR(date) = ? AND `delete`=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $selectedMonth, $selectedYear);

        if (!$stmt->execute()) {
            echo "Error executing the query: " . $stmt->error;
        } else {
            $result = $stmt->get_result();
        }
    } else {
        
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <title>العرض بالشهر</title> 
    <link rel="stylesheet" type="text/css" href="css/show.css"> 
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="container">
    <div class="img">
			<!--<img src="photo/showmonth.svg">-->
		</div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        الشهر: <select name="month">
            <option value="">اختر الشهر</option>
            <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo "<option value=\"$i\">$i</option>";
                }
            ?>
        </select>
        السنة: <input type="number" name="year" min="2000" max="2100" required>
        <input type="submit" name="submit" value="إعرض">
    

    <?php
        if (isset($result)) {
            if ($result->num_rows > 0) {
              echo "<h2>نتيجة البحث:</h2>";
              echo "<table class='container0' id='myTable'>";
              echo "<thead><tr>";
              echo "<th>الاسم</th>";
              echo "<th>التاريخ</th>";
              echo "<th>اليوم</th>";
              echo "<th>وقت البداية </th>";
              echo "<th>وقت النهاية </th>";
              echo "<th>المبلغ كاملًا</th>";
              echo "<th>المبلغ المدفوع </th>";
              echo "<th> المبلغ المبقي</th>";
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
                echo "لا يوجد بيانات لعرضها في التاريخ الذي حددته";
            }
        }
    ?>
    <a href="south_hall.php"> رجوع </a>
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