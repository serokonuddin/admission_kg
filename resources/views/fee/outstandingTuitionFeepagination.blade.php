<table class="table">
                                    <thead class="table-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>#</th>
                                        <th>Student Code</th>
                                        <th>Student Name</th>
                                        <th>Version</th>
                                        <th>Shift</th>
                                        <th>Section</th>
                                        <th>Class</th>
                                        <th>Category</th>
                                        <th>Month</th>
                                        <th>Head Name</th>
                                        <th>Amount</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @foreach($students as $key=>$student)
                   <tr id="row{{$student->id}}">
                      <!-- <td class="control">
                      </td> -->
                      <td>
                        {{$key+1}}
                        </td>
                        <td>
                            {{$student->student_code??''}}
                        </td>
                        
                        <td 
                        data-bs-toggle="#modal"
                        data-bs-target="#fullscreenModal"
                        class="studentinfo" data-studentcode="{{$student->student_code}}"> <img src="{{$student->photo??asset('public/student.png')}}" alt="Avatar" class="rounded-circle avatar avatar-xs"> 
                        {{$student->first_name.' '.$student->last_name}}
                        </td>
                        
                        <td>{{$student->version->version_name??''}}</td>
                        <td>{{$student->shift->shift_name??''}}</td>
                        <td>{{$student->classes->class_name??''}}</td>
                        <td>{{$student->section->section_name??''}}</td>
                        <td>{{$student->category->category_name??''}}</td>
                        @php 
                            if($student->fee_for==1){
                                $text="Tuition Fee";
                            }elseif($student->fee_for==2){
                                $text="Session Fee";
                            }elseif($student->is_admission==1){
                                $text="Admission Fee";
                            }else{
                                $text=$student->headdata->head_name??'';
                            }
                        @endphp
                        <td>
                        {{$months[$student->month]??''}}
                        </td>
                        <td>{{$text}}</td>
                        <td>{{$student->amount??''}}</td>
                        
                    </tr>
                    @endforeach
                                    </tbody>
                                </table>
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate" style="padding: 10px">
                                    <!-- {{$students->links('pagination')}} -->
                                    
                                    {!! $students->appends([
                    'search' => request('search')
                    ,'start_date' => request('start_date')
                    ,'end_date' => request('end_date')
                    ,'version_id' => request('version_id')
                    ,'class_id' => request('class_id')
                    ])->links('bootstrap-4') !!}
                                    </div>