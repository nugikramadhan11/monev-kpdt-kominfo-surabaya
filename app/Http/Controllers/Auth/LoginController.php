<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['nip' => $credentials['nip'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->hasRole('ASN')) {
                return redirect()->route('asn.dashboard');
            } elseif ($user->hasRole('PIMPINAN')) {
                return redirect()->route('pimpinan.dashboard');
            } elseif ($user->hasRole('ADMIN')) {
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors(['nip' => 'Login gagal.']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
