// ฟังก์ชันนี้จะถูกเรียกเมื่อหน้าเว็บไซต์โหลดเสร็จ
$(document).ready(function() {
    // ฟังก์ชันที่ใช้ค้นหาข้อมูลในตาราง
    function searchTable(term) {
        // วนลูปทุกแถวในตาราง
        $("#employeeTableBody tr").each(function() {
            // รับข้อมูลทั้งหมดในแถวแล้วแปลงเป็นตัวเล็ก
            var rowText = $(this).text().toLowerCase();
            // ถ้าคำค้นหาปรากฏในแถว แสดงแถวนั้น
            if (rowText.indexOf(term) > -1) {
                $(this).show();
            } 
            // ปิดแถวที่ไม่มีคำค้นหา
            else { 
                $(this).hide();
            }
        });
    }
    // ฟังก์ชันที่ใช้ค้นหาข้อมูลในตาราง
    $("input[type='search']").on("keyup", function() {
        // รับคำค้นหาจากผู้ใช้
        var searchTerm = $(this).val().toLowerCase();
        // ค้นหาตารางด้วยคำค้นหา
        searchTable(searchTerm);
    });
});