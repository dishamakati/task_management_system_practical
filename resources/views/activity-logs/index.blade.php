
@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">
        <h3>Activity Logs</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <table id="activityTable"
                   class="table table-bordered table-striped w-100">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Activity</th>
                        <th>Description</th>
                        <th>Date & Time</th>
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

    $('#activityTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('activity-logs.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'user_name',
                name: 'user_name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'created_at',
                name: 'created_at'
            }
        ],

        pageLength: 10,
        lengthMenu: [10, 25, 50, 100]

    });

});
</script>

@endpush
