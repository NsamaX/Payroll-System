// ฟังก์ชันนี้จะถูกเรียกเมื่อหน้าเว็บไซต์โหลดเสร็จ
$(document).ready(function() {
    // ฟังก์ชันคำนวณภาษี
    function calculateTax(salary) {
        var annualSalary = salary * 12;
        if (annualSalary <= 150_000) {
            return 0.00;
        } else if (annualSalary <= 300_000) {
            return 5.00;
        } else if (annualSalary <= 500_000) {
            return 10.00;
        } else if (annualSalary <= 750_000) {
            return 15.00;
        } else if (annualSalary <= 1_000_000) {
            return 20.00;
        } else if (annualSalary <= 2_000_000) {
            return 25.00;
        } else if (annualSalary <= 5_000_000) {
            return 30.00;
        } else {
            return 35.00;
        }
    }
    // จับเหตุการณ์เมื่อมีการเปลี่ยนแปลงข้อมูลในฟิลด์ 'salary'
    $('#field_salary').on('input', function() {
        // ลบ comma และ non-numeric characters ออกจาก salary
        let cleanSalary = $(this).val().replace(/[^0-9.]/g, '');
        // แปลงข้อความเป็นตัวเลขแบบทศนิยม
        let salary = parseFloat(cleanSalary); 
        // ถ้าไม่ได้ใส่ข้อมูลหรือข้อมูลไม่ถูกต้อง ให้ใช้ 0
        if (isNaN(salary)) {
            salary = 0; 
        }
        // คำนวณภาษีจากเงินเดือน
        let tax = calculateTax(salary); 
        // แสดงผลลัพธ์ในฟิลด์ 'tax' ที่เป็น input
        $('#field_tax').val(tax);
        // ตั้งค่าในฟิลด์ 'tax' ที่เป็น hidden
        $('#hidden_tax').val(tax);
    });
});