@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <p>This is your application dashboard.</p>
                        @canany(['create-role', 'edit-role', 'delete-role'])
                            <a class="btn btn-primary" href="{{ route('employee.roles.index') }}">
                                <i class="bi bi-person-fill-gear"></i> Manage Roles</a>
                        @endcanany
                        @canany(['create-user', 'edit-user', 'delete-user'])
                            <a class="btn btn-success" href="{{ route('employee.employees.index') }}">
                                <i class="bi bi-people"></i> Manage Employees</a>
                        @endcanany
                        @canany(['create-product', 'edit-product', 'delete-product'])
                            <a class="btn btn-warning" href="{{ route('employee.articles.index') }}">
                                <i class="bi bi-bag"></i> Manage Articles</a>
                        @endcanany
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
