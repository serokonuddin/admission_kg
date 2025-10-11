<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<table class="table " id="headerTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Session</th>
                                    <th>Class Code</th>
                                    <th>Exam </th>
                                    <th>Subject</th>
                                    <th>Exam For</th>
                                    <th>Exam Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->id }}</td>
                                        <td>{{ $schedule->session->session_name }}</td>
                                        <td>{{ $schedule->class_code }}</td>
                                        <td>{{ $schedule->exam->exam_title.' '.$schedule->session->session_name.' (class:'.($schedule->class_code?$schedule->class_code:'KG').')' }}</td>
                                        <td>{{ $schedule->subject->subject_name }}</td>
                                        <td>{{ $schedule->exam_for == 1 ? 'Written & MCQ' : 'Practical' }}</td>
                                        <td>{{ $schedule->exam_date }}</td>
                                        <td>{{ $schedule->start_time }}</td>
                                        <td>{{ $schedule->end_time }}</td>
                                        
                                        <td>
                                            <a href="{{ route('exam-time-shedules.edit', $schedule->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('exam-time-shedules.destroy', $schedule->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

    <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>