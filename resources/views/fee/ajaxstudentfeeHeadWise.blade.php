
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
@php 
$months=array(
    '01'=>'January',
    '02'=>'February',
    '03'=>'March',
    '04'=>'April',
    '05'=>'May',
    '06'=>'June',
    '07'=>'July',
    '08'=>'August',
    '09'=>'September',
    '10'=>'Octobar',
    '11'=>'November',
    '12'=>'December'
);
@endphp
<table class="table" id="headerTable">
                                    <thead class="table-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>#</th>
                                        <th>Student Code</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Roll</th>
                                        <th>Fee Head</th>
                                        <th>Month</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" >
                                    @foreach($studentfees as $key=>$payment)
                                    <tr id="id{{$payment->id}}">
                                        <td >
                                            {{$key+1}}
                                        </td>
                                        <td>{{$payment->student->student_code??''}}</td>
                                        <td>{{$payment->student->first_name??''}}</td>
                                        <td>{{$payment->class_code??''}}</td>
                                        <td>{{$payment->student->studentActivity->section->section_name??''}}</td>
                                        <td>{{$payment->section->studentActivity->roll??''}}</td>
                                       
                                        <td>
                                           
                                        {{$payment->headdata->head_name??''}}
                                        </td>
                                        <td>{{$months[$payment->month]??''}}</td>
                                        <td>{{$payment->payment_date??''}}</td>
                                        
                                        <td>{{$payment->amount??''}}</td>
                                        <td>{{$payment->status??''}}</td>
                                        
                                        
                                        
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "pagingType": "full_numbers", // Optional: This gives you 'First', 'Previous', 'Next', 'Last' buttons
                "dom": 'lfrtip', // 'l' indicates the length menu dropdown
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>