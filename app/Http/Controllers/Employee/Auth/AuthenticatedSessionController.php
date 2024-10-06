<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Employee.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate('employee');

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::EMPLOYEE);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // dd('1');
        Auth::guard('employee')->logout();
        // dd('2');

        $request->session()->invalidate();
        // dd('3');

        $request->session()->regenerateToken();
        // dd('4');

        // return redirect()->route('employee.login');
        return redirect('/employee/login');
    }
}
