@foreach($employees as $key=>$employee)
<tr>
    <td>
        {{$key+1}}
</td>
    <td>
        {{$employee->emp_id}}
</td>
    <td>
        {{$employee->employee_name}}<br/>
        ({{$employee->designation_name}})
</td>
    <td>
     <input type="hidden" name="mobile[]" value="{{$employee->mobile}}" />
        {{$employee->mobile}}
</td>
</tr>
@endforeach