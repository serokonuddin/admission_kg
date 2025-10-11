@foreach($students as $student)
                   <tr id="row{{$student->id}}">
                      <!-- <td class="control">
                      </td> -->
                      <td>
                        <input type="hidden" name="student_code[]" value="{{$student->student_code}}" />
                       <button class="btn btn-warning" type="button"><i class="fa fa-edit"></i></button>
                      </td>
                      <td>
                      {{$loop->index+1}}
                      </td>
                      <td>
                      {{$student->studentActivity->student_code??''}}
                      </td>
                     
                      <td 
                      data-bs-toggle="#modal"
                      data-bs-target="#fullscreenModal"
                       class="studentinfo text-wrap" data-studentcode="{{$student->student_code}}"> {{$student->first_name.' '.$student->last_name}}
                       </td>
                      
                      <td>{{$student->studentActivity->roll??''}}</td>
                      <td>{{$student->studentActivity->classes->class_name??''}}</td>
                      <td><input type="number" name="amount{{$student->student_code}}"  id="amount{{$student->student_code}}" class="form-control" value="{{$classwiseemischarge[$student->student_code][0]->amount??$amount}}" placeholder="Amount" /></td>
                      
                   </tr>
                   @endforeach