@php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    function getCauserName($userId, $datetime)
    {
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

<div class="table-responsive" id="sms_list">
    @if ($smss->isEmpty())
        <div class="alert alert-warning text-center">No SMS found. Use the search form to find SMS.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>SL</th>
                        <th>Session</th>
                        <th>Language</th>
                        <th>Send For</th>
                        <th>Numbers</th>
                        <th>SMS Body</th>
                        <th>Send By</th>
                        {{-- @if (Auth::user()->is_view_user == 0)
                            <th>Action</th>
                        @endif --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($smss as $sms)
                        <tr>
                            <td class="text-center">
                                {{ ($smss->currentPage() - 1) * $smss->perPage() + $loop->iteration }}
                            </td>
                            <td class="text-center">{{ $sms->session->session_name ?? 'N/A' }}</td>
                            <td class="text-center">
                                {{ isset($sms->lang) && $sms->lang == 1 ? 'BN' : 'ENG' }}
                            </td>
                            <td class="text-center">
                                @if (isset($sms->send_for))
                                    @if ($sms->send_for == 1)
                                        <span class="badge bg-primary">Student</span>
                                    @elseif($sms->send_for == 2)
                                        <span class="badge bg-success">Teacher</span>
                                    @else
                                        <span class="badge bg-secondary">Others</span>
                                    @endif
                                @else
                                    <span class="badge bg-warning">N/A</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($sms->numbers)
                                    @foreach (explode(',', $sms->numbers) as $number)
                                        {{ $number }}<br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>

                            <td class="text-wrap" style="max-width: 300px;">{{ $sms->sms_body ?? 'N/A' }}</td>
                            <td class="text-center">{{ getCauserName($sms->created_by, $sms->created_at) ?? 'N/A' }}
                            </td>
                            {{-- @if (Auth::user()->is_view_user == 0)
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item text-danger delete"
                                                    data-url="{{ route('sms.destroy', $sms->id) }}"
                                                    data-id="{{ $sms->id }}" href="javascript:void(0);">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            @endif --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Section --}}
        <div class="d-flex justify-content-between align-items-center px-3 mt-3" id="total_records">
            <p class="mb-0">
                Showing <strong>{{ ($smss->currentPage() - 1) * $smss->perPage() + 1 }}</strong>
                to
                <strong>{{ min($smss->currentPage() * $smss->perPage(), $smss->total()) }}</strong>
                of <strong>{{ $smss->total() }}</strong> SMS.
            </p>
            <div class="pagination-container">
                {!! $smss->appends([
                        'shift_id' => request('shift_id'),
                        'version_id' => request('version_id'),
                        'session_id' => request('session_id'),
                        'class_code' => request('class_id'),
                        'section_id' => request('section_id'),
                        'text_search' => request('text_search'),
                    ])->links('bootstrap-4') !!}
            </div>
        </div>
    @endif

</div>
