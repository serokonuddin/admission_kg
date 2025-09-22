<div class="card">
    <div class="card-body">
        <h5 class="card-title">Version and Shift Wise Sections</h5>
        @foreach ($sections as $key => $section)
            <div class="row my-3">
                <div class="col-md-12 my-2 form-check">
                    <button type="button" class="btn btn-secondary " id="sectionId"
                        name="sectionId">{{ $section->section_name }}</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
