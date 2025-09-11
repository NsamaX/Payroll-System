<?php
// ตารางตารางข้อมูล
echo "<tbody id='employeeTableBody'>";
// จำนวนสูงสุดของแถวใน 1 หน้า
$rowsPerPage = 10;
// รับค่าหน้าปัจจุบันจาก URL หากไม่มีก็ใช้หน้าที่ 1 แทน
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
// คำนวณจุดเริ่มต้น (offset) สำหรับการดึงข้อมูลจากฐานข้อมูล
$offset = ($current_page - 1) * $rowsPerPage;
// SQL Query เพื่อดึงข้อมูลสรุปเงินเดือนของพนักทั้งหมด
$sql = 
    "SELECT 
        e.employee_id, 
            CONCAT(first_name, ' ', last_name) AS name, 
            department_name, 
            work_date,
            SUM(overtime_hours) AS overtime_hours, 
            MIN(arrival_time) AS arrival_time, 
            MAX(departure_time) AS departure_time, 
            CASE 
                WHEN MAX(is_on_time) = 1 THEN 'On Time'
                WHEN MAX(is_late) = 1 THEN 'Late'
                WHEN MAX(is_leave) = 1 THEN 'Leave'
            END AS status
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
    " GROUP BY e.employee_id, CONCAT(first_name, ' ', last_name), department_name, work_date 
    ORDER BY w.work_date DESC, e.employee_id ASC
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
    while($row = $result->fetch_assoc()) {
        if ($row["arrival_time"] == null) {
            $row["arrival_time"] = '-';
            $row["departure_time"] = '-';
        }
        // สีของสถานะการมาทำงาน
        $statusColor = "";
        if ($row["status"] == "On Time") {
            $statusColor = "green";
        } elseif ($row["status"] == "Late") {
            $statusColor = "orange";
        } else {
            $statusColor = "red";
        }
        echo 
            "<tr>
                <th scope='row'>".$row["employee_id"]."</th>
                <td>".$row["name"]."</td>
                <td>".$row["department_name"]."</td>
                <td>".$row["work_date"]."</td>
                <td>".number_format($row["overtime_hours"])."</td>
                <td>".$row["arrival_time"]."</td>
                <td>".$row["departure_time"]."</td>
                <td style='color: ".$statusColor."'>".$row["status"]."</td>
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