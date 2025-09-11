async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    // สร้างออบเจค jsPDF ในขนาด A4
    let doc = new jsPDF('p', 'mm', 'a4');
    // ค้นหาตารางที่มี class เป็น 'table' จากหน้าเว็บ
    const pdfTable = document.querySelector('.table');
    // ใช้ html2canvas แปลงหน้าเว็บเป็นรูปภาพ
    const canvas = await html2canvas(pdfTable);
    // แปลง canvas เป็นข้อมูลรูปภาพแบบ Base64
    const imgData = canvas.toDataURL('image/jpeg', 1.0);
    // กำหนดขนาด A4 ในหน่วยมิลลิเมตร
    const pdfWidth = 210;  
    const pdfHeight = 297; 
    // คำนวณระยะขอบด้านข้าง 5% ของขนาด A4
    const marginX = pdfWidth * 0.05;  
    // คำนวณระยะขอบด้านบนและล่าง 5% ของขนาด A4
    const marginY = pdfHeight * 0.05; 
    // คำนวณขนาดความกว้างและความสูงของเนื้อหา
    const contentWidth = pdfWidth - (2 * marginX);
    const contentHeight = (pdfTable.offsetHeight * contentWidth) / pdfTable.offsetWidth;
    // เพิ่มรูปภาพลงในไฟล์ PDF
    doc.addImage(imgData, 'JPEG', marginX, marginY, contentWidth, contentHeight);
    // รับวันที่ปัจจุบัน
    const currentDate = new Date();
    const formattedDate = `${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${currentDate.getDate()}`;
    // ตั้งชื่อไฟล์ให้เป็น 'salary-วันที่ดาวน์โหลด'
    const fileName = `salary-${formattedDate}.pdf`;
    // บันทึกไฟล์ด้วยชื่อที่กำหนด
    doc.save(fileName);  
}