<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- หัวข้อหน้าเว็บ -->
        <title>Payslip</title>
        <!-- สไตล์ภายในหน้า -->
        <style>
            table tbody td:first-child {
                width: 70%;
            }
            table tbody td:not(:first-child) {
                width: 10%;
                text-align: end;
            }
        </style>
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
        <!-- ใช้สคริปต์ที่สร้างเองสำหรับแสดงสีสถานะสลิป -->
        <script src="js/slip_status.js"></script> 
        <!-- ใช้สคริปต์จาก cloudflare -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <!-- ใช้สคริปต์ที่สร้างเองสำหรับดาวน์โหลดสลิป -->
        <script src="js/download_slip.js"></script> 
    </head>
    <body>
        <header>
            <?php 
            // แถบนำทาง
            $page = 'payslip.php';
            include_once 'php/navbar.php'; 
            ?>
        </header>
        <main class="container mt-5 table-responsive">
        <?php
        
        include_once 'php/connect.php'; 
        // รับรหัสพนักงาน วันที่ และสถานะ เพื่อแสดงสลิป
        $payment_id = $_GET['payment_id'];
        // SQL Query เพื่อดึงข้อมูลเงินเดือนแบ่งตามแผนก
        $sql = $conn->prepare(
            "SELECT status
            FROM payment_history
            WHERE payment_id = ?
        ");
        $sql->bind_param("i", $payment_id);
        // รันคิวรีและแสดงข้อมูลบนตาราง
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        // ตรวจสอบสถานะของสลิป
        if ($row["status"] == 1) {
            include_once 'php/payslip/approved.php';
        } else {
            include_once 'php/payslip/not_approve.php';
        }
        ?>
        <br>
        </main>
    </body>
    <?php
    // สิ้นสุดการเชื่อมต่อฐานข้อมูล
    $conn->close(); 
    ?>
</html>