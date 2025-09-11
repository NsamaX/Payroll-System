<!-- ประกาศว่าเป็น HTML5 -->
<!DOCTYPE html> 
<!-- ตั้งค่าภาษาเป็นอังกฤษ -->
<html lang="en"> 
    <head>
        <!-- ตั้งค่า Encoding ให้รองรับตัวอักษรแบบ UTF-8 -->
        <meta charset="UTF-8"> 
        <!-- ตั้งค่าหน้าต่างให้ Responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <!-- หัวข้อหน้าเว็บ -->
        <title>Role</title> 
        <!-- ใช้สไตล์ที่สร้างเอง -->
        <link rel="stylesheet" href="css/signin.css">
        <!-- ใช้ไอคอนจาก ionicons -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <!-- ฟอร์มสำหรับเลือกบทบาท -->
        <form method="post">
            <!-- หัวเรื่องของฟอร์ม -->
            <h1>PAYROLL</h1> 
            <!-- พื้นที่ว่าง ทำหน้าที่เป็น Spacer -->
            <p></p>
            <!-- ปุ่มเลือกบทบาทเป็น "ACCOUNTING" -->
            <button type="submit" name="role" value="ACCOUNTING">ACCOUNTING</button>
            <!-- พื้นที่ว่าง ทำหน้าที่เป็น Spacer -->
            <p></p>
            <!-- ปุ่มเลือกบทบาทเป็น "EMPLOYEE" -->
            <button type="submit" name="role" value="EMPLOYEE">EMPLOYEE</button>
        </form>    
    </body>
    <?php
    // เริ่มต้นเซสชั่นใหม่หรือดำเนินการต่อเซสชั่นที่มีอยู่
    session_start();
    // ตรวจสอบว่าข้อมูลที่ถูกส่งมาเป็น POST หรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        // จัดเก็บบทบาท ที่ถูกส่งมาในตัวแปรเซสชั่น "role"
        $_SESSION["role"] = $_POST["role"];  
        // ส่งผู้ใช้ไปยังหน้า signin.php
        header("Location: signin.php");  
        // ยุติการทำงานของสคริปต์เพื่อไม่ให้มีโค้ดอื่นถูกทำงาน
        exit();  
    }
    ?>
</html>