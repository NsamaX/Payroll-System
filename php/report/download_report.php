<?php
// รับข้อมูลจากฟอร์ม
$subject = $_POST['subject'];
// ลบหรือแทนที่อักขระพิเศษ
$subject = preg_replace("/[^a-zA-Z0-9_\-]/", "", $subject);
$data = $_POST['reportContent'];
// ดำเนินการแปลงทุกรูปภาพเป็น Base64
$imageData = [];
if (isset($_FILES['file'])){
    for($i=0; $i < count($_FILES['file']['tmp_name']); $i++) {
        if ($_FILES['file']['size'][$i] > 0){
            $imagePath = $_FILES['file']['tmp_name'][$i];
            $type = pathinfo($imagePath, PATHINFO_EXTENSION);
            $dataFile = file_get_contents($imagePath);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($dataFile);
            // บันทึกรูปภาพแบบ Base64 ลงใน array
            $imageData[] = "<img src='{$base64}' />";
        }
    }
}
// แทรกรูปภาพลงไปใน $data
$data .= implode('', $imageData);
// กำหนด header เพื่อบอกว่าเป็นไฟล์ Word
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$subject.doc");
// แสดงโค้ด HTML ของรายงาน
echo <<<EOD
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
</head>
<body>
    $data
</body>
</html>
EOD;
?>