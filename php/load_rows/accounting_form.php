<!-- เริ่มต้นของ Modal ที่มีชื่อว่า "exampleModal" -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- ส่วนของหัวข้อของ Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit financial details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- ฟอร์มส่งข้อมูลด้วยวิธี POST -->
            <form method="post" action="php/update_salary.php">
                <!-- ส่วนของเนื้อหาของ Modal -->
                <div class="modal-body">
                    <!-- ฟิลด์สำหรับแสดงไอดีพนักงาน -->
                    <input type="hidden" class="form-control" id="field_employee_id" name="field_employee_id">
                    <!-- ฟิลด์สำหรับแสดงชื่อพนักงาน -->
                    <div class="mb-3">
                        <label for="field_name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="field_name" name="field_name" disabled>
                        <input type="hidden" class="form-control" id="hidden_name" name="hidden_name">
                    </div>
                    <!-- ฟิลด์สำหรับแสดงเงินเดือน -->
                    <div class="mb-3">
                        <label for="field_salary" class="col-form-label">Salary</label>
                        <input type="text" class="form-control" id="field_salary" name="field_salary">
                    </div>
                    <!-- ฟิลด์สำหรับแสดงภาษี -->
                    <div class="mb-3">
                        <label for="field_tax" class="col-form-label">Tax</label>
                        <input type="text" class="form-control" id="field_tax" name="field_tax" disabled>
                        <input type="hidden" class="form-control" id="hidden_tax" name="hidden_tax">
                    </div>
                    <!-- ฟิลด์สำหรับแก้ข้อมูลกองทุนประกันสังคม -->
                    <div class="mb-3">
                        <label for="field_social_security_fund" class="col-form-label">Social Security Fund</label>
                        <input type="text" class="form-control" id="field_social_security_fund" name="field_social_security_fund">
                    </div>
                    <!-- ฟิลด์สำหรับแก้ข้อมูลกองทุนสำรองเลี้ยงชีพ -->
                    <div class="mb-3">
                        <label for="field_provident_fund" class="col-form-label">Provident Fund</label>
                        <input type="text" class="form-control" id="field_provident_fund" name="field_provident_fund">
                    </div>
                    <!-- ฟิลด์สำหรับแสดงที่อยู่เว็บ -->
                    <input type="hidden" class="form-control" id="path" name="path">
                </div>
                <!-- ส่วนของปุ่มใน Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- สิ้นสุดของ Modal -->
<!-- สคริปต์สำหรับแสดงฟอร์มข้อมูล -->
<script src="js/accounting_form.js"></script>
<!-- สคริปต์สำหรับคำนวณภาษี -->
<script src="js/calculate_tax.js"></script>