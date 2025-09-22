@extends('admin.layouts.layout')
@section('content')


<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> User</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">User Information</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('users.store')}}" >

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">
                        <div class="mb-3 col-md-12">
		                    <label for="name" class="form-label">Name</label>
		                    <input value="{{ old('name') }}"
		                        type="text"
		                        class="form-control"
		                        name="name"
		                        placeholder="Name" value="{{(isset($user))?$user->name:''}}" required>

		                    @if ($errors->has('name'))
		                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
		                    @endif
		                </div>
		                <div class="mb-3 col-md-12">
		                    <label for="email" class="form-label">Email</label>
		                    <input value="{{ old('email') }}"
		                        type="email"
		                        class="form-control"
		                        name="email"
		                        placeholder="Email address" value="{{(isset($user))?$user->email:''}}" required>
		                    @if ($errors->has('email'))
		                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
		                    @endif
		                </div>
		                <div class="mb-3 col-md-12">
		                    <label for="phone" class="form-label">Phone</label>
		                    <input value="{{ old('phone') }}"
		                        type="text"
		                        class="form-control"
		                        name="phone"
		                        placeholder="phone" value="{{(isset($user))?$user->phone:''}}" required>
		                    @if ($errors->has('phone'))
		                        <span class="text-danger text-left">{{ $errors->first('phone') }}</span>
		                    @endif
		                </div>
		                <div class="mb-3 col-md-12">
		                    <label for="password" class="form-label">Password</label>
		                    <input value="{{ old('password') }}"
		                        type="text"
		                        class="form-control"
		                        name="password"
		                        placeholder="password" required>
		                    @if ($errors->has('password'))
		                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
		                    @endif
		                </div>
		                <div class="mb-3">
		                    <label for="group_id" class="form-label">Role</label>
		                    <select class="form-control"
		                        name="group_id" required>
		                        <option value="">Select role</option>
		                        @foreach($roles as $role)
		                            <option value="{{ $role->id }}"
		                                {{ in_array($role->name, $userRole)
		                                    ? 'selected'
		                                    : '' }}>{{ $role->name }}</option>
		                        @endforeach
		                    </select>
		                    @if ($errors->has('group_id'))
		                        <span class="text-danger text-left">{{ $errors->first('group_id') }}</span>
		                    @endif
		                </div>
		                <div class="mb-3 col-md-12 form-group gallery" id="photo_gallery">
                                <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                                <div class="input-group">

                                <input id="thumbnail" class="form-control" type="text" name="images" value="{{(isset($user))?$user->photo:''}}">
                                <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                </div>
                         </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('users.index')}}" class="btn btn-outline-secondary">Cancel</a>
                   </form>
                </div>
                <!-- /Account -->
             </div>

          </div>
       </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
 <script src="{{asset('public/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>


<script>
 $(function(){
   $('#lfm').filemanager('image');
});
</script>



@endsection
