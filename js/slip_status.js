// รอให้ DOM โหลดเสร็จสิ้นก่อนที่จะทำการรันโค้ด
document.addEventListener('DOMContentLoaded', function() {
    // หา 'status' ในตารางแถวสุดท้าย
    const statusElement = document.querySelector("tbody tr:last-child td:last-child");
    // หาอิลิเมนต์ที่มี id ชื่อว่า 'approveButton'
    const approveButton = document.getElementById("approveButton");
    // ตรวจสอบว่าข้อความใน 'status' เท่ากับ 'APPROVED' หรือไม่
    if (statusElement.textContent.trim() === "APPROVED") {
        // ถ้าสถานะคือ 'APPROVED' ซ่อนปุ่ม 'Approve'
        approveButton.style.display = "none";
    }
});