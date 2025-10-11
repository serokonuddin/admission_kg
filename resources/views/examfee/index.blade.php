@extends('admin.layouts.layout')
@section('content')
<style>
  input[readonly] {
    background-color: #f6f6f6!important;
}
</style>
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
          <span class="text-muted fw-light">Dashboard /</span> Exam Fee
       </h4>

          <div class="col-md mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Exam Fee List</h5>
                <div class="table-responsive text-nowrap fixed">
                   @if(Auth::user()->getMenu('examfee.store','name') || Auth::user()->group_id==2)
                   <form  method="post" action="{{route('examfee.store')}}"  novalidate="" id="formsubmit">
                    @csrf
                    <input type="hidden" value="2" name="head_id" />
                   <div class="row">
                                    <div class="row mb-3 col-md-4">
                                                        <label class="col-sm-3 col-form-label" for="basic-default-name">Session</label>
                                                        <div class="col-sm-9">
                                                        <select id="session_id" name="session_id" class=" form-select" required="">
                                                            @foreach($sessions as $session)
                                                            <option value="{{$session->id}}" >{{$session->session_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                    </div>
                                    <div class="row mb-3 col-md-2">

                                                        <div class="col-sm-12">
                                                        <button type="button" id="button" class="btn btn-primary form-control me-2">Search</button>
                                                        </div>
                                    </div>
                </div>
                    @else
                    <form class="needs-validation" method="post" action="#"  novalidate="" id="formsubmit">
                    @endif
                      <table class="table ">
                        <thead>
                          <tr class="table-info text-white">
                            <th>#</th>
                            <th>Class</th>
                            <th>Version</th>
                            <th>Fee</th>
                            <th>Effective From</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          @foreach($classes as $class)
                          <tr>
                            <td>
                              {{$loop->index+1}}
                              <input type="hidden" value="{{$class->class_code.'-'.$class->version_id}}" name="class_id[]" />
                              <input type="hidden" value="{{$emisdataid[$class->version_id.'-'.$class->class_code]??''}}" name="id{{$class->class_code.'-'.$class->version_id}}" />

                            </td>
                            <td>{{$class->class_name}}</td>
                            <td>{{$class->version_id==1?'Bangla':'English'}}</td>
                            <td><input type="number" name="amount{{$class->class_code.'-'.$class->version_id}}"  id="amount{{$class->class_code.'-'.$class->version_id}}" class="form-control" @if(isset($emisdata[$class->version_id.'-'.$class->class_code])) readonly="readonly" @endif value="{{$emisdata[$class->version_id.'-'.$class->class_code]??''}}" placeholder="Amount" /></td>
                            <td><input type="text" class="form-control flatpickr-validation flatpickr-input active" id="effective_from{{$class->class_code.'-'.$class->version_id}}" @if(isset($emisdatadate[$class->version_id.'-'.$class->class_code])) readonly="readonly" @endif name="effective_from{{$class->class_code.'-'.$class->version_id}}" value="{{$emisdatadate[$class->version_id.'-'.$class->class_code]??''}}" placeholder="Effective From" required></td>
                            <td><button type="button" class="btn btn-primary update" data-classid="{{$class->class_code.'-'.$class->version_id}}" ><i class="fa fa-edit"></i></button></td>
                          </tr>
                          @endforeach
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary" id="submit">Submit</button></td>
                          </tr>
                        </tbody>
                      </table>

                    </form>
                  </div>
             </div>
          </div>
          <!-- /Browser Default -->
          <!-- Bootstrap Validation -->


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
        $(document.body).on('click','.update',function(){
            var classid=$(this).data('classid');
            if($('#amount'+classid).prop("readonly") == true){
                $('#effective_from'+classid).prop('readonly', false);
                $('#amount'+classid).prop('readonly', false);
            }else{
                $('#effective_from'+classid).prop('readonly', true);
                $('#amount'+classid).prop('readonly', true);
            }
           // $('#effective_from'+classid).removeAttr('readonly',false);

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

    });
</script>
@endsection
