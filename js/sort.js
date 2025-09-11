// รอให้ DOM โหลดเสร็จสิ้นก่อนที่จะทำการรันโค้ด
document.addEventListener('DOMContentLoaded', function () {
    // ดึงอิลิเมนต์ของตาราง และปุ่มที่ใช้ในการเรียงลำดับ
    const table = document.querySelector('.table');
    const sortButtons = document.querySelectorAll('.sort-btn');
    // วนลูปผ่านปุ่มทุกปุ่มเพื่อเพิ่ม Event Listener
    sortButtons.forEach(button => {
        // เมื่อปุ่มถูกคลิก
        button.addEventListener('click', () => {
            const column = button.dataset.column; // ดึงข้อมูลคอลัมน์ที่จะเรียง
            let order = button.dataset.order; // ดึงข้อมูลเรียงลำดับปัจจุบัน (asc หรือ desc)
            // รีเซ็ตไอคอนของปุ่มทั้งหมดเป็นค่าเริ่มต้น
            sortButtons.forEach(btn => {
                if (btn !== button) {
                    btn.innerHTML = '<i class="bi bi-filter"></i>';
                }
            });
            // อัพเดทไอคอนบนปุ่มที่ถูกคลิก
            if (order === 'desc') {
                button.innerHTML = '<i class="bi bi-sort-down-alt"></i>';
            } else {
                button.innerHTML = '<i class="bi bi-sort-up"></i>';
            }
            // แปลง NodeList ของแถวในตารางเป็นอาร์เรย์เพื่อเรียงลำดับ
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            // เรียงลำดับแถวตามคอลัมน์และลำดับที่ระบุ
            rows.sort((a, b) => {
                const aValue = a.children[column].textContent;
                const bValue = b.children[column].textContent;
                // ตรวจสอบว่าค่าเป็นตัวเลขหรือไม่
                const aIsNumber = !isNaN(aValue);
                const bIsNumber = !isNaN(bValue);
                // ถ้าค่าทั้งสองเป็นตัวเลข
                if (aIsNumber && bIsNumber) {
                    // เรียงลำดับข้อมูลตัวเลข ตามลำดับที่กำหนด (asc หรือ desc)
                    return (order === 'desc' ? 1 : -1) * (parseFloat(aValue) - parseFloat(bValue));
                } 
                // ถ้าค่าทั้งสองไม่เป็นตัวเลข
                else if (!aIsNumber && !bIsNumber) {
                    // เรียงลำดับข้อมูลแบบข้อความ ตามลำดับที่กำหนด (asc หรือ desc)
                    return (order === 'desc' ? 1 : -1) * aValue.localeCompare(bValue);
                } 
                // ถ้าค่าหนึ่งเป็นตัวเลข แต่อีกค่าหนึ่งไม่เป็น
                else {
                    // ให้ค่าที่เป็นตัวเลขอยู่ด้านบน และค่าที่ไม่เป็นตัวเลขอยู่ด้านล่าง
                    return aIsNumber ? -1 : 1;
                }
            });
            // ลบเนื้อหาใน tbody
            table.querySelector('tbody').innerHTML = '';
            // เพิ่มแถวที่เรียงลำดับแล้วกลับไปในตาราง
            rows.forEach(row => {
                table.querySelector('tbody').appendChild(row);
            });
            // สลับลำดับการเรียง (จาก desc เป็น asc หรือจาก asc เป็น desc)
            button.dataset.order = (order === 'desc' ? 'asc' : 'desc');
        });
    });
});