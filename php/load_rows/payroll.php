<table class="table table-striped table-hover">
    <tbody>
    <?php
    // SQL Query เพื่อดึงข้อมูลเงินเดือนแบ่งตามแผนก
    $sql = $conn->prepare(
        "SELECT 
            department_name, 
            sum(salary) as salary
        FROM employees e
        JOIN departments d ON e.department_id = d.department_id
        JOIN salary s ON e.employee_id = s.employee_id
        GROUP BY d.department_id
        ORDER BY salary DESC
    ");
    // รันคิวรีและแสดงข้อมูลบนตาราง
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo 
                "<tr>
                    <td scope='row'>".$row["department_name"]."</td>
                    <td>".number_format($row["salary"])."</td>
                </tr>";
        }
    } else {
        // หากไม่พบข้อมูลแสดง No Data
        echo "<tr><td colspan=".count($headings)." style='text-align: center;'>No Data</td></tr>";
    }
    ?>
    </tbody>
</table>