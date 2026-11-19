
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('home');

    Route::middleware(['role:admin|team_leader|employee'])->group(function () {

        Route::get('/tasks', [TasksController::class, 'index'])
            ->name('tasks.index');

        Route::patch('/tasks/{task}/status', [TasksController::class, 'updateStatus'])
            ->name('tasks.updateStatus');

    });

    Route::middleware(['role:admin|team_leader'])->group(function () {

        // Tasks
        Route::resource('tasks', TasksController::class)
            ->except(['index']);

        //Employees management
        Route::resource('employees', EmployeeController::class);

    });

    //Activity logs - admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');
    });

});
