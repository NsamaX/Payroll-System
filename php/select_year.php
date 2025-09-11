<script>
    // สคริปต์สำหรับจัดการการแสดงผลปุ่มดาวน์โหลดและดรอปดาวน์เมนูเดือนตามปีที่เลือก
    document.getElementById('year').addEventListener('change', function() {
        var monthDropdown = document.getElementById('month');
        var selectedYear = this.value;
        // ลบเดือนที่มีอยู่ในดรอปดาวน์เมนูเดือน
        monthDropdown.innerHTML = "";
        // หากเลือกปีที่ไม่ใช่ 'กรุณาเลือกปี' จะแสดงปุ่มดาวน์โหลดและดรอปดาวน์เมนูเดือน
        if (selectedYear != "year") {
            monthDropdown.removeAttribute('disabled');
            monthDropdown.style.display = 'block';
            // สร้างรายการ "all month"
            var allMonthOption = document.createElement('option');
            allMonthOption.value = '';
            allMonthOption.textContent = 'All Month';
            monthDropdown.appendChild(allMonthOption);
        } else {
            monthDropdown.setAttribute('disabled', 'disabled');
            monthDropdown.style.display = 'none';
        }
        // เพิ่มเดือนที่มีในปีที่เลือก
        <?php foreach ($monthsInDb as $year => $monthsAvailable) { ?>
            if (selectedYear == '<?php echo $year; ?>') {
                <?php foreach ($monthsAvailable as $monthNumber) { ?>
                    var monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',  'October', 'November',  'December'][<?php echo $monthNumber - 1; ?>];
                    var option = document.createElement('option');
                    option.value = monthName;
                    option.textContent = monthName;
                    monthDropdown.appendChild(option);
                <?php } ?>
            }
        <?php } ?>
    });
    // สคริปต์สำหรับตรวจสอบการกรอกฟอร์ม
    document.addEventListener('DOMContentLoaded', function() {
        function checkForm() {
            // รับค่าจากฟิลด์ Year
            var year = document.getElementById('year').value;
            // หาปุ่ม Download ในฟอร์ม
            var exportButton = document.getElementById('exportButton');
            // ตรวจสอบว่าฟิลด์ถูกกรอกแล้วหรือยัง
            if (year !== 'year') {
                // แสดงปุ่ม Download
                exportButton.removeAttribute('disabled'); 
            } else {
                // ซ่อนปุ่ม Download
                exportButton.setAttribute('disabled', 'disabled'); 
            }
        }
        // เพิ่มตัวตรวจสอบการเปลี่ยนแปลงข้อมูลในฟอร์ม
        document.getElementById('year').addEventListener('change', checkForm);
        // ตรวจสอบฟอร์มเมื่อโหลดหน้าเว็บ
        checkForm();
    });
</script>