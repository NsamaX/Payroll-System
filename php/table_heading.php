<?php
echo "<thead>";
// เครื่องมือสำหรับค้นหาและคัดกรองข้อมูล
include_once 'php/searchbar&filter.php';
// วนลูปผ่านอาเรย์ headings ที่ถูกตั้ง
for ($i = 0; $i < count($headings); $i++) {
    // แสดงหัวตารางด้วยค่าปัจจุบันของ heading
    echo '<th scope="col">' . $headings[$i] . '
              <button class="sort-btn" data-column="' . $i . '" data-order="asc">
                  <i class="bi bi-filter"></i>
              </button>
          </th>';
}
echo "</thead>";
?>
<!-- สคริปต์สำหรับเรียงลำดับข้อมูล -->
<script src="js/sort.js"></script>