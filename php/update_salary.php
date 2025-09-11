<?php
// ตรวจสอบการเข้าถึงเว็ป
require_once 'security.php'; 
// เริ่มการเชื่อมต่อฐานข้อมูล
require_once 'connect.php'; 
// รับข้อมูลจากฟอร์ม
$employee_id = $_POST["field_employee_id"];
$employee_name = $_POST["hidden_name"];
// ลบ comma ออกจาก salary และแปลงเป็น float
$salary = floatval(str_replace(',', '', $_POST["field_salary"]));
// ปัดค่าทศนิยมให้มีทั้งหมด 2 ตำแหน่ง
$salary = round($salary, 2);
$tax = round($_POST["hidden_tax"], 2);
$social_security_fund = round($_POST["field_social_security_fund"], 2);
$provident_fund = round($_POST["field_provident_fund"], 2);
$path = $_POST["path"];
// SQL Query เพื่อแก้ไขข้อมูลในตาราง salary
$sql = 
    "UPDATE salary 
    SET 
        salary = ?,
        tax = ?,
        social_security_fund = ?,
        provident_fund = ?
    WHERE employee_id = ?
";
// การเตรียมคำสั่ง SQL สำหรับการรัน
$sql = $conn->prepare($sql);
// ซ่อนข้อมูลที่จะแก้ไข
$sql->bind_param("ddddi", $salary, $tax, $social_security_fund, $provident_fund, $employee_id);
// SQL Query เพื่อ insert
$stm = $conn->prepare(
    "INSERT INTO transactions (employee_id, transaction_date, transaction_description) VALUES 
        (?, CURRENT_DATE(), CONCAT(?, ' update the salary of ', ?, ' at ', CURRENT_TIME()))
");
// ผูกตัวแปร PHP กับ parameter ใน SQL statement
$stm->bind_param(
    "iss", 
    $employee_id, 
    $name, 
    $employee_name
);
// ทำการ execute SQL statement
if ($sql->execute() && $stm->execute()) {
    echo "<script type='text/javascript'>alert('An error occurred: ".$sql->error." or ".$stm->error."');</script>";
}
// กลับไปยังหน้าเว็บปัจจุบัน
header("Location: $path");
// สิ้นสุดการเชื่อมต่อฐานข้อมูล
$conn->close(); 
?>