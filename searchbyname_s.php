<?php
// Start the session
include "dbconfig.php";
session_start();
$email = $_SESSION["email"];

// Check if the user's session is valid and they are logged in
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <title>البحث بواسطة الاسم</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/name.css"> 
  <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">  <style>
  <style>
    body {
      font-family: 'Cairo', sans-serif;    }
    .container {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      
      padding: 10px;
    }
    .form-container {
      flex: 1;
      max-width: 400px; /* Limit the form width */
      margin-right: 200px;
      margin-top: 50px;
    }
    .img-container {
      flex: 1;
      max-width: 400px; /* Limit the image width */
      margin-left: 90px;
      margin-top: 160px;
     }
    .img-container img {
      width: 100%; /* Make the image responsive */
      height: auto;
    }
    @media (max-width: 768px) {
      .container {
        flex-direction: column; /* Stack elements vertically on small screens */
      }
      .form-container {
        margin-right: 0; /* Remove margin on small screens */
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container">
      <div class="login-content">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <label for="name">أدخل الإسم:</label>
          <input type="text" id="name" name="name">
          <br><br>
          <input type="submit" name="submit" value="ابحث">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit']) && !empty($_GET['name'])) {
              $name = $_GET['name'];

              $stmt = $conn->prepare("SELECT * FROM south WHERE name = ? AND `delete`=1");
              $stmt->bind_param("s", $name);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result === false) {
                  echo "Error executing the query: " . $conn->error;
              } else {
                  if ($result->num_rows > 0) {
                      echo "<h2>نتيجة البحث:</h2>";
                      echo "<table class='container0' id='myTable'>";
                      echo "<thead><tr>";
                      echo "<th>الاسم</th>";
                      echo "<th>التاريخ</th>";
                      echo "<th>اليوم</th>";
                      echo "<th>وقت البداية</th>";
                      echo "<th>وقت النهاية</th>";
                      echo "<th>المبلغ كاملًا</th>";
                      echo "<th>المبلغ المدفوع</th>";
                      echo "<th>المبلغ المتبقي</th>";
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
                          echo "<td>" . $row["notes"] . "</td>";
                          echo "<td>" . $row["numb"] . "</td>";
                          echo "</tr>";
                      }

                      echo "</tbody></table>";
                  } else {
                      echo "<p>لا يوجد بيانات لعرضها</p>";
                  }
              }
              $stmt->close();
          }
          ?>
          <a href="south_hall.php"> رجوع </a>
        </form>
      </div>
    </div>
    <div class="img-container">
    <img src="photo/People search-amico.svg" alt="People Search" loading="lazy">
    </div>
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