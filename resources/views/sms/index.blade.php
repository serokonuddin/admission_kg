@extends('admin.layouts.layout')
@section('content')
    <style>
        .control {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        th.control:before,
        td.control:before {
            background-color: #696cff;
            border: 2px solid #fff;
            box-shadow: 0 0 3px rgba(67, 89, 113, .8);
        }

        td.control:before,
        th.control:before {
            top: 50%;
            left: 50%;
            height: 0.8em;
            width: 0.8em;
            margin-top: -0.5em;
            margin-left: -0.5em;
            display: block;
            position: absolute;
            color: white;
            border: 0.15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 0.2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: "Courier New", Courier, monospace;
            line-height: 1em;
            content: "+";
            background-color: #0d6efd;
        }

        .table-dark {
            background-color: #1c4d7c !important;
            color: #fff !important;
            font-weight: bold;
        }

        .table-dark {
            --bs-table-bg: #1c4d7c !important;
            --bs-table-striped-bg: #1c4d7c !important;
            --bs-table-striped-color: #fff !important;
            --bs-table-active-bg: #1c4d7c !important;
            --bs-table-active-color: #fff !important;
            --bs-table-hover-bg: #1c4d7c !important;
            --bs-table-hover-color: #fff !important;
            color: #fff !important;
            border-color: #1c4d7c !important;
        }

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .p-10 {
            padding: 10px !important;
        }

        .m-r-10 {
            margin-right: 10px !important;
        }

        .childdata {
            display: none;
            background-color: #98fded;
        }

        .my-actions {
            display: flex;
            justify-content: center;
            gap: 10px;

        }
    </style>
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
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> SMS List </li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header" style="text-align: right">
                    @if (Auth::user()->is_view_user == 0)
                        <div class="mb-2">
                            <a href="{{ route('sms.create') }}" class="btn btn-round btn-md btn-info rounded">Send SMS</a>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="row g-3">
                                <div class="col-sm-3 d-none">
                                    <select id="session_id" name="session_id" class=" form-select">
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->session_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 d-none">
                                    <select id="version_id" name="version_id" class=" form-select">
                                        <option value="">Select Version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}">{{ $version->version_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-3 d-none">
                                    <select id="shift_id" name="shift_id" class=" form-select">
                                        <option value="">Select Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->shift_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 d-none">

                                    <select id="class_id" name="class_id" class=" form-select">
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class_id => $class_name)
                                            <option value="{{ $class_id }}">{{ $class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 d-none">
                                    <select id="section_id" name="section_id" class=" form-select">
                                        <option value="">Select Section</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="text_search" class="form-control" id="text_search"
                                        value="" placeholder="search by mobile or student code" />
                                </div>
                                <div class="col-sm-3 text-start">
                                    <button type="submit" id="search" class="btn btn-primary me-2">Search</button>
                                    <button id="reset" class="btn btn-danger me-2 d-none">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 pb-2">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center">
                                <label class="form-label d-flex align-items-center mb-0">
                                    Select per page:
                                    <select id="pageSize" name="page_size" class="form-select mx-2" style="width: auto;">
                                        <option value="10" {{ request('page_size', 10) == 10 ? 'selected' : '' }}>
                                            10
                                        </option>
                                        <option value="25" {{ request('page_size', 10) == 25 ? 'selected' : '' }}>
                                            25
                                        </option>
                                        <option value="50" {{ request('page_size', 10) == 50 ? 'selected' : '' }}>
                                            50
                                        </option>
                                        <option value="100" {{ request('page_size', 10) == 100 ? 'selected' : '' }}>
                                            100
                                        </option>
                                    </select>
                                    entries
                                </label>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-sapce-beteween gap-3">
                            <div>
                                <button type="button" class="btn btn-success btn-sm" id="excelDownload"
                                    style="display: none">Excel
                                    Download</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="sms_list">
                        @if ($smss->isEmpty())
                            <div class="alert alert-warning text-center">No SMS found. Use the search form to find SMS.
                            </div>
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

                                                <td class="text-wrap" style="max-width: 300px;">
                                                    {{ $sms->sms_body ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    {{ getCauserName($sms->created_by, $sms->created_at) ?? 'N/A' }}</td>
                                                {{-- @if (Auth::user()->is_view_user == 0)
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-sm btn-light dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item text-danger delete"
                                                                        data-url="{{ route('sms.destroy', $sms->id) }}"
                                                                        data-id="{{ $sms->id }}"
                                                                        href="javascript:void(0);">
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

                </div>
                <!-- Modal -->
                <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalFullTitle">Student Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="background-color: #f5f2f2">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->
            <div class="content-backdrop fade"></div>
        </div>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    showConfirmButton: true,
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                    showConfirmButton: true
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Errors',
                    html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
                    showConfirmButton: true
                });
            @endif
        </script>
        <script type="text/javascript">
            $(function() {
                $(document.body).on('change', '#class_id', function() {
                    var id = $(this).val();
                    var shift_id = $('#shift_id').val();
                    var version_id = $('#version_id').val();
                    var url = "{{ route('class-wise-sections') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            class_id: id,
                            shift_id,
                            version_id
                        },
                        success: function(response) {
                            $('#section_id').html(response);
                        },
                        error: function(data, errorThrown) {
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                });
                $(document.body).on('change', '#shift_id', function() {
                    var shift_id = $('#shift_id').val();
                    var version_id = $('#version_id').val();
                    if (version_id && shift_id) {
                        var url = "{{ route('getClass') }}";
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                shift_id,
                                version_id
                            },
                            success: function(response) {
                                $.LoadingOverlay("hide");
                                $('#class_id').html(response);
                            },
                            error: function(data, errorThrown) {
                                $.LoadingOverlay("hide");
                                Swal.fire({
                                    title: "Error",
                                    text: errorThrown,
                                    icon: "warning"
                                });

                            },
                            complete: function() {
                                $.LoadingOverlay("hide");
                            }
                        });
                    }
                });
                $(document.body).on('change', '#version_id', function() {
                    var shift_id = $('#shift_id').val();
                    var version_id = $('#version_id').val();
                    if (version_id && shift_id) {
                        var url = "{{ route('getClass') }}";
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                shift_id,
                                version_id
                            },
                            success: function(response) {

                                $('#class_id').html(response);
                                $('#section_id').html('');

                            },
                            error: function(data, errorThrown) {
                                Swal.fire({
                                    title: "Error",
                                    text: errorThrown,
                                    icon: "warning"
                                });

                            },
                            complete: function() {
                                $.LoadingOverlay("hide");
                            }
                        });
                    }

                });
                $(document.body).on('click', '.delete', function() {
                    var id = $(this).data('id');
                    var url = $(this).data('url');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This action will permanently delete the sms.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'btn btn-danger order-1',
                            cancelButton: 'btn btn-secondary order-2',
                        },
                        buttonsStyling: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.LoadingOverlay("show");
                            $.ajax({
                                type: "delete",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                                },
                                url: url,
                                data: {
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    handleSuccess(response, id);
                                },
                                error: function(data, errorThrown) {
                                    handleError(data, errorThrown);

                                },
                                complete: function() {
                                    $.LoadingOverlay("hide");
                                }
                            });
                        } else if (result.isDenied) {

                        }
                    })

                });
                $(document.body).on('click', '#reset', function() {
                    $.LoadingOverlay("show");
                    $('#class_id').val('');
                    $('#shift_id').val('');
                    $('#version_id').val('');
                    $('#session_id').val('');
                    $('#section_id').val('');
                    $('#sms_list').html('');
                    $('#text_search').val('');
                    $('#excelDownload').hide();
                    $.LoadingOverlay("hide");
                });
                $('#search').on('click', function() {
                    fetch_data(1);
                });
                document.getElementById("text_search").addEventListener("keypress", function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                        fetch_data(1);
                    }
                });
                $('#pageSize').on('change', function() {
                    fetch_data(1);
                });
                var globalPage = 1;
                // Handle pagination links
                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    globalPage = page;
                    fetch_data(page);
                });
            });

            function fetch_data(page) {

                const url = "{{ route('sms.index') }}";
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_code = $('#class_id').val();
                var section_id = $('#section_id').val();
                var text_search = $('#text_search').val()
                var page_size = $('#pageSize').val();

                // Build the query string
                var searchtext = '&shift_id=' + shift_id +
                    '&version_id=' + version_id +
                    '&class_code=' + class_code +
                    '&section_id=' + section_id +
                    '&session_id=' + session_id +
                    '&text_search=' + text_search +
                    '&page_size=' + page_size;

                // AJAX call to fetch data
                $.LoadingOverlay("show");
                $.ajax({
                    url: url + "?page=" + page + searchtext,
                    success: function(data) {
                        console.log(data, "Data");
                        $('#sms_list').html(data);
                        // $('#excelDownload').show();
                    },
                    error: function(xhr, status, error) {
                        handleError(xhr, error);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            }

            function handleSuccess(response, id) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The student has been successfully deleted.',
                    icon: 'success',
                    showConfirmButton: true,
                });
                $('#row' + id).remove();
            }

            function handleError(data, xhr) {
                const errorMessage = data?.responseJSON?.message || 'An error occurred';
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    showConfirmButton: true,
                });
            }
        </script>
    @endsection
