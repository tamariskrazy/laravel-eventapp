<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function updateInterests(Request $request)
    {
        $request->validate([
            'interests' => 'nullable|array',
            'interests.*' => 'string|max:255',
        ]);

        $user = Auth::user();
        $user->interests = $request->input('interests', []);
        $user->save();

        return redirect()->back()->with('success', 'İlgi alanlarınız güncellendi.');
    }
}
