@extends('frontend-new.layout')
@section('content')
    <!-- Display Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display Error Message -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .text-muted{
            color: white!important;
        }
    </style>

    <!-- Password Reset Form -->
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content shadow-lg"
            style="background: linear-gradient(45deg, #ff512f, #dd2476); border-radius: 15px;">
            <div class="app-brand justify-content-center mt-4 text-center" style="font-family: math">
                <h4 class="mb-3 text-center" style="color: #F0C24B; font-weight: bold">Set New Password</h4>
            </div>
            <div class="p-4">
                <form id="changePasswordForm" action="{{ route('change.password') }}" method="POST">
                    @csrf
                    <!-- Current Password Input -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text toggle-password">
                                <i class="fas fa-lock text-primary"></i>
                            </span>
                            <input type="password" name="current_password" class="form-control password-field"
                                placeholder="Current Password" required>
                        </div>
                    </div>

                    <!-- New Password Input -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text toggle-password">
                                <i class="fas fa-lock text-primary"></i>
                            </span>
                            <input type="password" name="new_password" id="new_password" class="form-control password-field" placeholder="New Password"
                                required>
                            <small id="passwordHelp" class="form-text text-muted text-danger"></small>
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text toggle-password">
                                <i class="fas fa-lock text-primary "></i>
                            </span>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control password-field"
                                placeholder="Confirm Password" required>
                            <small id="confirmHelp" class="form-text text-muted text-danger"></small>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger w-100 py-2 text-uppercase text-white"
                            style="border-radius: 30px;">
                            <span style="color: rgba(240, 194, 75, 1)">Change Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            function validatePassword(password) {
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
                return regex.test(password);
            }
            $(document).on('click', '.toggle-password', function () {
                const input = $(this).closest('.input-group').find('.password-field');
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-lock').addClass('fa-unlock');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-unlock').addClass('fa-lock');
                }
            });
            $('#new_password').on('keyup change', function () {
                const password = $(this).val();
                if (!validatePassword(password)) {
                    $('#passwordHelp').text('❌ Must include upper, lower, number, symbol, and be at least 8 characters.');
                } else {
                    $('#passwordHelp').text('✅ Strong password.').removeClass('text-danger').addClass('text-success');
                }
            });

            $('#new_password_confirmation').on('keyup change', function () {
                const password = $('#password').val();
                const confirm = $(this).val();
                if (password !== confirm) {
                    $('#confirmHelp').text("❌ Passwords don't match.");
                } else {
                    $('#confirmHelp').text("✅ Passwords match.").removeClass('text-danger').addClass('text-success');
                }
            });
        });
        </script>
@endsection
