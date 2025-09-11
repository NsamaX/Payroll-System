// รอให้ DOM โหลดเสร็จสิ้นก่อนที่จะทำการรันโค้ด
document.addEventListener('DOMContentLoaded', function() {
    // สร้างอาร์เรย์เพื่อเก็บ labels และ data สำหรับแผนภูมิ
    const Labels = [];
    const Data = [];
    // รับทุกแถวใน tbody ของตาราง
    const rows = document.querySelectorAll('tbody tr');
    // วนลูปผ่านทุกแถว
    rows.forEach(function(row, index) {
        // รับ label และข้อมูล (ข้อมูลเงินเดือน) จากแถว
        const label = row.querySelector('td:first-child').textContent;
        const info = parseFloat(row.querySelector('td:last-child').textContent.replace(/[^0-9.]/g, ''));
        // นำ label และ info ไปใส่ในอาร์เรย์
        Labels.push(label);
        Data.push(info);
    });
    // สร้างสีสุ่มสำหรับแผนภูมิ
    const colors = getRandomColors(Data.length);
    // สร้างและตั้งค่าแผนภูมิแบบ pie
    const statusChartCtx = document.getElementById('salaryPieChart').getContext('2d');
    new Chart(statusChartCtx, {
        type: 'pie',  // กำหนดประเภทของแผนภูมิเป็น 'pie'
        data: {
            labels: Labels,  // กำหนด label สำหรับ dataset ในแผนภูมิ
            datasets: [{
                data: Data,  // ใช้ข้อมูลที่ได้รับมาจากอาร์เรย์ของตาราง
                backgroundColor: colors,  // ใช้สีที่สร้างขึ้นโดยสุ่ม
            }]
        },
    });
    // สร้างและตั้งค่าแผนภูมิแบบ bar
    const salaryChartCtx = document.getElementById('salaryBarChart').getContext('2d');
    new Chart(salaryChartCtx, {
        type: 'bar',  // กำหนดประเภทของแผนภูมิเป็น 'bar'
        data: {
            labels: Labels,  // ใช้ Labels ที่ได้รับมาจากอาร์เรย์ของตาราง
            datasets: [{
                label: "Total Cost",  // กำหนด label สำหรับ dataset
                data: Data,  // ใช้ข้อมูลที่ได้รับมาจากอาร์เรย์ของตาราง
                backgroundColor: colors,  // ใช้สีที่สร้างขึ้นโดยสุ่ม
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,  // กำหนดให้แกน Y เริ่มต้นที่ 0
                }
            },
            plugins: {
                legend: {
                    display: false,  // ซ่อน legend หรือคำอธิบายสัญลักษณ์
                }
            }
        }
    });    
});
// ฟังก์ชันสร้างสีสุ่ม
function getRandomColors(numColors) {
    const colors = [];
    for (let i = 0; i < numColors; i++) {
        const randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
        colors.push(randomColor);
    }
    return colors;
}