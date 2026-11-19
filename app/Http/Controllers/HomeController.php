<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tasks;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $tasksQuery = Tasks::query();

        // Apply role-based task filtering
        if ($user->hasRole('team_leader')) {

            $tasksQuery->where('assigned_by', $user->id);

        } elseif ($user->hasRole('employee')) {

            $tasksQuery->where('assigned_to', $user->id);

        } elseif (!$user->hasRole('admin')) {

            abort(403, 'Unauthorized access.');
        }

        // Dashboard statistics
        $totalEmployees = User::role('employee')->count();

        $totalTasks = (clone $tasksQuery)->count();

        $completedTasks = (clone $tasksQuery)->where('status', 2)->count();

        $pendingTasks = (clone $tasksQuery)->where('status', 0)->count();

        $highPriorityTasks = (clone $tasksQuery)->whereIn('priority', [3, 4])->count();

        return view('home', compact(
            'totalEmployees',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'highPriorityTasks'
        ));
    }
}
