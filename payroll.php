<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- หัวข้อหน้าเว็บ -->
        <title>Payroll</title>
        <!-- สไตล์ภายในหน้า -->
        <style>
            .card-group .card {
                border: none;
            }
            table tbody td:last-child {
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
        <!-- ใช้สคริปต์ที่สร้างเองสำหรับแสดงวันที่ -->
        <script src="js/date.js"></script>
        <!-- ใช้สคริปต์ Chart.js สำหรับแสดงกราฟ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- ใช้สคริปต์ที่สร้างเองสำหรับแสดงกราฟเงินเดือน -->
        <script src="js/salary_charts.js"></script>
    </head>
    <body>
        <header>
            <?php 
            // แถบนำทาง
            $page = 'payroll.php';
            include_once 'php/navbar.php'; 
            ?>
        </header>
        <main class="container mt-5">
            <!-- ข้อมูลประจำวัน -->
            <h2>Daily Reports</h2>
            <p class="date"></p>
            <!-- รายการแจ้งเตือน -->
            <h4>Notifications</h4>
            <ul class="list-group">
                <!-- รายการแจ้งเตือนแต่ละข้อ -->
                <li class="list-group-item">Notification 1: Important Information</li>
                <li class="list-group-item">Notification 2: Important Event</li>
                <!-- เพิ่มรายการแจ้งเตือนตามความจำเป็น -->
            </ul>
            <br>
            <!-- รายการขอความช่วยเหลือ -->
            <h4>Requests</h4>
            <ul class="list-group">
                <!-- รายการขอความช่วยเหลือแต่ละข้อ -->
                <li class="list-group-item">Request 1: Amount needed for project X</li>
                <li class="list-group-item">Request 2: Travel expense reimbursement</li>
                <!-- เพิ่มรายการขอความช่วยเหลือตามความจำเป็น -->
            </ul>
            <!-- ส่วนของรายงานและกราฟ -->
            <div class="card-group content text-center">
                <!-- กราฟวงกลมของเงินเดือน -->
                <div class="card card-body" style="display: flex; justify-content: center; align-items: center;">
                    <h4 class="card-title">Payroll Insights</h4>
                    <canvas id="salaryPieChart" style="max-width: 50%; max-height: 45vh;"></canvas>
                </div>
                <!-- กราฟแท่งของเงินเดือน -->
                <div class="card card-body" style="padding-top: 10%; padding-right: 10%;">
                    <canvas id="salaryBarChart"></canvas>
                </div>
            </div>
            <?php
            // ส่วนของตารางเงินเดือนแบ่งตามแผนก
            include_once 'php/load_rows/payroll.php'
            ?>
        </main>
        <footer class="container mt-5">
            <!-- ข้อมูลติดต่อสำหรับสนับสนุน -->
            <p class="text-center">Contact Information: support@example.com | Tel: xxx-xxx-xxxx</p>
        </footer>
    </body>
    <?php
    // สิ้นสุดการเชื่อมต่อฐานข้อมูล
    $conn->close(); 
    ?>
</html>