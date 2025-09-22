                                <table class="table ">
                                <thead>
                                        <tr>
                                            <th rowspan="2">SL</th>
                                            <th rowspan="2">Student</th>
                                            <th rowspan="2">Roll</th>
                                            <th colspan="6" style="text-align: center">CT & Quiz</th>
                                            <th colspan="5" style="text-align: center">Subject Mark</th>
                                            <th rowspan="2">Total (100)</th>
                                            <th rowspan="2">GPA point</th>
                                            <th rowspan="2">GPA</th>
                                        </tr>
                                        <tr>
                                            <th>CT1</th>
                                            <th>CT2</th>
                                            <th>Quiz1</th>
                                            <th>Quiz2</th>
                                            <th>Total</th>
                                            <th>Conv 30</th>

                                            <th>CQ Marks</th>
                                            <th>Practical Marks</th>
                                            <th>MCQ Marks</th>
                                            <th>Total</th>
                                            <th>Convt (70)</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($markdata as $key=>$student)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$student->first_name}}</td>
                                            <td>{{$student->student_code}}</td>
                                            <td>{{$student->ct1}}</td>
                                            <td>{{$student->ct2}}</td>
                                            <td>{{$student->ct3}}</td>
                                            <td>{{$student->ct4}}</td>
                                            <td>{{$student->ct1+$student->ct2+$student->ct3+$student->ct4}}</td>
                                            <td>{{$student->ct}}</td>

                                            <td>{{$student->cq_total}}</td>
                                            <td>{{$student->mcq_total}}</td>
                                            <td>{{$student->practical_total}}</td>
                                            <td>{{$student->total}}</tdth>
                                            <td>{{$student->conv_total}}</td>

                                            <td >{{$student->ct_conv_total}}</td>
                                            <td >{{$student->gpa_point}}</td>
                                            <td >{{$student->gpa}}</tdth>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>