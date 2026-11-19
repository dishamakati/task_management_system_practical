
@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-9">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Task
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form id="editTaskForm"
                          action="{{ route('tasks.update', $task->id) }}"
                          method="POST"
                          novalidate>

                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                Task Title <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control"
                                   placeholder="Enter task title"
                                   value="{{ old('title', $task->title) }}">

                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      id="description"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Enter task description">{{ old('description', $task->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">
                                Assign Employee <span class="text-danger">*</span>
                            </label>

                            <select name="assigned_to"
                                    id="assigned_to"
                                    class="form-select">

                                <option value="">Select Employee</option>

                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ old('assigned_to', $task->assigned_to) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->email }})
                                    </option>
                                @endforeach

                            </select>

                            @error('assigned_to')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">
                                    Start Date
                                </label>

                                <input type="date"
                                       name="start_date"
                                       id="start_date"
                                       class="form-control"
                                       value="{{ old('start_date', $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') : '') }}">

                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="due_date" class="form-label">
                                    Due Date
                                </label>

                                <input type="date"
                                       name="due_date"
                                       id="due_date"
                                       class="form-control"
                                       value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">

                                @error('due_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">
                                Priority <span class="text-danger">*</span>
                            </label>

                            <select name="priority"
                                    id="priority"
                                    class="form-select">

                                <option value="">Select Priority</option>

                                @foreach([
                                    1 => 'Low',
                                    2 => 'Medium',
                                    3 => 'High',
                                    4 => 'Urgent'
                                ] as $value => $label)

                                    <option value="{{ $value }}"
                                        {{ old('priority', $task->priority) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                            @error('priority')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select name="status"
                                    id="status"
                                    class="form-select">

                                <option value="">Select Status</option>

                                @foreach([
                                    0 => 'Pending',
                                    1 => 'In Progress',
                                    2 => 'Completed',
                                    3 => 'Cancelled'
                                ] as $value => $label)

                                    <option value="{{ $value }}"
                                        {{ old('status', $task->status) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('tasks.index') }}"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Task
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

        // due date must be equal to or after start date
        $.validator.addMethod('greaterThanOrEqual', function (value, element, param) {

            let startDate = $(param).val();

            if (!value || !startDate) {
                return true;
            }

            return value >= startDate;

        });

        $('#editTaskForm').validate({

            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 191
                },

                description: {
                    maxlength: 2000
                },

                assigned_to: {
                    required: true
                },

                start_date: {
                    date: true
                },

                due_date: {
                    date: true,
                    greaterThanOrEqual: '#start_date'
                },

                priority: {
                    required: true,
                    digits: true,
                    range: [1, 4]
                },

                status: {
                    required: true,
                    digits: true,
                    range: [0, 3]
                }
            },

            messages: {
                title: {
                    required: 'Please enter task title.',
                    minlength: 'Task title must contain at least 3 characters.',
                    maxlength: 'Task title cannot exceed 191 characters.'
                },

                description: {
                    maxlength: 'Description cannot exceed 2000 characters.'
                },

                assigned_to: {
                    required: 'Please select an employee.'
                },

                start_date: {
                    date: 'Please enter a valid start date.'
                },

                due_date: {
                    date: 'Please enter a valid due date.',
                    greaterThanOrEqual: 'Due date must be after or equal to start date.'
                },

                priority: {
                    required: 'Please select task priority.',
                    digits: 'Please select a valid priority.',
                    range: 'Please select a valid priority.'
                },

                status: {
                    required: 'Please select task status.',
                    digits: 'Please select a valid status.',
                    range: 'Please select a valid status.'
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

        // revalidate dates
        $('#start_date').on('change', function () {
            $('#due_date').valid();
        });

    });
</script>
@endpush
