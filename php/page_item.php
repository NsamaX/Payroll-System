<?php
// รันคิวรีเพื่อหาจำนวณแถวทั้งหมด
$stm->execute();
$stm_result = $stm->get_result();
$numrows = $stm_result->num_rows;
// คำนวณจำนวนหน้าที่ต้องการสำหรับการแบ่งหน้า
if ($numrows - ($current_page * $rowsPerPage) > 0 || $offset > 0):
    $numPages = ceil($numrows / $rowsPerPage);
?>
<tfoot id="paginationSection">
    <tr>
        <td scope="row" colspan="<?php echo count($headings); ?>">
            <nav aria-label="Page navigation example" class="d-flex justify-content-end mt-3">
                <ul class="pagination">
                    <?php
                    // ระบุหน้าปัจจุบัน
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    // การคำนวณจะต่างกันขึ้นอยู่กับจำนวนหน้าทั้งหมดและหน้าปัจจุบัน
                    if ($numPages <= 10) {
                        $startPage = 1;
                        $endPage = $numPages;
                    } else {
                        if ($currentPage <= 5) {
                            $startPage = 1;
                            $endPage = 10;
                        } else if ($currentPage + 5 > $numPages) {
                            $startPage = $numPages - 9;
                            $endPage = $numPages;
                        } else {
                            $startPage = $currentPage - 4;
                            $endPage = $currentPage + 5;
                        }
                    }
                    // รับค่าตัวกรองเพื่อใช้กรองข้อมูลในหน้าอื่นต่อไป
                    $queryStrings = [];
                    foreach ($_GET as $key => $value) {
                        if ($key !== 'page' && !empty($value)) {
                            $queryStrings[] = "$key=$value";
                        }
                    }
                    $filterQueryString = implode('&', $queryStrings);
                    $filterQueryString = !empty($filterQueryString) ? "&$filterQueryString" : '';
                    // ลิงก์หน้าก่อนหน้า
                    $prevPage = max($currentPage - 1, 1);
                    echo "<li class='page-item'><a class='page-link' href='?page=$prevPage$filterQueryString' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                    // ลิงก์สำหรับแต่ละหน้า
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $activeClass = ($i == $currentPage) ? 'active' : '';
                        echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i$filterQueryString'>$i</a></li>";
                    }                    
                    // ลิงก์หน้าถัดไป
                    $nextPage = min($currentPage + 1, $numPages);
                    echo "<li class='page-item'><a class='page-link' href='?page=$nextPage$filterQueryString' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
                    ?>
                </ul>
            </nav>
        </td>
    </tr>
</tfoot>    
<?php endif ?>