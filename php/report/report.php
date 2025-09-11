<!-- หัวข้อ "รายงาน" -->
<h2 class="mb-4">Report</h2>
<!-- ฟอร์มสำหรับการส่งรายงาน -->
<form action="php/report/download_report.php" method="post" enctype="multipart/form-data">
    <!-- กรอกเรื่องรายงาน -->
    <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" required>
    </div>
    <!-- เลือกผู้รับรายงาน -->
    <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <select class="form-control" id="department" name="department">
            <option value="not_specified">Not specified</option>
            <?php
            // ดึงข้อมูลแผนกทั้งหมด
            $departments = [];
            $sql = $conn->prepare(
                "SELECT department_name FROM departments
            ");
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $departments[] = $row["department_name"];
                    echo "<option value='".$row["department_name"]."'>".$row["department_name"]."</option>";
                }
                // ดึงข้อมูลหนักงานทั้งหมดที่มีในแต่ละแผนก
                $namesInDb = [];
                foreach ($departments as $name) {
                    $sql = $conn->prepare(
                        "SELECT CONCAT(first_name, ' ', last_name) AS name
                        FROM employees e
                        JOIN departments d ON e.department_id = d.department_id
                        WHERE department_name = ?
                        ORDER BY name ASC
                    ");
                    $sql->bind_param('s', $name);
                    $sql->execute();
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $namesInDb[$name][] = $row['name'];
                    }
                }
            } else {
                echo "<option>No Data</option>";
            }
            ?>
        </select>
        <p></p>
        <!-- ดรอปดาวน์เมนูสำหรับชื่อผู้รับ(เริ่มต้นแบบซ่อนและไม่ใช้งาน) -->
        <label for="receiverName" class="form-label" id="receiver" style="display: none;">Receiver</label>
        <select class="form-control" id="receiverName" name="receiverName" style="display: none;"></select>
        <p></p>
    </div>
    <!-- กรอกรายละเอียด -->
    <div class="mb-3">
        <label for="details" class="form-label">Details</label>
        <textarea class="form-control" id="details" rows="20" name="details" required></textarea>
    </div>
    <!-- อัพโหลดไฟล์ที่เกี่ยวข้อง -->
    <div class="mb-3">
        <label for="file" class="form-label">Upload Files</label>
        <input type="file" class="form-control" id="file" name="file[]" accept="image/png, image/jpeg" multiple>
        <div id="imagePreview"></div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content">
        <!-- ปุ่มแสดงรายงาน -->
        <button type="submit" class="btn btn-primary" id="createButton" disabled>Create</button>
        <!-- ปุ่มส่งรายงาน -->
        <button type="submit" class="btn btn-primary" id="downloadButton" disabled>Download</button>
    </div>
    <input type="hidden" id="reportContent" name="reportContent">
