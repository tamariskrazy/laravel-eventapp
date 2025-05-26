<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // Profil sayfasını gösterir
    public function index()
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }

    // İlgi alanlarını günceller
    public function updateInterests(Request $request)
    {
        $request->validate([
            'interests' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Gelen stringi diziye çevir (virgül ile ayrılmışsa)
        $interestsArray = [];
        if ($request->input('interests')) {
            $interestsArray = array_map('trim', explode(',', $request->input('interests')));
        }

        $user->interests = $interestsArray;
        $user->save();

        return redirect()->back()->with('success', 'İlgi alanlarınız güncellendi.');
    }
}
