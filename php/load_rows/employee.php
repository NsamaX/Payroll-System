<?php
// ตารางตารางข้อมูล
echo "<tbody id='employeeTableBody'>";
// จำนวนสูงสุดของแถวใน 1 หน้า
$rowsPerPage = 12;
// รับค่าหน้าปัจจุบันจาก URL หากไม่มีก็ใช้หน้าที่ 1 แทน
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
// คำนวณจุดเริ่มต้น (offset) สำหรับการดึงข้อมูลจากฐานข้อมูล
$offset = ($current_page - 1) * $rowsPerPage;
// SQL Query เพื่อดึงข้อมูลสลิปของพนักทั้งหมด
$sql = 
    "SELECT 
        payment_id,
        payment_date, 
        amount 
    FROM payment_history
    WHERE employee_id = ?
";
// รับฟิลเตอร์สำหรับกรองข้อมูล
$year = isset($_GET['year']) ? $_GET['year'] : '';
// จัดการกับฟิลเตอร์เพื่อกรองข้อมูล
$bindings[] = (int)$id;
$types = 'i';
// จัดการเงื่อนไข WHERE และ AND
if ($year) {
    $sql .= " AND YEAR(payment_date) = ?";
    $bindings[] = (int)$year;
    $types .= "i";
}
// เพิ่มเงื่อนไขการเรียงลำดับและจำกัดจำนวนแถวที่จะดึงมาแสดงผล
$sql .= " ORDER BY payment_date DESC";
// SQL Query เพื่อคำนวณหน้า
$stm = $sql;
$sql .= " LIMIT $offset, $rowsPerPage";
// การเตรียมคำสั่ง SQL สำหรับการรัน
$sql = $conn->prepare($sql);
$stm = $conn->prepare($stm);
// ซ่อนฟิลเตอร์ที่ค้นหา
$sql->bind_param($types, ...$bindings);
$stm->bind_param($types, ...$bindings);
// รันคิวรีและแสดงข้อมูลบนตาราง
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // รับรหัสพนักงาน วันที่ และสถานะ เพื่อสร้างที่อยู่ลิงก์
        $payment_date = $row["payment_date"];
        $slip_status = $row["status"];
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
                <td>".$row["payment_date"]."</td>
                <td>
                    <a href='$link' style='color: black; text-decoration: none;' class='status-link'>
                        ".number_format($row["amount"])."
                        <i class='bi bi-arrow-up-right-circle' style='color: blue;'></i>
                    </a>
                </td>
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