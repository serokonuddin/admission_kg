@extends('frontend-new.layout')
@section('content')

<!-- Display Messages -->
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Password Reset Form -->
<div class="modal-dialog modal-sm" role="document">
      <div class="modal-content shadow-lg" style="background: linear-gradient(45deg, #ff512f, #dd2476); border-radius: 15px;">
        <div class="app-brand justify-content-center mt-4 text-center" style="font-family: math">
          <h4 class="mb-3 text-center" style="color: #F0C24B; font-weight: bold">Set New Password</h4>
        </div>
        <div class="p-4">
          <form action="{{ route('password.reset.custom') }}" method="POST">
            @csrf
            <!-- New Password Input -->
            <div class="form-group mb-3">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
              </div>
            </div>
            
            <!-- Confirm Password Input -->
            <div class="form-group mb-3">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm Password" required>
              </div>
            </div>
  
            <!-- Submit Button -->
            <div class="form-group">
              <button type="submit" class="btn btn-danger w-100 py-2 text-uppercase text-white" style="border-radius: 30px;">
                <span style="color: rgba(240, 194, 75, 1)">Reset Password</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  
  @endsection
  