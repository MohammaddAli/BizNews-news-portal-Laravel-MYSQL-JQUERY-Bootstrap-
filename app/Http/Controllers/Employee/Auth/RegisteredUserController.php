<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('Employee.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Employee::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => 'required|file|image|mimes:jpeg,png,gif,webp,jpg',
        ]);
        // dd($request->all(), $request->file('image'));

        $imagePath = $request->file('image')->store('Emlpoyees/images', 'public');

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => "storage/$imagePath",
        ]);

        event(new Registered($employee));

        Auth::guard('employee')->login($employee);

        return redirect()->route('employee.dashboard');
        // return redirect(RouteServiceProvider::EMPLOYEE);
    }
}
