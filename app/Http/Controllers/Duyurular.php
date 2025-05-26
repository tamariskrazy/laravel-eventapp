<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Duyurular;

class DuyurularController extends Controller
{
    public function index()
    {
        $duyurular = Duyurular::orderBy('tarih', 'desc')->get();
        return view('admin.duyurular.index', compact('duyurular'));
    }

    public function create()
    {
        return view('admin.duyurular.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
            'tarih'  => 'required|date',
        ]);

        Duyurular::create($request->only('baslik', 'icerik', 'tarih'));

        return redirect()->route('admin.duyurular.index')->with('success', 'Duyuru başarıyla eklendi.');
    }

    public function edit($id)
    {
        $duyuru = Duyurular::findOrFail($id);
        return view('admin.duyurular.edit', compact('duyuru'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
            'tarih'  => 'required|date',
        ]);

        $duyurular = Duyurular::findOrFail($id);
        $duyurular->update($request->only('baslik', 'icerik', 'tarih'));

        return redirect()->route('admin.duyurular.index')->with('success', 'Duyuru başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $duyurular = Duyurular::findOrFail($id);
        $duyurular->delete();

        return redirect()->route('admin.duyurular.index')->with('success', 'Duyuru başarıyla silindi.');
    }
}
