<div class="card">
    <div class="card-body">
        @php
            $groupedClasses = $classes->groupBy('version_id');
            $class_name = $groupedClasses->first()?->first()?->class_name ?? 'No Class Name';
        @endphp
        <h6 class="card-title text-center text-white gradient-card">Selected Class:&nbsp;{{ $class_name }}</h6>

        @foreach ($groupedClasses as $versionId => $classesByVersion)
            <div class="row my-3">
                <div class="col-md-12 my-2">
                    <button type="button" class="btn  version-btn btn-class" name="versionId"
                        data-target="shiftContainer-{{ $versionId }}" value="{{ $versionId }}">
                        {{ $versionId == 1 ? 'Bangla' : 'English' }}
                    </button>
                </div>
                <div class="col-md-12 my-2">

                    @if ($versionId)
                        <div id="shiftContainer-{{ $versionId }}" class="shift-container">
                            <!-- Shifts for this version will load here dynamically -->
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />
        <input type="hidden" id="session_id" name="session_id" value="{{ $session->session_code }}" />
    </div>
</div>
