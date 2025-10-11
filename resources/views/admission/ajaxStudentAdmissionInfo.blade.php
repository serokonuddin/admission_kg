@php 
                        $gender=array(1=>'Male',2=>'Female',''=>'');
                  @endphp
            @foreach($studentdata as $student)
            <div class="col-12 col-xl-4 col-md-6 " style="margin-top: 10px;">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="{{asset($student->photo)}}" alt="Card girl image" style="height: 100px;width: auto">
                        </div>
                        <h5 class="mb-2 text-center" style="color: red">{{$student->name_bn}}</h5>
                        <h5 class="mb-2 text-center" style="color: orange">Mobile: {{$student->mobile}}</h5>
                        
                        
                        <div class="row mb-4 g-3">
                        <div class="col-12">
                            <div>
                            <h6 class="mb-0 text-nowrap"><strong>Version:</strong> {{($student->version_id==1)?'Bangla':'English'}}</h6>
                            <h6 class="mb-0 text-nowrap"><strong>Shift:</strong> {{($student->shift_id==1)?'Morning':'Day'}}</h6>
                            <h6 class="mb-0 "><strong>Gurdian Name:</strong> {{$student->gurdian_name??''}}</h6>
                                <h6 class="mb-0 text-nowrap"><strong>DOB:</strong> {{$student->dob??''}}</h6>
                                <h6 class="mb-0 text-nowrap"><strong>Birth Number:</strong> {{$student->birth_registration_number??''}}</h6>
                                <h6 class="mb-0 text-nowrap"><strong>Gender:</strong> {{$gender[$student->gender]??''}}</h6>
                                <h6 class="mb-0 text-nowrap"><strong>Serial No:</strong> {{$student->temporary_id??''}}</h6>
                            </div>
                            </div>
                        </div>
                        
                        </div>
                    
                    </div>
                </div>
            </div>
            @endforeach
            