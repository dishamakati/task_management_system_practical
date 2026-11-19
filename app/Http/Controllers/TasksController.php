<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ActivityLogger;
use Spatie\Permission\Models\Role;

class TasksController extends Controller
{
    private function authorizeTask(Tasks $task): void
    {
        $user = Auth::user();

        abort_unless(
            $user->hasRole('admin') ||
            ($user->hasRole('team_leader') && $task->assigned_by == $user->id),
            403,
            'Unauthorized action.'
        );
    }

    private function taskQuery()
    {
        $user = Auth::user();

        $query = Tasks::with(['assignedBy', 'assignedTo']);

        if ($user->hasRole('team_leader')) {
            $query->where('assigned_by', $user->id);
        } elseif ($user->hasRole('employee')) {
            $query->where('assigned_to', $user->id);
        } elseif (!$user->hasRole('admin')) {
            abort(403);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $this->taskQuery();

        if (!$request->ajax()) {
            return view('tasks.index');
        }

        $statuses = [
            0 => 'Pending',
            1 => 'In Progress',
            2 => 'Completed',
            3 => 'Cancelled',
        ];

        $priorities = [
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
            4 => 'Urgent',
        ];

        return DataTables::of($query->select('tasks.*'))
            ->addIndexColumn()

            ->addColumn('assigned_to', fn($task) =>
                $task->assignedTo?->name ?? 'N/A'
            )

            ->addColumn('assigned_by', fn($task) =>
                $task->assignedBy?->name ?? 'N/A'
            )

            ->editColumn('priority', fn($task) =>
                $priorities[$task->priority] ?? 'N/A'
            )

            ->addColumn('status', function ($task) use ($user, $statuses) {

                if (!$user->hasRole('employee')) {
                    return $statuses[$task->status] ?? 'N/A';
                }

                $options = '';

                foreach ($statuses as $value => $label) {
                    $selected = $task->status == $value ? 'selected' : '';

                    $options .= "<option value=\"$value\" $selected>$label</option>";
                }

                return '
                    <form action="'.route('tasks.updateStatus', $task->id).'"
                          method="POST"
                          class="d-flex gap-1">

                        '.csrf_field().'
                        '.method_field('PATCH').'

                        <select name="status" class="form-select form-select-sm">
                            '.$options.'
                        </select>

                        <button type="submit" class="btn btn-success btn-sm">
                            Save
                        </button>
                    </form>
                ';
            })

            ->addColumn('action', function ($task) use ($user) {

                if ($user->hasRole('employee')) {
                    return '<span class="text-muted">No actions</span>';
                }

                return '
                    <div class="d-flex gap-2">

                        <a href="'.route('tasks.edit', $task->id).'"
                        class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="'.route('tasks.destroy', $task->id).'"
                            method="POST"
                            onsubmit="return confirm(\'Are you sure you want to delete this task?\')">

                            '.csrf_field().'
                            '.method_field('DELETE').'

                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>

                        </form>

                    </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $employees = User::role('employee')
            ->orderBy('name')
            ->get();

        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],

            'assigned_to' => [
                'required',
                Rule::exists('model_has_roles', 'model_id')
                    ->where('model_type', User::class)
                    ->whereIn(
                        'role_id',
                        Role::where('name', 'employee')
                            ->where('guard_name', 'web')
                            ->select('id')
                    ),
            ],

            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'priority' => ['required', 'in:1,2,3,4'],
        ]);

        $validated['assigned_by'] = Auth::id();
        $validated['status'] = 0;

        $task = Tasks::create($validated);

        ActivityLogger::log(
            'created',
            "Created task: {$task->title}",
            'Task',
            $task->id
        );

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Tasks $task)
    {
        $this->authorizeTask($task);

        $employees = User::role('employee')
            ->orderBy('name')
            ->get();

        return view('tasks.edit', compact('task', 'employees'));
    }

   
    public function update(Request $request, Tasks $task)
    {
        $this->authorizeTask($task);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],

            'assigned_to' => [
                'required',
                Rule::exists('model_has_roles', 'model_id')
                    ->where('model_type', User::class)
                    ->whereIn(
                        'role_id',
                        Role::where('name', 'employee')
                            ->where('guard_name', 'web')
                            ->select('id')
                    ),
            ],

            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'priority' => ['required', 'in:1,2,3,4'],
            'status' => ['required', 'in:0,1,2,3'],
        ]);

        $task->update($validated);

        ActivityLogger::log(
            'updated',
            "Updated task: {$task->title}",
            'Task',
            $task->id
        );

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }


    public function updateStatus(Request $request, Tasks $task)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:0,1,2,3'],
        ]);

        $user = Auth::user();

        abort_unless(
            $user->hasRole('admin') ||
            ($user->hasRole('employee') && $task->assigned_to == $user->id) ||
            ($user->hasRole('team_leader') && $task->assigned_by == $user->id),
            403,
            'You cannot update this task.'
        );

        $task->update([
            'status' => $request->status,
        ]);

        //activity log
        ActivityLogger::log(
            'status_updated',
            "Updated status of task: {$task->title}",
            'Task',
            $task->id,
            [
                'new_status' => $request->status,
            ]
        );

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task status updated successfully.');
    }

    public function destroy(Tasks $task)
    {
        $this->authorizeTask($task);

        //activity log
        ActivityLogger::log(
            'deleted',
            "Deleted task: {$task->title}",
            'Task',
            $task->id
        );

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
