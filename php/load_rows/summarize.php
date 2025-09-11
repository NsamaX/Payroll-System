<?php
// ตารางตารางข้อมูล
echo "<tbody id='employeeTableBody'>";
// จำนวนสูงสุดของแถวใน 1 หน้า
$rowsPerPage = 10;
// รับค่าหน้าปัจจุบันจาก URL หากไม่มีก็ใช้หน้าที่ 1 แทน
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
// คำนวณจุดเริ่มต้น (offset) สำหรับการดึงข้อมูลจากฐานข้อมูล
$offset = ($current_page - 1) * $rowsPerPage;
// SQL Query เพื่อดึงข้อมูลการเงินของพนักทั้งหมด
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
// รับฟิลเตอร์สำหรับกรองข้อมูล
$department = isset($_GET['department']) ? $_GET['department'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';
// แปลงค่าเดือนเป็นเลข
$numeric_month = '';
if (!empty($month)) {
    $numeric_month = date('m', strtotime($month));
}
// จัดการกับฟิลเตอร์เพื่อกรองข้อมูล
$conditions = [];
$bindings = [];
$types = '';
if ($department) {
    $conditions[] = "department_name = ?";
    $bindings[] = $department;
    $types .= "s";
}
if ($year) {
    $conditions[] = "YEAR(work_date) = ?";
    $bindings[] = (int)$year;
    $types .= "i";
}
if ($month) {
    $conditions[] = "MONTH(work_date) = ?";
    $bindings[] = (int)$numeric_month;
    $types .= "i";
}
// จัดการเงื่อนไข WHERE และ AND
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}
// เพิ่มเงื่อนไขการเรียงลำดับและจำกัดจำนวนแถวที่จะดึงมาแสดงผล
$sql .= 
    " GROUP BY e.employee_id, work_month_year
    ORDER BY work_month_year DESC, e.employee_id ASC
";
// SQL Query เพื่อคำนวณหน้า
$stm = $sql;
$sql .= " LIMIT $offset, $rowsPerPage";
// การเตรียมคำสั่ง SQL สำหรับการรัน
$sql = $conn->prepare($sql);
$stm = $conn->prepare($stm);
if (!empty($types)) {
    // ซ่อนฟิลเตอร์ที่ค้นหา
    $sql->bind_param($types, ...$bindings);
    $stm->bind_param($types, ...$bindings);
}
// รันคิวรีและแสดงข้อมูลบนตาราง
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <th scope='row'>".$row["employee_id"]."</th>
            <td>".$row["name"]."</td>
            <td>".$row["department_name"]."</td>
            <td>".$row["work_month_year"]."</td>
            <td>".number_format($row["overtime_hours"])."</td>
            <td>".number_format($row["wage"])."</td>
            <td>".$row["deduction"]."%</td>
            <td>".$row["on_time_count"]."</td>
            <td>".$row["late_count"]."</td>
            <td>".$row["leave_count"]."</td>
        </tr>";
    }
} else {
    // หากไม่พบข้อมูลแสดง No Data
    echo "<tr><td colspan=".count($headings)." style='text-align: center;'>No Data</td></tr>";
}
echo "</tbody>";
// แถบแสดงหน้าข้อมูล
include_once 'php/page_item.php';
?>