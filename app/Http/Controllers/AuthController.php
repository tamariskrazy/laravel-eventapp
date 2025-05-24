<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KullanıcıYönetimi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $kullanici = KullanıcıYönetimi::where('email', $request->email)->first();

        if ($kullanici && Hash::check($request->password, $kullanici->password)) {
            if (!$kullanici->is_approved) {
                return back()->with('error', 'Hesabınız henüz onaylanmadı.');
            }

            // Session verileri
            session([
                'kullanici_id' => $kullanici->id,
                'kullanici_isim' => $kullanici->isim,
                'kullanici_email' => $kullanici->email,
            ]);

            // Eğer şifresi daha önce değiştirilmemişse şifre değiştir sayfasına yönlendir
            if (!$kullanici->password_changed) {
                return redirect()->route('password.change');
            }

            return redirect()->route('anasayfa');
        }

        return back()->with('error', 'Geçersiz giriş bilgileri.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'isim' => 'required',
            'soyisim' => 'required',
            'email' => 'required|email|unique:kullanıcı_yönetimis,email',
            'password' => 'required|min:6'
        ]);

        $user = KullanıcıYönetimi::create([
            'isim' => $request->isim,
            'soyisim' => $request->soyisim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        $kullanici = KullanıcıYönetimi::find(session('kullanici_id'));
        $kullanici->password = Hash::make($request->new_password);
        $kullanici->password_changed = true;
        $kullanici->save();

        return redirect()->route('anasayfa')->with('success', 'Şifre başarıyla değiştirildi.');
    }

    public function logout()
    {
        session()->flush(); // Oturumu temizle
        return redirect()->route('login.form');
    }
}
