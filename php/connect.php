<?php
// กำหนดค่าตัวแปรสำหรับการเชื่อมต่อ
$servername = "localhost";  // ชื่อของเซิร์ฟเวอร์
$username = "";         // ชื่อผู้ใช้งานฐานข้อมูล
$password = "";             // รหัสผ่านของฐานข้อมูล
$dbname = "";             // ชื่อฐานข้อมูล
// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
// ตรวจสอบการเชื่อมต่อ ถ้าไม่สำเร็จจะแสดงข้อความแจ้งเตือน
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>