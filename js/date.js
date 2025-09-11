// รอให้ DOM โหลดเสร็จสิ้นก่อนที่จะทำการรันโค้ด
document.addEventListener('DOMContentLoaded', function() {
    // อาร์เรย์ที่เก็บชื่อของวันในสัปดาห์
    const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    // รับวันที่ปัจจุบัน
    const currentDate = new Date();
    // รับชื่อวันของสัปดาห์ (0 - วันอาทิตย์, 1 - วันจันทร์, ..., 6 - วันเสาร์)
    const dayOfWeek = daysOfWeek[currentDate.getDay()];
    // จัดรูปแบบวันที่เป็น 'Day Month/Day/Year'
    const formattedDate = `${dayOfWeek} ${String(currentDate.getMonth() + 1).padStart(2, '0')}/${String(currentDate.getDate()).padStart(2, '0')}/${currentDate.getFullYear()}`;
    // ค้นหาอิลิเมนต์ที่มีคลาส 'date'
    const dateElement = document.querySelector('.date');
    // กำหนดข้อความในอิลิเมนต์ให้แสดงวันที่ที่จัดรูปแบบแล้ว
    dateElement.textContent = formattedDate;
});