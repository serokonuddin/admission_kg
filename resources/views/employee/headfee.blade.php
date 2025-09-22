<div class="table-responsive ">
   <table class="table">
      <thead class="table-dark">
         <tr>
            <!-- <th>#</th> -->
            <th>#</th>
            <th>Head Name</th>
            <th>Amount</th>
            
         </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($heads as $key=>$head)
         <tr>
            <td>
               {{$key+1}}
            </td>
            
            <td>{{$head->head_name}}</td>
            <td>{{$head->amount}}</td>
            
         </tr>
         @endforeach

         <tr>
            <td colspan="2">
              Total Salary
            </td>
            
            
            <td>{{collect($heads)->sum('amount')}} Tk</td>
            
         </tr>
         
      </tbody>
   </table>
</div>