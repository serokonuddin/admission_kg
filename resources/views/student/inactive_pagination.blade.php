@php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    function getCauserName($userId, $datetime)
    {
        // Check if the user ID is valid
        if (!$userId) {
            return 'N/A';
        }

        // Fetch the user data from the cache or database
        $user = Cache::remember("user_$userId", 60, function () use ($userId) {
            return DB::table('users')->find($userId);
        });

        // Return the user's name and datetime, or 'N/A' if the user doesn't exist
        return optional($user)->name ? $user->name . ' ' . $datetime : 'N/A';
    }
@endphp
<div id="print-table">
    <div id="result-table" style="display: none;">
        <p class="border border-gray-500 p-2 dynamic-data" style="display: flex; justify-content: space-around;">
        </p>
    </div>

    <div class="table-responsive" id="item-list">
        @if ($students->isEmpty())
            <p class="text-center alert alert-warning">No students found. Use the search form to find
                students.</p>
        @else
            <table class="table table-hover table-striped align-middle" id="headerTable">
                <thead class="table-dark text-center">
                    <tr>
                        <th>SL</th>
                        <th>Roll</th>
                        <th>SID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Remark</th>
                        <th>Status</th>
                        @if (Auth::user()->group_id == 2 && Auth::user()->is_view_user == 0)
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 text-center">
                    @foreach ($students as $index => $student)
                        <tr id="row{{ $student->id }}" class="align-middle">
                            <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                            </td>
                            <td><strong>{{ $student->studentActivity->roll ?? '-' }}</strong></td>
                            <td style="width: 140px;"><span
                                    class="badge bg-primary">{{ $student->student_code ?? '-' }}</span>
                            </td>
                            <td style="text-align: left">
                                <span class="fw-bold">{{ $student->first_name . ' ' . $student->last_name }}</span>
                            </td>
                            <td>
                                <span
                                    class="text-muted">{{ $student->mobile ? $student->mobile : ($student->father_phone ? $student->father_phone : $student->sms_notification) }}</span>
                            </td>
                            <td>
                                <div class="remark-box border rounded px-2 py-2 bg-light text-start">
                                    @if (!empty($student->remark))
                                        {!! $student->remark !!}
                                    @else
                                        <p class="text-muted">No remarks available</p>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if ($student->studentActivity->status == 0)
                                    <span class="badge bg-danger">Inactive</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            @if (Auth::user()->group_id == 2 && Auth::user()->is_view_user == 0)
                                <td>
                                    <button class="btn btn-sm btn-outline-success px-3"
                                        onclick="openInactiveModal({{ $student->id }})">
                                        <i class="bx bx-check-circle"></i> Activate
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex mt-3 justify-content-end items-center dataTables_paginate">
                <!-- Pagination Links -->
                {!! $students->appends([
                        'search' => request('search'),
                        'shift_id' => request('shift_id'),
                        'version_id' => request('version_id'),
                        'session_id' => request('session_id'),
                        'class_code' => request('class_code'),
                        'section_id' => request('section_id'),
                        'text_search' => request('text_search'),
                        'searchQuery' => request('searchQuery'),
                    ])->links() !!}
            </div>
        @endif
    </div>
</div>
