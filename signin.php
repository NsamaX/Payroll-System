<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- หัวข้อหน้าเว็บ -->
        <title>Sign in</title>
        <!-- ใช้สไตล์ที่สร้างเอง -->
        <link rel="stylesheet" href="css/signin.css">
        <!-- ใช้ไอคอนจาก ionicons -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <!-- ฟอร์มสำหรับการลงชื่อเข้าใช้ -->
        <form method="post">  
            <!-- ไอคอนแทนคน -->
            <h1><ion-icon name="people-outline" style="font-size: 60px"></ion-icon></h1>
            <!-- หัวเรื่อง "PAYROLL" -->
            <h1>PAYROLL</h1>
            <!-- ตัวป้อนข้อมูล username -->
            <div class="input-container">
                <!-- ไอคอนแทนบุคคล -->
                <ion-icon name="person-circle-outline"></ion-icon>
                <!-- ช่องป้อนข้อมูล username -->
                <input type="text" name="username" required placeholder="USERNAME">
            </div>
            <!-- ตัวป้อนข้อมูล password -->
            <div class="input-container">
                <!-- ไอคอนแทนล็อค -->
                <ion-icon name="lock-closed-outline"></ion-icon>
                <!-- ช่องป้อนข้อมูล password -->
                <input type="password" name="password" required placeholder="PASSWORD">
            </div>
            <!-- ตัวเลือก "ลืมรหัสผ่าน?" -->
            <div class="forgot">
                <input type="checkbox" name="forgot_password">
                <label for="forgot_password">Forgot password?</label>
            </div>
            <!-- ปุ่ม "ลงชื่อเข้าใช้" -->
            <button type="submit">Sign in</button>
        </form>
    </body>
</html>
<?php
// เริ่มการเชื่อมต่อฐานข้อมูล
require_once 'php/connect.php';
// ตรวจสอบว่าข้อมูลถูกส่งมาทาง POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับ username และ password จากฟอร์ม
    $username = $_POST["username"];
    $password = $_POST["password"];
    // SQL Query เพื่อค้นหาข้อมูลผู้ใช้ในฐานข้อมูล
    $sql = $conn->prepare(
        "SELECT * 
        FROM users 
        WHERE username = ? AND password = ?
    ");
    // ซ่อน username และ password ของผู้ใช้ที่ค้นหา
    $sql->bind_param("ss", $username, $password);
    $sql->execute();
    $result = $sql->get_result();
    // ถ้าพบข้อมูลผู้ใช้ที่ตรงกับเงื่อนไข
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // SQL Query เพื่อskข้อมูลเพิ่มเติมของพนักงาน
        $sql = $conn->prepare(
            "SELECT * FROM employees e 
            JOIN users u ON e.employee_id = u.user_id 
            JOIN departments d ON e.department_id = d.department_id 
            WHERE e.employee_id = ?"
        );
        // ซ่อนรหัสผู้ใช้ของผู้ใช้ที่พบ
        $sql->bind_param("i", $row["user_id"]);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        // เริ่ม session และจัดเก็บข้อมูลที่ต้องใช้ในส่วนต่อไป
        session_start();
        $_SESSION["employee_id"] = $row["user_id"];
        $_SESSION["name"] = $row["first_name"]." ".$row["last_name"];
        // นำทางขึ้นอยู่กับบทบาทและแผนก
        if ($_SESSION["role"] == "ACCOUNTING" && $row["department_id"] == 1) {
            header("Location: payroll.php");
            exit();
        } else if ($_SESSION["role"] == "EMPLOYEE") {
            header("Location: employee.php");
            exit();
        }
    }
    // สิ้นสุดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    // หากไม่สำเร็จในการล็อกอิน นำทางกลับไปยังหน้าล็อกอิน
    header("Location: signin.php");
}
?>