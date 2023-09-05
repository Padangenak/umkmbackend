<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => "required",
            'password' => "required",
        ]);
        $user = User::where('username', $request->username)->first();
        if ($user != null) {
            if($user->active == 'On'){
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();

                    return redirect()->intended(RouteServiceProvider::HOME);
                }else{
                    return back()->with('err', 'Username dan Password tidak ditemukan');
                }
            }else{
                return back()->with('err', 'Username ini dinonaktifkan');
            }
        }else{
                    return back()->with('err', 'Username dan Password tidak ditemukan');
            
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
