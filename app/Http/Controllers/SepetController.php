<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Etkinlik;
use Illuminate\Support\Facades\Auth;

class SepetController extends Controller
{
    // Sepeti göster (Sepet sayfası)
    public function index()
    {
        $sepet = Session::get('sepet', []);
        return view('sepet', compact('sepet'));
    }

    // Ürün silme (Sepetten kaldır)
    public function sil($key)
    {
        $sepet = Session::get('sepet', []);
        if (isset($sepet[$key])) {
            unset($sepet[$key]);
            Session::put('sepet', $sepet);
            return redirect()->route('sepet')->with('success', 'Ürün sepetten silindi.');
        }
        return redirect()->route('sepet')->with('error', 'Ürün sepette bulunamadı.');
    }

    // Adet güncelleme
    public function guncelle(Request $request, $key)
    {
        $request->validate([
            'adet' => 'required|integer|min:1'
        ]);

        $sepet = Session::get('sepet', []);
        if (isset($sepet[$key])) {
            $sepet[$key]['adet'] = $request->adet;
            Session::put('sepet', $sepet);
            return redirect()->route('sepet')->with('success', 'Adet güncellendi.');
        }
        return redirect()->route('sepet')->with('error', 'Ürün sepette bulunamadı.');
    }

    // Sepete ürün ekleme
    public function ekle(Request $request)
    {
        $request->validate([
            'etkinlik_id' => 'required|exists:etkinlikler,id',
            'adet' => 'required|integer|min:1',
            'bilet_turu' => 'required|string',
            'fiyat' => 'required|numeric|min:0',
        ]);

        $cart = session()->get('sepet', []);

        // Anahtar olarak etkinlik_id + bilet_turu birleşimi kullanılıyor
        $key = $request->etkinlik_id . '_' . $request->bilet_turu;

        if (isset($cart[$key])) {
            $cart[$key]['adet'] += $request->adet;
        } else {
            $cart[$key] = [
                'etkinlik_id' => $request->etkinlik_id,
                'bilet_turu' => $request->bilet_turu,
                'adet' => $request->adet,
                'fiyat' => $request->fiyat,
            ];
        }

        session(['sepet' => $cart]);

        return redirect()->route('sepet')->with('success', 'Sepete eklendi.');
    }
}
