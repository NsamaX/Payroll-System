<!-- ตารางแสดงข้อมูล -->
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <?php
        // รันคิวรีและแสดงข้อมูลบนตาราง
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        // แปลง payment_date ให้เป็นวันที่ของ PHP
        $payment_date_format = strtotime($row["payment_date"]);
        // หาวันสุดท้ายของเดือน
        $last_day = date('t', $payment_date_format);
        // หาชื่อเดือนและปี
        $month = date('M', $payment_date_format);
        $year = date('Y', $payment_date_format);
        ?>
        <thead>
            <!-- ส่วนหัวของสลิป -->
            <tr>
                <th colspan="2">
                    <p>Company Information Co.,Ltd</p>
                    <?php echo "<p>Employee ID: ".$row["employee_id"]." Name: ".$row["employee_name"]." Department: ".$row["department_name"]."</p>"; ?>
                </th>
                <th class="text-end">
                    <p>Pay Slip</p>
                    <?php echo "<p>Payroll period: 01-".$last_day." ".$month." ".$year."</p>"; ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- ส่วนรายละเอียดของสลิป -->
            <?php
            function format_money($amount) {
                return number_format($amount);
            }
            $salary = $row["salary"];
            $amount = $salary;
            // คำนวณจำนวนเงินที่จะหักในรายการ Social security fund
            $social_security_fund_amount = $salary * ($row["social_security_fund"] / 100);
            // ตรวจสอบว่าจำนวนเงินไม่ควรเกิน 750
            $social_security_fund_amount = min($social_security_fund_amount, 750);
            // ข้อมูลที่จะแสดงในตาราง
            $table_data = [
                ['title' => 'Earnings', 'value1' => '', 'value2' => 'Total'],
                ['title' => 'Basic salary', 'detail' => 'Salary that employees receive according to their work contracts', 'value1' => '', 'value2' => format_money($amount)],
                ['title' => 'Leave/Late', 'detail' => 'Amount deducted from leave or lateness', 'value1' => $row["deduction"].'%', 'value2' => format_money($amount -= $salary * ($row["deduction"] / 100))],
                ['title' => 'Tax', 'detail' => 'Tax that must be paid from salary', 'value1' => format_money($row["tax"]).'%', 'value2' => 'Not calculated'],
                ['title' => 'Social security fund', 'detail' => 'Amount deducted from social security', 'value1' => $row["social_security_fund"].'%', 'value2' => format_money($amount -= $social_security_fund_amount)],
                ['title' => 'Provident fund', 'detail' => 'Amount deducted into provident fund', 'value1' => $row["provident_fund"].'%', 'value2' => format_money($amount -= $salary * ($row["provident_fund"] / 100))],
                ['title' => 'Overtime', 'detail' => 'Amount from overtime work', 'value1' => format_money($row["overtime"]), 'value2' => format_money($amount += $row["overtime"])],
                ['title' => 'Bonus', 'detail' => 'Bonus money or additional prizes received', 'value1' => format_money($row["bonus"]), 'value2' => format_money($amount += $row["bonus"])],
                ['title' => 'Net pay', 'detail' => 'The net amount received after everything has been deducted.', 'value1' => '', 'value2' => format_money($amount)],
                ['title' => 'Payment date', 'value1' => '', 'value2' => $row["payment_date"]],
                ['title' => 'Transaction by', 'value1' => '', 'value2' => $row["transaction_by"]],
                ['title' => 'Status', 'value1' => '', 'value2' => $row["status"]]
            ];
            // สร้างตารางสลิปเงินเดือน
            foreach ($table_data as $data) {
                echo "<tr>";
                echo "<td scope='row' data-bs-toggle='tooltip' data-bs-placement='bottom' title='{$data['detail']}'>{$data['title']}</td>";
                echo "<td>{$data['value1']}</td>";
                echo "<td>{$data['value2']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>  
    </table>
</div>
<?php 
// สคริปต์สำหรับแสดงปุ่มย้อนกลับและอนุมัติ
include_once 'button.php'; 
?>