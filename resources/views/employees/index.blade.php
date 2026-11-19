
@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h3>Employee Management</h3>

        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            Add Employee
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <table id="employeeTable" class="table table-bordered table-striped w-100">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
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

    $('#employeeTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('employees.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],

        pageLength: 10,

        lengthMenu: [10, 25, 50, 100],

        order: [[1, 'desc']]

    });

});
</script>
@endpush
