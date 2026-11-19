<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ActivityLogger;

class EmployeeController extends Controller
{
    /**
     * Display employees.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $employees = User::role('employee')
                ->select(['id', 'name', 'email', 'created_at']);

            return DataTables::of($employees)
                ->addIndexColumn()

                ->addColumn('action', function (User $employee) {

                    $editUrl = route('employees.edit', $employee->id);
                    $deleteUrl = route('employees.destroy', $employee->id);

                    return '
                        <div class="d-flex gap-2">

                            <a href="'.$editUrl.'"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="'.$deleteUrl.'"
                                  method="POST"
                                  onsubmit="return confirm(\'Are you sure you want to delete this employee?\')">

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

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('employees.index');
    }

    /**
     * Show employee creation form.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a new employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $employee = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $employee->assignRole('employee');

        //activity log
        ActivityLogger::log(
            'created',
            "Created employee: {$employee->name}",
            'Employee',
            $employee->id
        );

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Show employee edit form.
     */
    public function edit(User $employee)
    {
        $this->ensureEmployee($employee);

        return view('employees.edit', compact('employee'));
    }

    /**
     * Update employee details.
     */
    public function update(Request $request, User $employee)
    {
        $this->ensureEmployee($employee);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employee->id),
            ],

            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $employee->name = $validated['name'];
        $employee->email = $validated['email'];

        if (!empty($validated['password'])) {
            $employee->password = Hash::make($validated['password']);
        }

        $employee->save();

        //activiy log
        ActivityLogger::log(
            'updated',
            "Updated employee: {$employee->name}",
            'Employee',
            $employee->id
        );

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Delete employee.
     */
    public function destroy(User $employee)
    {
        $this->ensureEmployee($employee);

        //activity log
        ActivityLogger::log(
            'deleted',
            "Deleted employee: {$employee->name}",
            'Employee',
            $employee->id
        );

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * Ensure the selected user has employee role.
     */
    private function ensureEmployee(User $employee): void
    {
        abort_unless($employee->hasRole('employee'), 404);
    }
}
