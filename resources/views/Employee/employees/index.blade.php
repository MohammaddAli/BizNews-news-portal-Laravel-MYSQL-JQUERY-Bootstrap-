@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">Manage Employees</div>
        <div class="card-body">
            @can('CRUD employee')
                <a href="{{ route('employee.employees.create') }}" class="btn btn-success btn-sm my-2"><i
                        class="bi bi-plus-circle"></i> Add New
                    Employee</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @forelse ($employee->getRoleNames() as $role)
                                    <span class="badge bg-primary">{{ $role }}</span>
                                @empty
                                @endforelse
                            </td>
                            <td>
                                <form action="{{ route('employee.employees.destroy', $employee->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('employee.employees.show', $employee->id) }}"
                                        class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                    @if (in_array('Admin', $employee->getRoleNames()->toArray() ?? []))
                                        @if (Auth::guard('employee')->user()->hasRole('Admin'))
                                            <a href="{{ route('employee.employees.edit', $employee->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        @endif
                                    @else
                                        @can('CRUD employee')
                                            <a href="{{ route('employee.employees.edit', $employee->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        @endcan

                                        @can('CRUD employee')
                                            @if (Auth::guard('employee')->user()->id != $employee->id)
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Do you want to delete this employee?');"><i
                                                        class="bi bi-trash"></i> Delete</button>
                                            @endif
                                        @endcan
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="5">
                            <span class="text-danger">
                                <strong>No Employee Found!</strong>
                            </span>
                        </td>
                    @endforelse
                </tbody>
            </table>

            {{ $employees->links() }}

        </div>
    </div>

@endsection
