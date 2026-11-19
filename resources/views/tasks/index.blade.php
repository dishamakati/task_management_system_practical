
@extends('layouts.app')

@section('title', 'Task Management')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h3>Task Management</h3>

        @hasanyrole('admin|team_leader')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                Add New Task
            </a>
        @endhasanyrole
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <table id="taskTable"
                class="table table-bordered table-striped w-100">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Assigned By</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>

        </div>
    </div>
</div>
@endsection

@push('script')

<script>
$(document).ready(function () {

    $('#taskTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('tasks.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            { data: 'title', name: 'title' },
            { data: 'assigned_to', name: 'assigned_to', orderable: false },
            { data: 'assigned_by', name: 'assigned_by', orderable: false },
            { data: 'priority', name: 'priority' },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            { data: 'due_date', name: 'due_date' },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }
        ],

        pageLength: 10,
        lengthMenu: [10, 25, 50, 100]

    });

});
</script>

@endpush
