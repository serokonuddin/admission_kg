@foreach($educations as $education)
                                             <tr>
                                               <td>{{ optional($education->degree)->degree_name ?? 'N/A' }}</td>
                                                <td>{{ optional($education->discipline)->name ?? 'N/A' }}</td>
                                                {{-- <td>{{$education->specialization->specialization_name}}</td> --}}
                                                <td>{{ $education->specialization ? $education->specialization->specialization_name : 'N/A' }}</td>
                                                <td>{{$education->institute}}</td>
                                                <td>{{$education->passingYear}}</td>
                                                <td>{{$education->grade_division}}:{{$education->result}}</td>
                                                <td>

                                                <div class="dropdown">
                                                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                                      <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item edit" 
                                                            data-id="{{$education->id}}" 
                                                            data-employee_id="{{$education->employee_id}}" 
                                                            data-degree_id="{{$education->degree_id}}" 
                                                            data-discipline_id="{{$education->discipline_id}}" 
                                                            data-specialization_id="{{$education->specialization_id}}" 
                                                            data-institute="{{$education->institute}}" 
                                                            data-yearofschooling="{{$education->yearOfSchooling}}" 
                                                            data-passingyear="{{$education->passingYear}}" 
                                                            data-degree_name="{{$education->degree_name}}" 
                                                            data-grade_division="{{$education->grade_division}}" 
                                                            data-result="{{$education->result}}" 
                                                            data-file="{{$education->file}}" 
                                                            href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                           
                                                      </div>
                                                   </div>
                                                </td>
                                                
                                             </tr>   
                                    @endforeach