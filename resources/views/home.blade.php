
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-5">

    <div class="mb-4">
        <h3 class="fw-bold text-dark">Task Management Dashboard</h3>
        <p class="text-muted">Overview of employees and task activities</p>
    </div>

    <div class="row g-4">

        {{-- Total Employees --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary bg-opacity-10 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary fw-semibold">Total Employees</h6>
                            <h2 class="fw-bold text-primary mb-1">
                                {{ $totalEmployees }}
                            </h2>
                            <small class="text-muted">Registered employees</small>
                        </div>
                        <div class="bg-primary bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-users fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Tasks --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-info bg-opacity-10 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary fw-semibold">Total Tasks</h6>
                            <h2 class="fw-bold text-info mb-1">
                                {{ $totalTasks }}
                            </h2>
                            <small class="text-muted">All assigned tasks</small>
                        </div>
                        <div class="bg-info bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-tasks fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed Tasks --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success bg-opacity-10 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary fw-semibold">Completed Tasks</h6>
                            <h2 class="fw-bold text-success mb-1">
                                {{ $completedTasks }}
                            </h2>
                            <small class="text-muted">Successfully completed</small>
                        </div>
                        <div class="bg-success bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-check-circle fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Tasks --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning bg-opacity-10 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary fw-semibold">Pending Tasks</h6>
                            <h2 class="fw-bold text-warning mb-1">
                                {{ $pendingTasks }}
                            </h2>
                            <small class="text-muted">Tasks waiting to start</small>
                        </div>
                        <div class="bg-warning bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-clock fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- High Priority Tasks --}}
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-danger bg-opacity-10 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-secondary fw-semibold">High Priority Tasks</h6>
                            <h2 class="fw-bold text-danger mb-1">
                                {{ $highPriorityTasks }}
                            </h2>
                            <small class="text-muted">High and urgent priority</small>
                        </div>
                        <div class="bg-danger bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-exclamation-triangle fs-3 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
