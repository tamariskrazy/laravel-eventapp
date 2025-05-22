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

            session([
                'kullanici_id' => $kullanici->id,
                'kullanici_isim' => $kullanici->isim,
                'kullanici_email' => $kullanici->email,
            ]);

            // ✅ Burada ana sayfaya yönlendirme yapıyoruz
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
            'is_approved' => false
        ]);

        return redirect()->route('login.form')->with('success', 'Kayıt başarılı, onay bekleniyor.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
