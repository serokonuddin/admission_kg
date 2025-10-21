<div class="row">

    <div class="col">
        <label for="inputEmail4">Name Of The Staff<span style="color: red">*</span></label>
        <input type="text" class="form-control" id="name_of_staff" name="name_of_staff" required=""
            placeholder="Name of the staff">
    </div>
    <div class="col">
        <label for="inputEmail4">Designation<span style="color: red">*</span></label>
        <input type="text" class="form-control" id="staff_designation" name="staff_designation" required=""
            placeholder="Designation">
    </div>


</div>
<br />
<div class="row">

    <div class="col">
        <label for="inputEmail4">Staff ID<span style="color: red">*</span></label>
        <input type="text" class="form-control" id="staff_id" name="staff_id" required="" placeholder="Staff ID">
    </div>
    <div class="col">
        <label for="staff_certification">
            Staff Certification/Testimonial From BAFSD (jpg, jpeg, pdf format)
            <span style="color: red">*</span> (File size max 200 KB)
        </label>
        <input type="file" class="form-control" id="staff_certification" name="staff_certification"
            accept=".pdf, .jpg, .jpeg" placeholder="Certification/Testimonial">
        <input type="hidden" class="form-control" id="staff_certification_old" name="staff_certification_old"
            placeholder="Certification/Testimonial">
    </div>


</div>
<br />
<div class="row">

    <div class="col">

    </div>
    <div class="col" id="staff_certification_preview">

    </div>

</div>

<script>
    document.getElementById('staff_certification').addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const allowedTypes = ['application/pdf', 'image/jpeg'];
            const maxSize = 200 * 1024; // 200 KB

            // ✅ Check file type
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    title: "Warning!",
                    html: "Only PDF, JPG, or JPEG files are allowed.",
                    icon: "warning"
                });
                this.value = ''; // Reset file input
                return;
            }

            // ✅ Check file size
            if (file.size > maxSize) {
                Swal.fire({
                    title: "Warning!",
                    html: "File size must not exceed <b>200 KB</b>.",
                    icon: "warning"
                });
                this.value = ''; // Reset file input
                return;
            }
        }
    });
</script>
