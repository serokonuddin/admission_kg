<style>
    .bottom-bar {
        padding: 5px;
        border-bottom: 2px solid rgb(0, 149, 221);
    }

    td .bottom-bar:last-child {
        padding: 0px;
        border-bottom: none;
    }

    .table tr>td .dropdown {
        position: relative;
    }
</style>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>

            <th>#</th>
            @foreach ($routinetime as $key => $routined)
                <th style="text-align: center">{{ $key + 1 }}<br />
                    {{-- {{date('H:i',strtotime($routined->start_time)).'-'.date('H:i',strtotime($routined->end_time))}} --}}
                    {{ date('g:i A', strtotime($routined->start_time)) . '-' . date('g:i A', strtotime($routined->end_time)) }}
                </th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        @foreach ($routine as $key => $data)
            <tr>
                <td>
                    {{ $key }}
                </td>
                @foreach ($routinetime as $key2 => $routined)
                    @if (isset($data[$routined->start_time]))
                        <td>
                            @foreach ($data[$routined->start_time] as $key1 => $value)
                                <div class="bottom-bar" id="row{{ $value->id }}"><span
                                        style="color:#347928;font-weight: bold">Teacher:</span>
                                    {{ $value->employee->employee_name ?? '' }} <br />
                                    @if ($value->is_class_teacher == 1)
                                        <span style="color: red;font-wigdth: bold">Class Teacher</span><br />
                                    @endif
                                    <span style="color:#640D5F;font-weight: bold">Subject:</span>
                                    {{ $value->subject[0]->subject_name ?? '' }}</br>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-info p-0 dropdown-toggle hide-arrow show"
                                                data-bs-toggle="dropdown" style="padding: 2px!important"
                                                aria-expanded="true">Action<i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu show"
                                                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(509.333px, -1926.67px, 0px);"
                                                data-popper-placement="top-start">
                                                <a class="editbutton dropdown-item"
                                                    href="{{ route('routine.edit', $value->id) }}"><i
                                                        class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item delete"
                                                    data-url="{{ route('routine.destroy', $value->id) }}"
                                                    data-id="{{ $value->id }}" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
