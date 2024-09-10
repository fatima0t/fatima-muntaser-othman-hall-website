<?php

@include 'dbconfig.php';

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
    <title>القاعة الجنوبية</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/hall.css"> 
    <link rel="icon" href="photo/icons8-palestine-48.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
</head>

</head>
<body>


<div class="navbar" >
<form action="HallType.php" method="post">
        <button type="submit"><i class="fas fa-arrow-left"></i> &emsp;رجوع</button>
    </form>

    <form action="show_not_continue_paid_s.php" method="post">
        <button type="submit"><i class="fas fa-times"></i> &emsp;لم يدفع كاملًا</button>
    </form>
    <form action="show_table_in_select_month_s.php" method="post">
        <button type="submit"><i class="fas fa-eye"></i> &emsp;العرض حسب الشهر</button>
    </form>

    

    <form action="search_s.php" method="post">
        <button type="submit"><i class="fas fa-search"></i> &emsp;البحث بواسطة التاريخ والوقت</button>
    </form>

    <form action="searchbyname_s.php" method="post">
        <button type="submit"><i class="fas fa-search"></i> &emsp;البحث بوساطة الاسم  </button>
    </form>
    
    <form action="add_new_s.php" method="post">
        <button type="submit"><i class="fas fa-plus"></i> &emsp;  اضافة جديد</button>
    </form>
   
    </div>
    <!-- <img width="200" src="photo\tab.svg" alt="no have photo" class="image-below-navbar"> -->
    
    

    


    <div class="container">
   
    <img width="25px" src="photo/icons8-ballons-64 (1).png" alt="no photo" >
<h2 ">التفاصيل</h2>
        <table class="table" id='myTable'>
            <thead>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
           
                <tr>
                    
                    <th>الاسم</th>
                    <th>التاريخ</th>
                    <th>اليوم </th>
                    <th>وقت البداية </th>
                    <th> وقت النهاية</th>
                    <th> المبلغ كاملًا  </th>
                    <th>المبلغ المدفوع </th>
                    <th> المبلغ المتبقي</th>
                   
                    <th>الملاحظات</th>
                    <th>  رقم الوصل</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM south WHERE `delete`=1";
                $result = $conn->query($sql);

                if ($result === false) {
                    // Handle the query error
                    echo "Error executing the query: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['day']; ?></td>
                                <td><?php echo $row['stime']; ?></td>
                                <td><?php echo $row['etime']; ?></td>
                                <td><?php echo $row['aamount']; ?></td>
                                <td><?php echo $row['pamount']; ?></td>
                                <td><?php echo $row['ramount']; ?></td>
                                <td class="notes-column"><?php echo $row['notes']; ?></td>
                                <td><?php echo $row['numb']; ?></td>
                                <td>
                                    <button class="btn btn-primary">
                                        <a href="edit_information_s.php?updateid=<?php echo $row['id']; ?>" class="text-light">تعديل</a>
                                    </button>
                                    <button class="btn btn-primary">
                                        <a href="delete_s.php?removeid=<?php echo $row['id']; ?>" class="text-light">حذف</a>
                                    </button>
                                </td>
                                
                                    
                                
                            </tr>
                            
                            <?php
                        }
                    } else {
                       /* echo "No records found.";*/
                    }
                }
                ?>

                
            </tbody>
        </table>
     
     <!--<a class="btn btn-info" href="http://localhost:8080/hall/add.php">add new</a> -->
                                    
       
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