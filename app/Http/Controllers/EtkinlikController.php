<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Etkinlik;

class EtkinlikController extends Controller
{
    public function index()
    {
        // .env dosyasından API anahtarını çekiyoruz
        $token = env('SCRXK5FYYDBP5B7V7HM2');

        $response = Http::withToken($token)->get('https://www.eventbriteapi.com/v3/events/search/', [
            'q' => 'istanbul',
            'sort_by' => 'date',
        ]);

        // API yanıtından 'events' anahtarını alıyoruz
        $etkinliklerApi = $response->json()['events'] ?? [];

        foreach ($etkinliklerApi as $apiEtkinlik) {
            Etkinlik::updateOrCreate(
                ['eventbrite_id' => $apiEtkinlik['id']],
                [
                    'etkinlik_adi' => $apiEtkinlik['name']['text'] ?? 'İsimsiz Etkinlik',
                    'description' => $apiEtkinlik['description']['text'] ?? null,
                    'tarih' => $apiEtkinlik['start']['local'] ?? null,
                    'url' => $apiEtkinlik['url'] ?? null,
                ]
            );
        }

        $etkinlikler = Etkinlik::orderBy('tarih')->get();

        return view('anasayfa', ['etkinlikler' => $etkinlikler]);
    }
}
