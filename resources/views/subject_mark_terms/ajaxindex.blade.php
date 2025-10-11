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
            <th>SL</th>
            <th>Session ID</th>
            <th>Class Code</th>
            <th>Subject ID</th>
            <th>Marks For</th>
            <th>Total Mark</th>
            <th>Pass Mark</th>
            <th>Converted To</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($terms as $term)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $term->session->session_name }}</td>
                <td>{{ $term->class_code }}</td>
                <td>{{ $term->subject->subject_name }}</td>
                <td>
                    @if ($term->marks_for == 1)
                        CQ
                    @elseif($term->marks_for == 0)
                        CT
                    @elseif($term->marks_for == 2)
                        MCQ
                    @else
                        Practical
                    @endif

                </td>

                <td>{{ $term->total_mark }}</td>
                <td>{{ $term->pass_mark }}</td>
                <td>{{ $term->converted_to }}</td>
                <td>
                    <a href="{{ route('subject_mark_terms.edit', $term->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('subject_mark_terms.destroy', $term->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
