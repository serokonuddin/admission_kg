<style>
    .control {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        position: relative;
        cursor: pointer;
    }
    th.control:before,td.control:before {
        background-color: #696cff;
        border: 2px solid #fff;
        box-shadow: 0 0 3px rgba(67,89,113,.8);
    }
    td.control:before, th.control:before {
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
        font-family: "Courier New",Courier,monospace;
        line-height: 1em;
        content: "+";
        background-color: #0d6efd;
    }
    .table-dark {
        background-color: #1c4d7c!important;
        color: #fff!important;
        font-weight: bold;
    }
    .table-dark {
        --bs-table-bg: #1c4d7c!important;
        --bs-table-striped-bg: #1c4d7c!important;
        --bs-table-striped-color: #fff!important;
        --bs-table-active-bg: #1c4d7c!important;
        --bs-table-active-color: #fff!important;
        --bs-table-hover-bg: #1c4d7c!important;
        --bs-table-hover-color: #fff!important;
        color: #fff!important;
        border-color: #1c4d7c!important;
    }
    .table:not(.table-dark) th {
        color: #ffffff;
    }
</style>
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

<div class="table-responsive ">
             <table class="table">
                <thead class="table-dark">
                   <tr>
                      <!-- <th>#</th> -->
                      <th>#</th>
                      <th>Name</th>
                      <th>Payment For</th>
                      <th>Session</th>
                      <th>Version</th>
                      <th>Shift</th>
                      <th>Class</th>
                      <th>Category</th>
                      <th>Month</th>
                      <th>Amount</th>
                      <th>Status</th>
                   </tr>
                </thead>
                @php 
                        $total=0;
                   @endphp
                <tbody class="table-border-bottom-0">
                    @foreach($students as $key=>$payment)
                   <tr>
                      <td >
                        {{$key+1}}
                      </td>
                      
                    
                      <td 
                      data-bs-toggle="#modal"
                      data-bs-target="#fullscreenModal"
                       class="studentinfo" data-studentcode="{{$payment->student_code}}"> <img src="{{$payment->photo??asset('student.png')}}" alt="Avatar" class="rounded-circle avatar avatar-xs"> 
                      {{$payment->first_name.' '.$payment->last_name}}
                       </td>
                       <td>
                         @if($payment->fee_for==1)
                           Adminssion Fee
                         @elseif($payment->fee_for==2)
                           Tuition Fee
                         @else
                           Exam Fee
                         @endif
                      </td>
                      <td>{{$payment->session_name??''}}</td>
                      <td>{{$payment->version_name??''}}</td>
                      <td>{{$payment->shift_name??''}}</td>
                      <td>{{$payment->class_name??''}}</td>
                      <td>{{$payment->category_name??''}}</td>
                      <td>{{$months[$payment->month]}}</td>
                      <td>{{$payment->amount??''}}</td>
                      <td> @if($payment->status==0)
                      <button type="button" class="btn btn-danger">Unpaid</button>
                           
                         @elseif($payment->status==1)
                           
                           <button type="button" class="btn btn-primary">Paid</button>
                         @endif</td>
                      <!-- <td data-bs-toggle="#modal"
                      data-bs-target="#fullscreenModal"
                       class="feeInfo" data-id="{{$payment->id}}" data-href="{{route('viewStudentFee',$payment->id)}}">
                       <a class="dropdown-item edit" 
                                    ><i class="fa fa-eye me-1"></i></a>
                      </td> -->
                   </tr>
                   @php 
                        $total+=$payment->amount??0;
                   @endphp
                   @endforeach
                   <tr>
                    <td colspan="9" style="text-align: right">Total Amount</td>
                    <td>{{$total}} TK</td>
                   </tr>
                   
                </tbody>
             </table>
             
          </div>
          