<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtkinlikYönetimi;

class EtkinlikYönetimiController extends Controller
{
    public function index()
    {
        $etkinlikler = EtkinlikYönetimi::where('tarih', '>', now())->get();

        return view('anasayfa', compact('etkinlikler'));
    }
}
