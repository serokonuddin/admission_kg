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
          <span class="text-muted fw-light">Dashboard /</span> Re Admission
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md-12 mt-2">
             <div class="card">
                <h5 class="card-header">Re Admission Entry</h5>
                <div class="card-body">
                    @if(Auth::user()->getMenu('readmission.store','name') || Auth::user()->group_id==2)
                   <form  method="post" action="{{route('readmission.store')}}"  novalidate="" id="formsubmit">
                    @csrf
                    @else
                    <form class="needs-validation" method="post" action="#"  novalidate="" id="formsubmit">
                    @endif
                    <div class="row">
                    <input type="hidden" name="id" id="id" value="0" />
                    <input type="hidden" name="session_id" id="session_id" value="{{$session->id}}" />
                      <div class="col-md-6 mb-3">
                         <label class="form-label" for="bs-name">Title</label>
                         <input type="text" class="form-control" name="title"  id="title" placeholder="Title" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter Title. </div>
                      </div>
                      <div class="col-md-6 mb-3">
                         <label class="form-label" for="bs-name">Duration</label>
                         <input type="text" class="form-control" name="duration"  id="duration" placeholder="duration" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter duration. </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label" for="bs-Active">Unit</label>
                        <select class="form-select" name="unit" id="unit" required="">
                          <option value="1">Day</option>
                          <option value="2">Percentage</option>
                          <option value="3">One Time</option>

                        </select>
                        <div class="valid-feedback"> Looks good! </div>
                        <div class="invalid-feedback"> Please select Unit </div>
                      </div>

                      <div class="mb-3 col-md-6">
                                 <label for="first_name" class="form-label">Unit Value</label>
                                 <input type="text" class="form-control" name="unit_value"  id="unit_value" placeholder="Unit Value" required="">
                        </div>
                      <div class="mb-3 col-md-6">
                                 <label for="first_name" class="form-label">Active</label>
                                 <select class="form-select" name="status" id="status" required="">
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>

                                </select>
                        </div>

                      <div class="row">
                         <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                         </div>
                      </div>
                      </div>
                   </form>
                </div>
             </div>
          </div>
          <!-- /Bootstrap Validation -->
       </div>
          <div class="col-md mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Re Admission List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap">
                          <th>#</th>
                          <th>Session</th>
                          <th>Title</th>
                          <th>Amount</th>
                          <th>Unit</th>
                          <th>Unit Amount</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach($readmissions as $key=>$readmission)
                        <tr id="row{{$readmission->id}}">
                          <th scope="row">{{$key+1}}</th>
                          <td>{{$readmission->session->session_name}}</td>
                          <td>
                          {{$readmission->title}}
                          </td>
                          <td>
                          {{$readmission->duration}}
                          </td>
                          <td>
                          @if($readmission->unit==1)
                            Day
                            @elseif($readmission->unit==2)
                            Percentage
                            @elseif($readmission->unit==3)
                            One Time
                            @endif
                          </td>
                          <td>
                          {{$readmission->unit_value}}
                          </td>
                          <td>
                            @if($readmission->status==1)
                            Active
                            @elseif($readmission->status==0)
                            Inactive
                            @endif
                          </td>
                          <td>
                           <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu" style="">
                                     @if(Auth::user()->getMenu('readmission.edit','name')  || Auth::user()->group_id==2)
                                    <a class="dropdown-item edit"
                                    data-id="{{$readmission->id}}"
                                    data-session_id="{{$readmission->session_id}}"
                                    data-title="{{$readmission->title}}"
                                    data-duration="{{$readmission->duration}}"
                                    data-unit="{{$readmission->unit}}"
                                    data-unit_value="{{$readmission->unit_value}}"
                                    data-status="{{$readmission->status}}"
                                    href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    @endif
                                     @if(Auth::user()->getMenu('readmission.destroy','name')  || Auth::user()->group_id==2)
                                    <a class="dropdown-item delete" data-url="{{route('fine.destroy', $readmission->id)}}" data-id="{{$readmission->id}}"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                    @endif
                                </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
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
        $(document.body).on('click','.edit',function(){
            var id=$(this).data('id');
            var title=$(this).data('title');
            var duration=$(this).data('duration');
            var status=$(this).data('status');
            var unit=$(this).data('unit');
            var unit_value=$(this).data('unit_value');
            $('#id').val(id);
            $('#title').val(title);
            $('#duration').val(duration);
            $('#status').val(status);
            $('#unit_value').val(unit_value);
            $('#unit').val(unit);
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
