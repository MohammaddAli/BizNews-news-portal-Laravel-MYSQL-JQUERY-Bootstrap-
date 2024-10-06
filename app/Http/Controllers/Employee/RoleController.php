<?php

namespace App\Http\Controllers\Employee;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Employee;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('employee');
        $this->middleware('auth:employee');
        $this->middleware('permission:role-create|role-edit|role-delete', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('Employee.roles.index', [
            'roles' => Role::orderBy('id','DESC')->paginate(3)
        ]);
    }

    public function create()
    {
        return view('Employee.roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('Employee.roles.index')
                ->withSuccess('New role is added successfully.');
    }

    public function show(Role $role): View
    {
        $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
            ->where("role_id",$role->id)
            ->select('name')
            ->get();
        return view('Employee.roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function edit(Role $role)
    {
        if($role->name=='Admin'){
            abort(403, 'ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();

        return view('Employee.roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->back()
                ->withSuccess('Role is updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if($role->name=='Admin'){
            abort(403, 'ADMIN ROLE CAN NOT BE DELETED');
        }

        // $user = Auth::user();
        // /** @var \App\Models\User */
        // $employee = auth('employee')->user();
        $employee = Auth::guard('employee')->user();
        if($employee->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('Employee.roles.index')
                ->withSuccess('Role is deleted successfully.');
    }
}

// public function destroy(Role $role): RedirectResponse
//     {
//         // Use the 'employee' guard
//         $employee = auth('employee')->user();

//         if ($employee) {
//             if ($role->name == 'Admin') {
//                 abort(403, 'ADMIN ROLE CANNOT BE DELETED');
//             }
//             if ($employee->hasRole($role->name)) {
//                 abort(403, 'CANNOT DELETE SELF ASSIGNED ROLE');
//             }

//             $role->delete();

//             return redirect()->route('Employee.roles.index')
//                              ->with('success', 'Role is deleted successfully.');
//         }

//         abort(403, 'Unauthorized action.');
//     }
// }
