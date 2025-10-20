<div class="row">

    <div class="col">
        <label for="inputEmail4">Name Of Service Holder<span style="color: red">*</span></label>
        <input type="text" class="form-control" name="service_holder_name" id="service_holder_name" required=""
            placeholder="Name of service Holder">
    </div>
    <div class="col">
        <label for="inputEmail4">Rank/Designation<span style="color: red">*</span></label>
        <input type="text" class="form-control" required="" name="name_of_service" id="name_of_service"
            placeholder="Rank/Designation">
    </div>


</div>
<br />
<div class="row">

    <div class="col">
        <label for="inputEmail4">Service Number<span style="color: red">*</span></label>
        <input type="text" class="form-control" required="" name="service_name" id="service_name"
            placeholder="Service number">
    </div>
    <div class="col">
        <label for="inputEmail4">Present Office Address<span style="color: red">*</span></label>
        <input type="text" class="form-control" name="office_address" id="office_address"
            placeholder="Present office Address">
    </div>


</div>
<br />

<div class="row">

    <div class="col">
        <label for="arm_certification">
            Certification/Testimonial From Office (jpg, jpeg, pdf format)
            <span style="color: red">*</span> (File size max 200 KB)
        </label>
        <input type="file" class="form-control" id="arm_certification" name="arm_certification"
            accept=".pdf, .jpg, .jpeg" placeholder="Certification/Testimonial">
        <input type="hidden" class="form-control" id="arm_certification_old" name="arm_certification_old"
            placeholder="Certification/Testimonial">
    </div>
    <div class="col">

    </div>



</div>

<script>
    document.getElementById('arm_certification').addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const allowedTypes = ['application/pdf', 'image/jpeg'];
            const maxSize = 200 * 1024; // 200 KB

            // ✅ Validate file type
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    title: "Warning!",
                    html: "Only PDF, JPG, or JPEG files are allowed.",
                    icon: "warning"
                });
                this.value = ''; // Reset invalid file
                return;
            }

            // ✅ Validate file size
            if (file.size > maxSize) {
                Swal.fire({
                    title: "Warning!",
                    html: "File size must not exceed <b>200 KB</b>.",
                    icon: "warning"
                });
                this.value = ''; // Reset invalid file
                return;
            }
        }
    });
</script>
