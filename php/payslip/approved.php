<?php
// SQL Query เพื่อดึงข้อมูลสลิปเงินเดือนของพนักทั้งหมด
$sql = $conn->prepare(
    "SELECT 
        e.employee_id,
        CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
        d.department_name,
        p.salary,
        p.late_leave AS deduction,
        p.tax,
        p.social_security_fund,
        p.provident_fund,
        p.overtime,
        p.bonus,
        p.amount,
        p.payment_date,
        p.transaction_by,
        CASE 
            WHEN p.status = 0 THEN 'NOT APPROVE'
            ELSE 'APPROVED'
        END AS status
    FROM employees e
    JOIN departments d ON e.department_id = d.department_id
    JOIN payment_history p ON e.employee_id = p.employee_id
    WHERE p.payment_id = ?
");
// ซ่อนรหัสพนักงานและวันที่ออกสลิปของผู้ใช้ที่ค้นหา
$sql->bind_param("i", $payment_id);
// สคริปต์สำหรับแสดงสลิป
include_once 'slip.php';
?>