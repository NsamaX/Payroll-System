<!-- หัวข้อ "โหลดไฟล์" -->
<h2 class="mb-4">Export data to .csv</h2>
<!-- ฟอร์มสำหรับเลือกข้อมูลและช่วงเวลาที่ต้องการส่งออก -->
<form action="php/download_data.php" method="POST">
    <!-- ดรอปดาวน์เมนูสำหรับเลือกประเภทข้อมูล -->
    <div class="mb-3">
        <label for="dataSelection" class="form-label">Select the data to load</label>
        <select class="form-control" id="dataSelection" name="dataSelection">
            <option value="financial-details">financial details</option>
            <option value="working-hours">working hours</option>
            <option value="payment-history">payment history</option>
        </select>
    </div>
    <!-- ดรอปดาวน์เมนูสำหรับเลือกปีและเดือน -->
    <div class="mb-3">
        <label for="year" class="form-label">Select time period</label>
        <select class="form-control" id="year" name="year">
            <option value="year">please select a year</option>
            <?php
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
            ?>
        </select>
        <p></p>
        <!-- ดรอปดาวน์เมนูสำหรับเดือน (เริ่มต้นแบบซ่อนและไม่ใช้งาน) -->
        <select class='form-control' id='month' name='month' style="display: none;" disabled></select>
    </div>
    <!-- ปุ่มส่งออกเพื่อเริ่มการดาวน์โหลด -->
    <div class="d-grid gap-2 d-md-flex justify-content">
        <button type="submit" class="btn btn-primary" id="exportButton" disabled>Export</button>
        <button class="btn btn-primary" style="display: none;" disabled></button>
    </div>
</form>
<?php include_once 'php/select_year.php'; ?>