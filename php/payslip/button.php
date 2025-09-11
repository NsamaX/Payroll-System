<form method="post">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <?php 
        // รับค่าตัวกรองเพื่อใช้กรองข้อมูลในหน้าอื่นต่อไป
        $queryStrings = [];
        foreach ($_GET as $key => $value) {
            if ($key !== 'payment_id' && !empty($value)) {
                $queryStrings[] = "$key=$value";
            }
        }
        $filterQueryString = implode('&', $queryStrings);
        $filterQueryString = !empty($filterQueryString) ? "&$filterQueryString" : '';
        if ($role == 'ACCOUNTING') {
            // ถ้าเป็น ACCOUNTING ปุ่ม Back กลับไปยัง payment.php หน้าเดิม
            echo "<button class='btn btn-primary me-ms-2' type='button' onclick=\"window.location.href='payment.php?$filterQueryString';\">Back</button>";
            // ปุ่มอนุมัติการทำสลิปเงินเดือน
            echo "<button id='approveButton' class='btn btn-primary' type='submit' name='approve'>Approve</button>";
            // ตรวจสอบว่ามีการกดปุ่ม 'Approve' หรือไม่
            if (isset($_POST['approve'])) {
                // SQL Query เพื่อ update
                $sql = $conn->prepare(
                    "UPDATE payment_history SET 
                        salary = ?, 
                        overtime = ?, 
                        bonus = ?, 
                        late_leave = ?, 
                        tax = ?, 
                        social_security_fund = ?, 
                        provident_fund = ?, 
                        amount = ?, 
                        payment_date = ?, 
                        transaction_by = ?, 
                        status = ? 
                    WHERE employee_id = ? AND MONTH(payment_date) = DATE_FORMAT(?, '%m') AND YEAR(payment_date) = DATE_FORMAT(?, '%Y')
                ");
                // ตั้งค่าสถานะให้เป็น 'Approved' (หรือ 1)
                $status = 1;
                // ผูกตัวแปร PHP กับ parameter ใน SQL statement
                $sql->bind_param(
                    "ddddddddssiiss", 
                    $row['salary'], 
                    $row['overtime'], 
                    $row['bonus'], 
                    $row['deduction'], 
                    $row['tax'], 
                    $row['social_security_fund'], 
                    $row['provident_fund'], 
                    $amount,
                    $row['payment_date'], 
                    $row['transaction_by'], 
                    $status,
                    $row['employee_id'],
                    $payment_date,
                    $payment_date
                );
                // SQL Query เพื่อ insert
                $stm = $conn->prepare(
                    "INSERT INTO transactions (employee_id, transaction_date, transaction_description) VALUES 
                        (?, CURRENT_DATE(), CONCAT(?, ' approved the salary of ', ?, ' at ', CURRENT_TIME()))
                ");
                // ผูกตัวแปร PHP กับ parameter ใน SQL statement
                $stm->bind_param(
                    "iss", 
                    $id, 
                    $name, 
                    $row["employee_name"]
                );
                // ทำการ execute SQL statement        
                if ($sql->execute() && $stm->execute()) {
                    echo "
                        <script>
                            const lastTbody = document.querySelector('table tbody:last-child');
                            const lastTr = lastTbody.querySelector('tr:last-child');
                            const lastTd = lastTr.querySelector('td:last-child');
                            lastTd.textContent = 'APPROVED';
                        </script>
                    ";
                } else {
                    echo "<script type='text/javascript'>alert('เกิดข้อผิดพลาด: ".$sql->error." หรือ ".$stm->error."');</script>";
                }
            }
        } else {
            // ถ้าเป็น EMPLOYEE ปุ่ม Back กลับไปยัง employee.php
            echo "<button class='btn btn-primary me-ms-2' type='button' onclick=\"window.location.href='employee.php?$filterQueryString';\">Back</button>";
        }
        // ปุ่มดาวน์โหลดสลิปเงินเดือนเป็น PDF
        echo "<button class='btn btn-primary me-ms-2' type='button' onclick=\"downloadPDF()\">Download</button>";
        ?>
    </div>
</form>