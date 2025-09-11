// ฟังก์ชันนี้จะถูกเรียกเมื่อหน้าเว็บไซต์โหลดเสร็จ
$(document).ready(function () {
    // เมื่อปุ่มที่มีคลาส .open-modal ถูกคลิก
    $(".open-modal").click(function () {
        // รับข้อมูลเพื่อใส่ในฟอร์ม
        var employee_id = $(this).data('employee_id');
        var name = $(this).data('name');
        var salary = $(this).data('salary');
        var tax = $(this).data('tax');
        var social_security_fund = $(this).data('social_security_fund');
        var provident_fund = $(this).data('provident_fund');
        // กำหนดค่าให้กับฟิลด์ของฟอร์มใน modal
        $("#field_employee_id").val(employee_id);
        $("#field_name").val(name);
        $("#hidden_name").val(name); 
        $("#field_salary").val(salary); 
        $("#field_tax").val(tax); 
        $("#hidden_tax").val(tax); 
        $("#field_social_security_fund").val(social_security_fund);
        $("#field_provident_fund").val(provident_fund);
        document.getElementById("path").value = window.location.href;
        // แสดง modal ในชื่อ "exampleModal"
        $("#exampleModal").modal('show');
    });
});