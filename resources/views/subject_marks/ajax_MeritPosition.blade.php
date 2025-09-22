<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    </h4>
    <table class="table " >
                        <thead>
                        <tr>
                            <th rowspan="2">SL</th>
                            <th rowspan="2">Student</th>
                            <th rowspan="2">Roll</th>
                            <th rowspan="2">Total Mark</th>
                            <th rowspan="2">Class Position</th>
                            <th rowspan="2">Section Position</th>
                           
                        </tr>
                       
                        
                    </thead>
                        <tbody>
                            @foreach($students as $student)
                            
                            <tr>
                                <td>
                                    {{$loop->index+1}}
                                    
                                     
                                </td>
                                <td>{{$student->first_name}}</td>
                                <td>{{$student->roll}}</td>
                                
                                
                                
                                <td>{{$student->totalmark->total_mark??''}}</td>
                                <td>{{$student->totalmark->position_in_class??''}}</td>
                                <td>{{$student->totalmark->position_in_section??''}}</td>
                              
                               
                                
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