</form>
<div id="reportPreview"></div>
<script>
    // สคริปต์สำหรับจัดการการแสดงดรอปดาวน์เมนูชื่อพนักงานตามแผนกที่เลือก
    document.getElementById('department').addEventListener('change', function() {
        var receiverLabel = document.getElementById('receiver');
        var receiverDropdown = document.getElementById('receiverName');
        var selectedDepartment = this.value;
        // ล้างรายการที่มีอยู่
        receiverDropdown.innerHTML = ""; 
        // หากเลือกแผนกที่ไม่ใช่ 'กรุณาเลือกแผนก' จะแสดงดรอปดาวน์เมนูของชื่อผู้รับ
        if (selectedDepartment != "not_specified") {
            receiverLabel.removeAttribute('disabled');
            receiverLabel.style.display = 'block';
            receiverDropdown.removeAttribute('disabled');
            receiverDropdown.style.display = 'block';
        } else {
            receiverLabel.setAttribute('disabled', 'disabled');
            receiverLabel.style.display = 'none';
            receiverDropdown.setAttribute('disabled', 'disabled');
            receiverDropdown.style.display = 'none';
        }
        // เพิ่มชื่อพนักงานที่มีในแผนกที่เลือก
        <?php foreach ($namesInDb as $department => $employeesAvailable) { ?>
            if (selectedDepartment == '<?php echo $department; ?>') {
                <?php foreach ($employeesAvailable as $employeeName) { ?>
                    var option = document.createElement('option');
                    option.value = '<?php echo $employeeName; ?>';
                    option.textContent = '<?php echo $employeeName; ?>';
                    receiverDropdown.appendChild(option);
                <?php } ?>
            }
        <?php } ?>
    });
    // สคริปต์สำหรับตรวจสอบสกุลไฟล์ของรูปภาพ
    document.getElementById('file').addEventListener('change', function() {
        // รับอ้างอิงของ input file และ div สำหรับแสดงตัวอย่างรูป
        var fileInput = this;
        var previewDiv = document.getElementById('imagePreview');
        // รับค่า path ของไฟล์ที่ผู้ใช้อัพโหลด
        var files = fileInput.files;
        // กำหนดสกุลไฟล์ที่อนุญาตให้อัพโหลด
        var allowedExtensions = /(\.jpeg|\.jpg|\.png)$/i;
        // ล้าง div ตัวอย่างรูปที่แสดงอยู่
        previewDiv.innerHTML = ""; 
        for (var i = 0; i < files.length; i++) {
            if (!allowedExtensions.exec(files[i].name)) {
                // แจ้งเตือนถ้าไฟล์ไม่ใช่รูปภาพ
                alert('Pray, upload files of the type .jpeg, .jpg, or .png only, if you would. 📜.');
                // ล้างค่าของ input file
                fileInput.value = '';
                return false;
            } else {
                // แสดงตัวอย่างรูปที่อัปโหลด
                var reader = new FileReader();
                reader.onload = function (event) {
                    var img = document.createElement("img");
                    img.src = event.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.margin = '10px';
                    previewDiv.appendChild(img);
                }
                reader.readAsDataURL(files[i]);
            }
        }
    });
    // สคริปต์สำหรับตรวจสอบการกรอกฟอร์ม
    document.addEventListener('DOMContentLoaded', function() {
        function checkForm() {
            // รับค่าจากฟิลด์ Subject, Details
            var subject = document.getElementById('subject').value;
            var details = document.getElementById('details').value;
            // หาปุ่ม Show และ Download ในฟอร์ม
            var createButton = document.getElementById('createButton');
            var downloadButton = document.getElementById('downloadButton');
            // ตรวจสอบว่าทุกฟิลด์ถูกกรอกแล้วหรือยัง
            if (subject && details) {
                // แสดงปุ่ม Show
                createButton.removeAttribute('disabled');  
            } else {
                // ซ่อนปุ่ม Show และ Download
                createButton.setAttribute('disabled', 'disabled'); 
                downloadButton.setAttribute('disabled', 'disabled'); 
            }
        }
        // เพิ่มตัวตรวจสอบการเปลี่ยนแปลงข้อมูลในฟอร์ม
        document.getElementById('subject').addEventListener('input', checkForm);
        document.getElementById('details').addEventListener('input', checkForm);
        // ตรวจสอบฟอร์มเมื่อโหลดหน้าเว็บ
        checkForm();
    });
    // สคริปต์สำหรับสร้างและแสดงตัวอย่างรายงาน
    document.getElementById('createButton').addEventListener('click', function(e) {
        // หยุดการทำงานปกติของปุ่ม
        e.preventDefault(); 
        // รับค่าจากฟอร์ม
        var subject = document.getElementById('subject').value;
        var department = document.getElementById('department').value;
        // ถ้าแผนกไม่ใช่ "not_specified" แสดงชื่อผู้รับ
        var receiverSection = "";
        if (department !== "not_specified") {
            var receiverName = document.getElementById('receiverName').value;
            receiverSection = `<p><strong>Receiver:</strong> ${receiverName}</p>`;
        }
        var details = document.getElementById('details').value;
        // แปลงข้อความจาก <textarea> ให้มีป้าย <p> สำหรับแต่ละบรรทัด
        var detailsInParagraphs = details.split('\n').map(line => `<p>${line}</p>`).join('');
        // แสดงรูปภาพที่ถูกอัปโหลด
        var imagesUploaded = document.getElementById('imagePreview').cloneNode(true);
        imagesUploaded.style.marginTop = '10px';
        // สร้างและแสดงตัวอย่างรายงาน
        var reportPreview = `
            <br>
            <p><strong>Subject:</strong> ${subject}</p>
            ${receiverSection}
            <p><strong>Details:</strong></p>
            ${detailsInParagraphs}
            ${imagesUploaded.outerHTML}
        `;
        document.getElementById('reportPreview').innerHTML = reportPreview;
        // อัปเดตค่าของฟิลด์ซ่อนด้วยข้อมูลใน reportPreview
        document.getElementById('reportContent').value = reportPreview;
    });
    // สคริปต์สำหรับตรวจสอบการกดปุ่ม create
    createButton.addEventListener("click", () => {
        // เปิดใช้งานปุ่มดาวน์โหลด
        downloadButton.disabled = false;
    });
</script>