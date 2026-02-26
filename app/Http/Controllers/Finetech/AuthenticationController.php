<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Support\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function create()
    {
        return view('finetech.authentication.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        Toastr::success('Login Success', 'Success');
        return redirect()->intended(route('finetech.dashboard', absolute: false));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
         Toastr::info('LogOut Success', );
        return redirect()->route('finetech.login');
    }
}