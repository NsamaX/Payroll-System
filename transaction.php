<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- หัวข้อหน้าเว็บ -->
        <title>Transaction</title>
        <!-- ใช้สไตล์ที่สร้างเอง -->
        <link rel="stylesheet" href="css/styles.css">
        <!-- ใช้สไตล์จาก Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- ใช้ไอคอนจาก Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <!-- ใช้สคริปต์จาก Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- ใช้สคริปต์จาก jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <!-- แถบนำทาง -->
        <header>
            <?php 
            $page = 'transaction.php';
            include_once 'php/navbar.php'; 
            ?>
        </header>
        <main class="table-responsive">
            <!-- ตารางแสดงข้อมูล -->
            <table class="table table-striped table-hover">
                <?php 
                // ส่วนหัวข้อของตาราง
                $headings = array(
                    "Employee ID",
                    "Name",
                    "Department",
                    "Transaction Date",
                    "Description"
                );
                include_once 'php/table_heading.php';
                // ส่วนเนื้อหาข้อของตาราง
                include_once 'php/load_rows/transaction.php';
                ?>       
            </table>
        </main>
    </body>
    <?php
    // สิ้นสุดการเชื่อมต่อฐานข้อมูล
    $conn->close(); 
    ?>
</html>