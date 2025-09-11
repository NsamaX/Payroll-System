function updateFilter() {
    // รับค่าจาก dropdown ของ year, month และ department
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;
    const department = document.getElementById('department').value;
    // สร้าง array ว่างเพื่อเก็บค่าฟิลเตอร์
    let query = [];
    // ถ้า year มีค่า, เพิ่มเข้าไปใน query array
    if (year) {
        query.push(`year=${year}`);
    }
    // ถ้า month มีค่า, เพิ่มเข้าไปใน query array
    if (month) {
        query.push(`month=${month}`);
    }
    // ถ้า department มีค่า, เพิ่มเข้าไปใน query array
    if (department) {
        query.push(`department=${department}`);
    }
    // สร้าง query string จาก query array
    const queryString = query.length ? '?' + query.join('&') : '';
    // นำ query string ไปใช้ใน URL
    location = `<?php echo $page; ?>${queryString}`;
}