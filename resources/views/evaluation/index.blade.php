@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/tagify/tagify.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4">
          <span class="text-muted fw-light">Dashboard /</span> Student Evaluation
       </h4>
       <div class="row mb-4">
            @if(Auth::user()->getMenu('evaluation.store','name') || Auth::user()->group_id==2)
                   <form class="needs-validation" method="post" action="{{route('evaluation.store')}}"  novalidate="" id="formsubmit">
                    @csrf
                    @else
                    <form class="needs-validation" method="post" action="#"  novalidate="" id="formsubmit">
                    @endif
          <div class="col-md-12 mb-2">
             <div class="card">
                <h5 class="card-header">Evaluation Entry</h5>
                <div class="card-body">

                    <input type="hidden" name="id" id="id" value="0" />
                    <input type="hidden" name="head_id" id="head_id" value="{{$head_id}}" />
                    <div class="row">
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Version</label>
                        <select class="form-select" name="version_id" id="version_id" required="required">
                          @foreach($versions as $version)
                          <option value="{{$version->id}}">{{$version->version_name}}</option>
                          @endforeach

                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select Version </div>
                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Shift</label>
                        <select class="form-select" name="shift_id" id="shift_id" required="required">
                          @foreach($shifts as $shift)
                          <option value="{{$shift->id}}">{{$shift->shift_name}}</option>
                          @endforeach

                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select shift </div>
                      </div>


                     <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Class</label>
                        <select class="form-select" name="class_id" id="class_id" required="required">
                          @foreach($classes as $class)
                          <option value="{{$class->id}}">{{$class->class_name}} (Version: {{$class->version->version_name}} Shift: {{$class->shift->shift_name}})</option>
                          @endforeach

                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select Class </div>
                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Session</label>
                        <select class="form-select" name="session_id" id="session_id" required="required">
                          @foreach($sessions as $session)
                          <option value="{{$session->id}}">{{$session->session_name}}</option>
                          @endforeach

                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select Session </div>
                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Group</label>
                        <select class="form-select" name="group_id" id="group_id" >
                        <option value="0">Select Group</option>
                          @foreach($groups as $group)
                          <option value="{{$group->id}}">{{$group->group_name}}</option>
                          @endforeach

                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select Group </div>
                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Amount</label>
                        <input class="form-control" required="required" type="text" id="amount" name="amount" value="" placeholder="amount" autofocus="">
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Enter Amount </div>
                      </div>
                      <div class="row">
                          <div class="col-6">
                            <button type="button" class="btn btn-info" id="search">Search</button>
                         </div>

                      </div>
                    </div>

                </div>
             </div>
          </div>
          <!-- Browser Default -->
          <div class="col-md-12 mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Student Evaluation</h5>
                <div class="table-responsive text-nowrap fixed">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap table-info">
                          <th>Action</th>
                          <th>#</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Roll</th>
                          <th>Class</th>
                          <th>Evaluation Fee</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0" id="studentlist">

                      </tbody>
                      <tfoot>
                      <tr >
                        <!-- <td class="control">
                        </td> -->
                        <td>

                        </td>
                        <td>
                        </td>
                        <td>
                        </td>

                        <td></td>

                        <td></td>
                        <td></td>
                        <td> <button type="submit" class="btn btn-primary " id="submit">Save</button></td>

                    </tr>
                      </tfoot>
                    </table>

                  </div>
             </div>

          </div>
          </form>
          <!-- /Browser Default -->
          <!-- Bootstrap Validation -->

          <!-- /Bootstrap Validation -->
       </div>

    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>

<script>

    @if($errors->any())

        Swal.fire({
            title: "Error",
            text: "{{ implode(',', $errors->all(':message')) }}",
            icon: "warning"
        });
    @endif
    @if(Session::get('success'))

        Swal.fire({
            title: "Good job!",
            text: "{{Session::get('success')}}",
            icon: "success"
        });
    @endif

    @if(Session::get('error'))

        Swal.fire({
            title: "Error",
            text: "{{Session::get('error')}}",
            icon: "warning"
        });
    @endif

    $(function(){
        $(document.body).on('click','.edit',function(){
            var id=$(this).data('id');
            var head_name=$(this).data('head_name');
            var head_type=$(this).data('head_type');
            var status=$(this).data('status');
            var is_expanse=$(this).data('is_expanse');
            $('#id').val(id);
            $('#head_name').val(head_name);
            $('#head_type').val(head_type);
            $('#status').val(status);
            $('#is_expanse').val(is_expanse);
            $('#submit').text('Update');
        });


        $(document.body).on('click','.delete',function(){
            var id=$(this).data('id');
            var url=$(this).data('url');
            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}"},
                success: function(response){
                    if(response==1){
                        Swal.fire({
                            title: "Good job!",
                            text: "Deleted successfully",
                            icon: "success"
                        });
                        $('#row'+id).remove();
                    }else{
                        Swal.fire({
                            title: "Error!",
                            text: response,
                            icon: "warning"
                        });
                    }

                },
                error: function(data, errorThrown)
                {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });

                }
            });
        });
        $(document.body).on('click','#search',function(){
            var version_id=$('#version_id').val();
            var shift_id=$('#shift_id').val();
            var session_id=$('#session_id').val();
            var class_id=$('#class_id').val();
            var group_id=$('#group_id').val();
            var amount=$('#amount').val();
            var url='{{route("studentSearchByClass")}}';
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",version_id,shift_id,session_id,class_id,group_id,amount},
                success: function(response){
                  $.LoadingOverlay("hide");
                    $('#studentlist').html(response);
                },
                error: function(data, errorThrown)
                {
                  $.LoadingOverlay("hide");
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });

                }
            });
        });
    });
</script>
@endsection
