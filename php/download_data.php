<?php
// เริ่มการเชื่อมต่อฐานข้อมูล
require_once 'connect.php';
// วันปีและเดือนที่ต้องการโหลด
$year = $_POST['year'];
$month = date('m', strtotime($_POST['month']));
$isMonthSpecified = !empty($_POST['month']);
$dataType = $_POST['dataSelection'];
// กำหนดหัวข้อของแต่ละคอลัมน์ตาม dataType
$headers = [];
$sql = "";
switch ($dataType) {
    // SQL Query เพื่อดึงข้อมูลการเงินของพนักทั้งหมด
    case "financial-details":
        $headers = [
            'Employee ID', 'Name', 'Department', 'Salary', 'Tax', 
            'Social Security Fund', 'Provident Fund'
        ];
        $sql = 
            "SELECT 
                e.employee_id, 
                CONCAT(first_name, ' ', last_name) AS name, 
                department_name, 
                salary, 
                tax, 
                social_security_fund, 
                provident_fund 
            FROM employees e
            JOIN departments d ON e.department_id = d.department_id
            JOIN salary s ON e.employee_id = s.employee_id
            ORDER BY e.employee_id ASC 
        ";
        break;
    // SQL Query เพื่อดึงข้อมูลสรุปเงินเดือนของพนักทั้งหมด
    case "working-hours":
        $headers = [
            'Employee ID', 'Name', 'Department', 'Date', 'Overtime Hours', 
            'Overtime Pay', 'Deduction', 'On Time', 'Late', 'Leave'
        ];
        $sql = 
            "SELECT 
                e.employee_id, 
                CONCAT(first_name, ' ', last_name) AS name, 
                department_name, 
                DATE_FORMAT(w.work_date, '%Y-%m') AS work_month_year,
                SUM(w.overtime_hours) AS overtime_hours,
                SUM(w.wage) AS wage,
                CASE 
                    WHEN COUNT(CASE WHEN w.is_late = 1 THEN 1 END) > 3 THEN (COUNT(CASE WHEN w.is_late = 1 THEN 1 END) - 3) * 1.5
                    WHEN COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) > 2 THEN (COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) - 2) * 2.5
                    ELSE 0
                END AS deduction,
                COUNT(CASE WHEN w.is_on_time = 1 THEN 1 END) AS on_time_count,
                COUNT(CASE WHEN w.is_late = 1 THEN 1 END) AS late_count,
                COUNT(CASE WHEN w.is_leave = 1 THEN 1 END) AS leave_count
            FROM employees e
            JOIN departments d ON e.department_id = d.department_id
            JOIN work_time w ON e.employee_id = w.employee_id
        ";
        $stm = 
            " GROUP BY e.employee_id, work_month_year 
            ORDER BY work_month_year DESC, e.employee_id ASC
        ";
        if ($isMonthSpecified) {
            $sql .= "WHERE YEAR(w.work_date) = ? AND MONTH(w.work_date) = ?";
            $sql .= $stm;
        } else {
            $sql .= "WHERE YEAR(w.work_date) = ?";
            $sql .= $stm;
        }
        break;
    // SQL Query เพื่อดึงข้อมูลสรุปเงินเดือนของพนักทั้งหมด
    case "payment-history":
        $headers = [
            'Payment ID', 'Employee ID', 'Name', 'Department', 'Payment Date', 
            'Net Pay',  'Payment Status'
        ];
        $sql = 
            "SELECT 
                ph.payment_id,
                e.employee_id, 
                CONCAT(e.first_name, ' ', e.last_name) AS name, 
                d.department_name, 
                ph.payment_date,
                ph.amount,
                CASE 
                    WHEN ph.status = 0 THEN 'NOT APPROVE'
                    ELSE 'APPROVED'
                END AS status
                FROM employees e
            JOIN departments d ON e.department_id = d.department_id
            JOIN salary s ON e.employee_id = s.employee_id
            JOIN payment_history ph ON e.employee_id = ph.employee_id
        ";
        $stm = " ORDER BY payment_date DESC, e.employee_id ASC";
        if ($isMonthSpecified) {
            $sql .= "WHERE YEAR(payment_date) = ? AND MONTH(payment_date) = ?";
            $sql .= $stm;
        } else {
            $sql .= "WHERE YEAR(payment_date) = ?";
            $sql .= $stm;
        }
        break;
}
// ซ่อนปีและเดือนของข้อมูลที่ค้นหา
$sql = $conn->prepare($sql);
if ($isMonthSpecified) {
    $sql->bind_param('ii', $year, $month);
} else {
    $sql->bind_param('i', $year);
}
// รันคิวรีและโหลกข้อมูล
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    // กำหนดชื่อไฟล์ CSV
    if ($isMonthSpecified) {
        $filename = "{$dataType}-{$year}-{$month}.csv";
    } else {
        $filename = "{$dataType}-{$year}.csv";
    }
    // กำหนดประเภทของเนื้อหาและการเข้ารหัสเป็น UTF-8 สำหรับไฟล์ CSV
    header('Content-Type: text/csv; charset=utf-8');
    // กำหนดข้อมูลบังคับการดาวน์โหลดไฟล์และกำหนดชื่อไฟล์
    header("Content-Disposition: attachment; filename={$filename}");
    // เปิดไฟล์ CSV สำหรับเขียน
    $output = fopen('php://output', 'w');
    // เขียนหัวข้อของแต่ละคอลัมน์ลงไปในไฟล์
    fputcsv($output, $headers);
    // วนลูปเพื่อดึงข้อมูลที่ได้จากการคิวรี และเขียนลงไฟล์ CSV
    while($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}
// สิ้นสุดการเชื่อมต่อฐานข้อมูล
$conn->close(); 
?>