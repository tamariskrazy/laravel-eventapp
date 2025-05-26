<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KullaniciYonetimi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_approved) {
                Auth::logout();
                return back()->withErrors(['error' => 'Hesabınız henüz onaylanmadı.']);
            }

            if (!$user->password_changed) {
                return redirect()->route('password.change.form');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('anasayfa'));
        }

        return back()->withErrors(['error' => 'Geçersiz giriş bilgileri.']);
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'isim' => 'required|string|max:255',
            'soyisim' => 'required|string|max:255',
            'email' => 'required|email|unique:kullanici_yonetimis,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = KullaniciYonetimi::create([
            'isim' => $data['isim'],
            'soyisim' => $data['soyisim'],
            'email' => $data['email'],
            'password' => $data['password'], // setPasswordAttribute çalışacak
            'is_approved' => false,
            'password_changed' => false,
        ]);

        return redirect()->route('login.form')->with('success', 'Kayıt başarılı, onay bekleniyor.');
    }

    public function showChangePasswordForm()
    {
        return view('password_change');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = $data['new_password']; // setPasswordAttribute çalışacak
        $user->password_changed = true;
        $user->save();

        return redirect()->route('anasayfa')->with('success', 'Şifre başarıyla değiştirildi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
