<?php
// ดำเนินการต่อเซสชั่นที่มีอยู่
session_start();
// ทำลายทุก session variable
session_unset();
// ทำลาย session
session_destroy();
// พาไปหน้าหลักหรือหน้า login
header("Location: role.php");
?>