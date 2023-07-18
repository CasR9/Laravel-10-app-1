<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Returns the view for the registration form.
     *
     * @return View
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Authenticates the user login.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function loginPost(Request $request): RedirectResponse
    {
        $request->validate([
           'email' => 'required|email',
           'password' => 'required'
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'You have successfully logged in');
        } else {

            return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);

        }
    }

    /**
     * Destroys the users current session.
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        Session::flush();
        Session::regenerate();
        return redirect()->route('login');
    }

    /**
     * Returns the view for the registration form.
     *
     * @return view
     */
    public function register(): View
    {
        return view('auth.register');
    }

    /**
     * registers a user inside the database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function registerPost(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $data['user_id'] = Str::uuid()->toString();
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = Hash::make($request->input('password'));

        $user = User::create([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if(!$user) {
            return redirect(route('register'))->with('error', 'Registration failed, try again');
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

//    /**
//     * Create a user inside the database users table.
//     *
//     * @param array $data
//     * @return array
//     */
//    public function create(array $data): array
//    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password'])
//        ]);
//    }

    /**
     * Returns the view for the dashboard when the user is authenticated.
     *
     * @return View
     */
    public function dashboard(): View
    {
        if(Auth::check()) {
            return view('auth.dashboard');
        }

        return view('auth.login')->with('error', 'You are not allowed to access');
    }
}
