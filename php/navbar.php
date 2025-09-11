<?php 
// ตรวจสอบการเข้าถึงเว็ป
require_once 'php/security.php'; 
// เริ่มการเชื่อมต่อฐานข้อมูล
require_once 'php/connect.php'; 
?>
<!-- Navigation Bar สีฟ้าๆ ที่สร้างด้วย Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- ชื่อแบรนด์ของเว็บไซต์ -->
        <a class="navbar-brand" href="#">PAYROLL</a>
        <!-- ปุ่มสำหรับ toggle ของ Navbar ในหน้าจอขนาดเล็ก -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- รายการของ Navbar -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <!-- ถ้าบทบาทเป็น 'ACCOUNTING' จะแสดงลิงก์ข้างล่าง -->
            <?php if ($role == 'ACCOUNTING'): ?>
            <ul class="navbar-nav">
                <!-- ลิงก์ไปหน้า payroll.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'payroll.php') echo 'active'; ?>" aria-current="page" href="payroll.php">
                        <i class="bi bi-house"></i>
                        Home
                    </a>
                </li>
                <!-- ลิงก์ไปหน้า accounting.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'accounting.php') echo 'active'; ?>" href="accounting.php">
                        <i class="bi bi-person-circle"></i>
                        Accounting
                    </a>
                </li>
                <!-- ลิงก์ไปหน้า summarize.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'summarize.php') echo 'active'; ?>" href="summarize.php">
                        <i class="bi bi-calendar-week"></i>
                        Summarize
                    </a>
                </li>
                <!-- ลิงก์ไปหน้า time_tracker.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'time_tracker.php') echo 'active'; ?>" href="time_tracker.php">
                        <i class="bi bi-alarm"></i>
                        Time Tracker
                    </a>
                </li>
                <!-- ลิงก์ไปหน้า payment.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'payment.php') echo 'active'; ?>" href="payment.php">
                        <i class="bi bi-bank"></i>
                        Payment
                    </a>
                </li>
                <!-- ลิงก์ไปหน้า transaction.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'transaction.php') echo 'active'; ?>" href="transaction.php">
                        <i class="bi bi-clock-history"></i>
                        Transaction
                    </a>
                </li>
                <!-- ลิงก์ไปหน้า report.php -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($page == 'report.php') echo 'active'; ?>" href="report.php">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Report
                    </a>
                </li>
            </ul>
            <?php endif ?>
            <!-- รายการของ Navbar ที่อยู่ทางขวา -->
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown สำหรับตัวเลือกของผู้ใช้ -->
                <li class="nav-item dropdown">
                    <!-- แสดงชื่อผู้ใช้งาน -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-file-person"></i>
                        <?php echo $name?>
                    </a>
                    <!-- เมนูตัวเลือกของผู้ใช้ -->
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <!-- ลิงก์เพื่อออกจากระบบและไปหน้า signout.php -->
                            <a class="dropdown-item" href="signout.php">
                                <i class="bi bi-door-closed"></i>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>