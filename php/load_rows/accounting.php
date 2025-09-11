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
        salary, 
        tax, 
        social_security_fund, 
        provident_fund 
    FROM employees e
    JOIN departments d ON e.department_id = d.department_id
    JOIN salary s ON e.employee_id = s.employee_id
";
// ตัวกรองข้อมูลที่จะแสดง
$department = isset($_GET['department']) ? $_GET['department'] : '';
if ($department) {
    $sql .= " WHERE department_name = ?";
}
// เพิ่มเงื่อนไขการเรียงลำดับและจำกัดจำนวนแถวที่จะดึงมาแสดงผล
$sql .= " ORDER BY e.employee_id ASC";
// SQL Query เพื่อคำนวณหน้า
$stm = $sql;
$sql .= " LIMIT $offset, $rowsPerPage";
// การเตรียมคำสั่ง SQL สำหรับการรัน
$sql = $conn->prepare($sql);
$stm = $conn->prepare($stm);
if (!empty($department)) {
    // ซ่อนชื่อแผนกที่ค้นหา
    $sql->bind_param("s", $department);
    $stm->bind_param("s", $department);
}
// รันคิวรีและแสดงข้อมูลบนตาราง
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // คำนวณเงินเดือนหลังหัก
        $social_security_fund = $row["salary"] * ($row["social_security_fund"] / 100);
        if ($social_security_fund > 750) {
            $social_security_fund = 750;
        }
        $provident_fund = $row["salary"] * ($row["provident_fund"] / 100);
        $salary_after_deductions_fund = $row["salary"] - $provident_fund - $social_security_fund;
        $salary_after_deductions_tax = $row["salary"] * ($row["tax"] / 100);
        echo 
            "<tr>
                <th scope='row'>".$row["employee_id"]."</th>
                <td>".$row["name"]."</td>
                <td>".$row["department_name"]."</td>
                <td>".number_format($row["salary"])."</td>
                <td>".number_format($salary_after_deductions_fund)."</td>
                <td>".number_format($salary_after_deductions_tax)."</td>
                <td>".number_format($row["tax"])."%</td>
                <td>".$row["social_security_fund"]."%</td>
                <td>
                    ".$row["provident_fund"]."%
                    <a href='#' class='open-modal' data-employee_id='".$row["employee_id"]."' data-name='".$row["name"]."' data-salary='".number_format($row["salary"], 2)."' data-tax='".$row["tax"]."' data-social_security_fund='".$row["social_security_fund"]."' data-provident_fund='".$row["provident_fund"]."'><i class='bi bi-pen'></i></a>
                </td>
            </tr>";
    }
    include_once 'php/load_rows/accounting_form.php';
} else {
    // หากไม่พบข้อมูลแสดง No Data
    echo "<tr><td colspan=".count($headings)." style='text-align: center;'>No Data</td></tr>";
}
echo "</tbody>";
// แถบแสดงหน้าข้อมูล
include_once 'php/page_item.php';
?>