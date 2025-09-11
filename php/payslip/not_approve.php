<?php
// SQL Query เพื่อดึงข้อมูลสำหรับสร้างสลิป
$sql =  $conn->prepare(
    "SELECT 
        employee_id, 
        payment_date
    FROM payment_history 
    WHERE payment_id = ?
");
// ซ่อนชื่อและรหัสพนักงานของผู้ใช้ที่ค้นหา
$sql->bind_param("i", $payment_id);
// รันคิวรีและแสดงข้อมูลบนตาราง
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
$id = $row["employee_id"];
$payment_date = $row["payment_date"];
// SQL Query เพื่อดึงข้อมูลเงินเดือนของพนักทั้งหมด
$sql =  $conn->prepare(
    "SELECT 
        e.employee_id, 
        CONCAT(e.first_name, ' ', e.last_name) AS employee_name, 
        d.department_name AS department_name, 
        s.salary AS salary,
        CASE 
            WHEN COUNT(CASE WHEN w.is_late = 1 THEN 1 END) > 3 THEN ((COUNT(CASE WHEN w.is_late = 1 THEN 1 END) - 3) * 1.5)
            WHEN COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) > 2 THEN ((COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) - 2) * 2.5)
            ELSE 0
        END AS deduction,
        s.tax,
        s.social_security_fund,
        s.provident_fund,
        SUM(w.wage) AS overtime,
        0 AS bonus,
        DATE_FORMAT(CURRENT_DATE, '%Y-%m-%d') AS payment_date,
        ? AS transaction_by,
        'NOT APPROVE' AS status
    FROM employees e
    JOIN departments d ON e.department_id = d.department_id
    JOIN salary s ON e.employee_id = s.employee_id
    JOIN work_time w ON e.employee_id = w.employee_id
    WHERE e.employee_id = ? AND YEAR(w.work_date) = DATE_FORMAT(?, '%Y') AND MONTH(w.work_date) = DATE_FORMAT(?, '%m')
    GROUP BY e.employee_id, employee_name, department_name, salary, tax, social_security_fund, provident_fund
");
if ($role != 'ACCOUNTING') {
    $name = "";
}
// ซ่อนชื่อและรหัสพนักงานของผู้ใช้ที่ค้นหา
$sql->bind_param("siss", $name, $id, $payment_date, $payment_date);
// สคริปต์สำหรับแสดงสลิป
include_once 'slip.php';
?>