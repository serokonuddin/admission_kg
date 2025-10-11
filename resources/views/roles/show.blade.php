@extends('admin.layouts.layout')
@section('content')
<style>
    .control {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        position: relative;
        cursor: pointer;
    }
    th.control:before,td.control:before {
        background-color: #696cff;
        border: 2px solid #fff;
        box-shadow: 0 0 3px rgba(67,89,113,.8);
    }
    td.control:before, th.control:before {
        top: 50%;
        left: 50%;
        height: 0.8em;
        width: 0.8em;
        margin-top: -0.5em;
        margin-left: -0.5em;
        display: block;
        position: absolute;
        color: black;
        border: 0.15em solid white;
        border-radius: 1em;
        box-shadow: 0 0 0.2em #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: "Courier New",Courier,monospace;
        line-height: 1em;
        content: "+";
        background-color: #0d6efd;
    }
    .table-dark {
        background-color: #1c4d7c!important;
        color: #fff!important;
        font-weight: bold;
    }
    .table-dark {
        --bs-table-bg: #1c4d7c!important;
        --bs-table-striped-bg: #1c4d7c!important;
        --bs-table-striped-color: #fff!important;
        --bs-table-active-bg: #1c4d7c!important;
        --bs-table-active-color: #fff!important;
        --bs-table-hover-bg: #1c4d7c!important;
        --bs-table-hover-color: #fff!important;
        color: #fff!important;
        border-color: #1c4d7c!important;
    }
    .table:not(.table-dark) th {
        color: black;
        font-weight: bold;
    }
    .form-label{
      width: 100%!important;
    }
</style>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Assigned permissions</h4>
       <!-- Basic Bootstrap Table -->
       <div class="card">
         <h1>{{ ucfirst($role->name) }} Role</h1>
         </div>
          <div class="table-responsive ">
             <table class="table table-striped">
                <thead>
                    <th scope="col" width="20%">Name</th>
                    <th scope="col" width="1%">Guard</th>
                </thead>

                @foreach($rolePermissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                    </tr>
                @endforeach
            </table>

          </div>
          <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate" style="padding: 10px">
            <div class="mt-4">
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
                <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
            </div>
          </div>
       </div>

    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script type="text/javascript">
$(function(){
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
