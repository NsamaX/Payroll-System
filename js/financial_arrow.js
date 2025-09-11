// รอให้ DOM โหลดเสร็จสิ้นก่อนที่จะทำการรันโค้ด
document.addEventListener('DOMContentLoaded', function() {
    // รับทุกแถวในตาราง employee ที่อยู่ใน tbody
    var rows = document.querySelectorAll('#employeeTableBody tr');
    // วนลูปในทุกแถว
    rows.forEach(function(row) {
        // รับ element ที่เก็บข้อมูลของ total salary และ regular salary
        var overtimePayElement = row.querySelector('td:nth-child(6)');
        var deductionElement = row.querySelector('td:nth-child(7)');
        // แปลงค่าของ salary จาก string เป็น float และลบ comma ออกเพื่อใช้ในการเปรียบเทียบ
        var overtimePay = parseFloat(overtimePayElement.textContent.replace(',', ''));
        var deduction = parseFloat(deductionElement.textContent.replace('%', ''));
        // เปรียบเทียบ total salary กับ regular salary
        if (overtimePay > 0) {
            // ถ้า total salary มากกว่า regular salary ให้แสดงไอคอนขึ้นและเปลี่ยนสีเป็นสีเขียว
            overtimePayElement.innerHTML = '<i class="bi bi-caret-up-fill" style="color: green;"></i>' + overtimePayElement.textContent;
        } 
        if (deduction > 0) {
            // ถ้า total salary น้อยกว่า regular salary ให้แสดงไอคอนลงและเปลี่ยนสีเป็นสีแดง
            deductionElement.innerHTML = '<i class="bi bi-caret-down-fill" style="color: red;"></i>' + deductionElement.textContent;
        } 
        if (overtimePay == 0) {
            // ถ้า overtimePay เท่ากับ 0 ให้แสดงไอคอนที่ไม่ขึ้นหรือลงและเปลี่ยนสีเป็นสีน้ำเงิน
            overtimePayElement.innerHTML = '<i class="bi bi-caret-right-fill" style="color: blue;"></i>' + overtimePayElement.textContent;
        }
        if (deduction == 0) {
            // ถ้า deduction เท่ากับ 0 ให้แสดงไอคอนที่ไม่ขึ้นหรือลงและเปลี่ยนสีเป็นสีน้ำเงิน
            deductionElement.innerHTML = '<i class="bi bi-caret-right-fill" style="color: blue;"></i>' + deductionElement.textContent;
        }
    });
});