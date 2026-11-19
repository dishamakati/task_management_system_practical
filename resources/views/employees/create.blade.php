
@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h4 class="mb-1 fw-bold">
                        <i class="fas fa-user-plus text-primary me-2"></i>
                        Add New Employee
                    </h4>
                    <p class="text-muted mb-0 small">
                        Enter employee details to create a new account.
                    </p>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('employees.store') }}"
                          method="POST"
                          id="employeeForm"
                          novalidate>

                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Employee Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="Enter employee name"
                                   value="{{ old('name') }}">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   placeholder="example@gmail.com"
                                   value="{{ old('email') }}">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>

                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="Enter password">

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Confirm Password <span class="text-danger">*</span>
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm password">
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('employees.index') }}"
                               class="btn btn-light border">
                                <i class="fas fa-arrow-left me-1"></i>
                                Back
                            </a>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i>
                                Save Employee
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

    $('#employeeForm').validate({

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
                required: true,
                minlength: 8
            },

            password_confirmation: {
                required: true,
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
                required: 'Please enter password.',
                minlength: 'Password must contain at least 8 characters.'
            },

            password_confirmation: {
                required: 'Please confirm your password.',
                equalTo: 'Passwords do not match.'
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
            error.addClass('d-block mt-1');
            error.insertAfter(element);
        },

        submitHandler: function (form) {
            form.submit();
        }

    });

});
</script>

@endpush
