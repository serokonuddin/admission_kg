<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <h4 class="panel-title">{{$subject->subject_name.'('.$subject->subject_wise_class->subject_code.')'}}<span style="font-size: 0.8em">: {{(!empty($students))?count($students):count($subjectMarks)}} students found</span>
    </h4>
    <table class="table " >
                        <thead>
                        <tr>
                            <th rowspan="2">SL</th>
                            <th rowspan="2">Student</th>
                            <th rowspan="2">Roll</th>
                            @foreach($subject->subjectMarkTerms as $term)
                            <th colspan="2">
                                @if($term->marks_for==0)
                                CT
                                @elseif($term->marks_for==1)
                                CQ
                                @elseif($term->marks_for==2)
                                MCQ
                                @else 
                                Practic
                                @endif
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                           @foreach($subject->subjectMarkTerms as $term)
                            <th >Total Mark</th>
                            <th >Avarage Mark</th>
                            @endforeach
                            
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
                                
                                 @foreach($student->avaragemark as $avaragemark)
                                
                                <td>{{$avaragemark->mark??''}}</td>
                                <td>{{$avaragemark->avarage_mark??''}}</td>
                                @endforeach
                               
                                
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