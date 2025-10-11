<input type="hidden" name="mobile[]" value="{{$mobiles}}" />
@foreach($students as $key=>$student)


<tr>
    <td>
        {{$key+1}}
</td>
    <td>
        {{$student['roll']}}
</td>
    <td>
        {{$student['first_name'].' '.$student['last_name']}}
</td>
    <td>
        
        {{$student['sms_notification']}}
</td>
</tr>
@endforeach