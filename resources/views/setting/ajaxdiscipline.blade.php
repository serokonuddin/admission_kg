<option value="">Select Discripline</option>
                          @foreach($disciplines as $discipline)
                          <option value="{{$discipline->id}}">{{$discipline->name}}</option>
                          @endforeach 