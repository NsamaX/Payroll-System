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
    $conditions[] = "YEAR(payment_date) = ?";
    $bindings[] = (int)$year;
    $types .= "i";
}
if ($month) {
    $conditions[] = "MONTH(payment_date) = ?";
    $bindings[] = (int)$numeric_month;
    $types .= "i";
}
// จัดการเงื่อนไข WHERE และ AND
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}
// เพิ่มเงื่อนไขการเรียงลำดับและจำกัดจำนวนแถวที่จะดึงมาแสดงผล
$sql .= 
    " GROUP BY ph.payment_id 
    ORDER BY YEAR(ph.payment_date) DESC, MONTH(ph.payment_date) DESC, e.employee_id ASC
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
        // สีของสถานะสลิป
        $statusColor = "";
        if ($row["status"] == "APPROVED") {
            $statusColor = "green";
        }  else {
            $statusColor = "red";
        }
        // รับค่าตัวกรองเพื่อใช้กรองข้อมูลในหน้าอื่นต่อไป
        $queryStrings = [];
        foreach ($_GET as $key => $value) {
            $queryStrings[] = "$key=$value";
        }
        $filterQueryString = implode('&', $queryStrings);
        $filterQueryString = !empty($filterQueryString) ? "&$filterQueryString" : '';
        // สร้างที่อยู่ลิงก์เพื่อส่งข้อมูลรหัสสลิปของพนักงานแต่ละคน
        $link = "payslip.php?$filterQueryString&payment_id=".$row["payment_id"];
        echo "<tr>
                <th scope='row'>".$row["employee_id"]."</th>
                <td>".$row["name"]."</td>
                <td>".$row["department_name"]."</td>
                <td>".$row["payment_date"]."</td>
                <td>".number_format($row["amount"])."</td>
                <td><a href='$link' style='color: ".$statusColor."; text-decoration: none; class='status-link'>".$row["status"]."</a></td>
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