<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;


class AuthController extends Controller
{
     public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard'); // ganti sesuai tujuan
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Create the User
    public function register(Request $request){
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'divisi' => 'required|in:pubdok,acara,inti,perlengkapan,humas',
            'password' => 'required',
        ]);

        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'divisi' => $request->divisi,
            'password' => bcrypt($request->password), // Hash the password
        ]);



         return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function showReset(){
        return view ('auth.reset.index');
    }

        
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        //return $status === Password::RESET_LINK_SENT
        //    ? back()->with('status', __($status))
        //    : back()->withErrors(['email' => __($status)]);

            
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Email reset password terkirim, cek email anda atau folder SPAM.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showNewPasswordForm($token)
    {
        return view('auth.reset.password-form', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                // Optionally: Auth::login($user);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout');
    }


}
