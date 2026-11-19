
@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Employee
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form id="editEmployeeForm"
                          action="{{ route('employees.update', $employee->id) }}"
                          method="POST"
                          novalidate>

                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="Enter employee name"
                                   value="{{ old('name', $employee->name) }}">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email Address <span class="text-danger">*</span>
                            </label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   placeholder="Enter email address"
                                   value="{{ old('email', $employee->email) }}">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3 text-muted">
                            Change Password (Optional)
                        </h6>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                New Password
                            </label>

                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="Enter new password">

                            <small class="text-muted">
                                Leave blank if you don't want to change the password.
                            </small>

                            @error('password')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                Confirm New Password
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm new password">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.index') }}"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Back
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Employee
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('script')

<script>
$(document).ready(function () {

    $('#editEmployeeForm').validate({

        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },

            email: {
                required: true,
                email: true,
                maxlength: 255
            },

            password: {
                minlength: 8
            },

            password_confirmation: {
                equalTo: '#password'
            }
        },

        messages: {
            name: {
                required: 'Please enter employee name.',
                minlength: 'Name must contain at least 3 characters.',
                maxlength: 'Name cannot exceed 255 characters.'
            },

            email: {
                required: 'Please enter email address.',
                email: 'Please enter a valid email address.',
                maxlength: 'Email cannot exceed 255 characters.'
            },

            password: {
                minlength: 'Password must be at least 8 characters.'
            },

            password_confirmation: {
                equalTo: 'Password confirmation does not match.'
            }
        },

        errorElement: 'small',

        errorClass: 'text-danger',

        highlight: function (element) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }

    });

});
</script>

@endpush
