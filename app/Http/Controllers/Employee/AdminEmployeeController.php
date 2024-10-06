<?php

namespace App\Http\Controllers\Employee;

use auth;
use App\Models\Employee;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;

class AdminEmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
        $this->middleware('permission:CRUD employee', ['only' => ['index','show']]);
        $this->middleware('permission:CRUD employee', ['only' => ['create','store']]);
        $this->middleware('permission:CRUD employee', ['only' => ['edit','update']]);
        $this->middleware('permission:CRUD employee', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('Employee.employees.index', [
            'employees' => Employee::latest('id')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Employee.employees.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $employee = Employee::create($input);
        $employee->assignRole($request->roles);

        return redirect()->route('employee.employees.index')
                ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee): View
    {
        return view('Employee.employees.show', [
            'user' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee): View
    {
        // Check Only Admin can update his own Profile
        if ($employee->hasRole('Admin')){
            if($employee->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('Employee.employees.edit', [
            'user' => $employee,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $employee->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, Employee $employee): RedirectResponse
    {
        $input = $request->all();

        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }

        $employee->update($input);

        $employee->syncRoles($request->roles);
        return redirect()->back()
                ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($employee->hasRole('Admin') || $employee->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $employee->syncRoles([]);
        $employee->delete();
        return redirect()->route('employee.employees.index')
                ->withSuccess('User is deleted successfully.');
    }
}
