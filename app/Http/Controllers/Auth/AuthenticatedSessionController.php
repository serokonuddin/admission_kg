<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function isBangladeshiPhoneNumber($number) {
        // Remove spaces, dashes, and special characters
        $number = preg_replace('/[^0-9+]/', '', $number);
    
        // Regular expression to match Bangladeshi phone numbers
        $pattern = '/^(?:\+8801[3-9]\d{8}|8801[3-9]\d{8}|01[3-9]\d{8})$/';
    
        return preg_match($pattern, $number);
    }
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if($this->isBangladeshiPhoneNumber($request->email)){
            $login_type = 'username';
        }else{
			if(preg_match('/^\d{8}$/', $request->email) || preg_match('/^\d{6}$/', $request->email)){
				$login_type ='ref_id';
			}else{
				$login_type = filter_var($request->email, FILTER_VALIDATE_EMAIL)? 'email':'username';
			}
            
        }

        

        $credentials = [
            $login_type => $request->email,
            'password' => $request->password,
        ];


        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()
            ->with('login_error', 'Invalid credentials. Please try again.')
            ->withInput();
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
