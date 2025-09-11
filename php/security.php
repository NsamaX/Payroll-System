<?php
// เริ่มต้น session
session_start();
// ตรวจสอบว่า employee_id, name, role ได้ถูกตั้งค่าใน session หรือไม่
if (!isset($_SESSION["employee_id"]) || !isset($_SESSION["name"]) || !isset($_SESSION["role"])) {
    // ถ้าไม่ได้, ส่งผู้ใช้กลับไปที่ role.php
    header("Location: role.php");
    // สิ้นสุดสคริปต์เพื่อป้องกันการทำงานต่อ
    exit(); 
}
// นำ employee_id, name, role ไปใส่ในตัวแปร
$id = $_SESSION["employee_id"];
$name = $_SESSION["name"];
$role = $_SESSION["role"];
?>