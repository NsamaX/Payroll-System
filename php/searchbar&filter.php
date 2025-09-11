<tr>
    <!-- ขยายความกว้าของแถมตามค่า colspan ที่ถูกตั้ง -->
    <th colspan="<?php echo count($headings); ?>">
        <form class="d-flex justify-content-end">
            <?php
            if ($page != 'employee.php') {
            // แถบค้นหา
            echo "<input class='form-control w-50 me-2' type='search' placeholder='Search' aria-label='Search'>";
            // สคริปต์สำหรับหาข้อมูล
            echo "<script src='js/search.js'></script>";
            // ปุ่มแบบดรอปดาวน์สำหรับตัวกรอง
            }
            ?>
            <div class='btn-group'>
                <!-- ปุ่มสำหรับเปิด/ปิด ดรอปดาวน์ -->
                <button class='btn btn-primary dropdown-toggle' type='button' id='defaultDropdown' data-bs-toggle='dropdown' data-bs-auto-close='true' aria-expanded='false'>
                    Filter
                </button>
                <!-- เมนูดรอปดาวน์ -->
                <ul class='dropdown-menu' aria-labelledby='defaultDropdown'>
                    <?php
                    // ตัวเลือกสำหรับกรองข้อมูล
                    echo "<li><a class='dropdown-item' href='$page'>Clear</a></li>";
                    if ($page != 'employee.php') {
                        if ($page != 'accounting.php'){
                            echo "<select class='form-control' id='year' name='year'>
                                    <option value=''>Select a year</option>
                            ";
                            // ดึงข้อมูลปีทั้งหมดที่มีการชำระเงิน
                            $years = [];
                            $sql = $conn->prepare(
                                "SELECT DISTINCT YEAR(payment_date) AS year
                                FROM payment_history
                                ORDER BY year DESC
                            ");
                            $sql->execute();
                            $result = $sql->get_result();
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $years[] = $row["year"];
                                    echo "<option value='".$row["year"]."'>".$row["year"]."</option>";
                                }
                                // ดึงข้อมูลเดือนทั้งหมดที่มีการชำระเงินตามในแต่ละปี
                                $monthsInDb = [];
                                foreach ($years as $year) {
                                    $sql = $conn->prepare(
                                        "SELECT DISTINCT MONTH(payment_date) AS month
                                        FROM payment_history
                                        WHERE YEAR(payment_date) = ?
                                        ORDER BY month ASC
                                    ");
                                    $sql->bind_param('i', $year);
                                    $sql->execute();
                                    $result = $sql->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $monthsInDb[$year][] = $row['month'];
                                    }
                                }
                            } else {
                                echo "<option>No Data</option>";
                            }
                            echo "</select>";
                            // ดรอปดาวน์เมนูสำหรับเดือน (เริ่มต้นแบบซ่อนและไม่ใช้งาน)
                            echo "<select class='form-control' id='month' name='month' style='display: none;' disabled></select>";
                            include_once 'php/select_year.php';
                        }
                        echo "<select class='form-control' id='department' name='department'>
                                <option value=''>Department</option>
                        ";
                        // SQL Query เพื่อสำหรับเลือกชื่อแผนก
                        $sql = $conn->prepare("SELECT department_name FROM departments");
                        $sql->execute();
                        $result = $sql->get_result();
                        // ตรวจสอบว่ามีแถวในผลลัพธ์หรือไม่
                        if ($result->num_rows > 0) {
                            // วนลูปชื่อแผนก
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='".$row["department_name"]."'>".$row["department_name"]."</option>";
                            }
                        }
                        echo "</select>";
                        // ปุ่ม Apply Filters
                        echo '<button class="btn btn-outline-primary" style="width: 100%; text-align: left;" onclick="updateFilter()">Apply Filters</button>';
                    } else {
                        // SQL Query เพื่อสำหรับเลือกชื่อแผนก
                        $sql = $conn->prepare(
                            "SELECT DISTINCT YEAR(payment_date) AS year
                            FROM payment_history
                            WHERE employee_id = ?
                            ORDER BY year DESC
                        ");
                        // ซ่อนรหัสพนักงานที่ค้นหา
                        $sql->bind_param("i", $id);
                        $sql->execute();
                        $result = $sql->get_result();
                        // ตรวจสอบว่ามีแถวในผลลัพธ์หรือไม่
                        if ($result->num_rows > 0) {   
                            // เส้นขั้น
                            echo "<li><hr class='dropdown-divider'></li>";                 
                            // วนลูปชื่อแผนก
                            while($row = $result->fetch_assoc()) {
                                echo "<li><a class='dropdown-item' href='$page?year=".$row["year"]."'>".$row["year"]."</a></li>";
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </form>
    </th>
</tr>
<!-- สคริปต์ที่เจ้าสร้างเองสำหรับแสดงลูกศรการเงิน -->
<script src="js/filter.js"></script>