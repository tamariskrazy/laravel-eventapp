<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Etkinlik;
use App\Models\Duyurular;
use Illuminate\Support\Facades\Auth;

class EtkinlikController extends Controller
{
    public function index()
{
    $apiKey = env('TICKETMASTER_API_KEY');

    try {
        $response = Http::get('https://app.ticketmaster.com/discovery/v2/events.json', [
            'apikey' => $apiKey,
            'countryCode' => 'TR',
            'city' => 'Istanbul',
            'sort' => 'date,asc',
            'startDateTime' => now()->toIso8601String(),
        ]);
    } catch (\Exception $e) {
        return view('anasayfa')->withErrors('Etkinlik verisi alınamadı.');
    }

    if ($response->successful()) {
        \Log::info('Ticketmaster API Status', ['status' => $response->status()]);
        $etkinliklerApi = $response->json()['_embedded']['events'] ?? [];

        foreach ($etkinliklerApi as $apiEtkinlik) {
            // Tarihi MySQL uyumlu forma çevir
            $rawDate = $apiEtkinlik['dates']['start']['dateTime'] ?? null;
            $tarih = $rawDate ? date('Y-m-d H:i:s', strtotime($rawDate)) : null;

            // description bazen info olmayabilir, fallback yapabiliriz
            $description = $apiEtkinlik['info'] ?? ($apiEtkinlik['pleaseNote'] ?? null);

            Etkinlik::updateOrCreate(
                ['ticketmaster_id' => $apiEtkinlik['id']],
                [
                    'ticketmaster_id' => $apiEtkinlik['id'],
                    'etkinlik_adi' => $apiEtkinlik['name'] ?? 'İsimsiz Etkinlik',
                    'description' => $description,
                    'tarih' => $tarih,
                    'url' => $apiEtkinlik['url'] ?? null,
                    'kategori' => $apiEtkinlik['classifications'][0]['segment']['name'] ?? 'Genel',
                ]
            );
        }
    }

    $etkinlikler = Etkinlik::where('tarih', '>', now())
        ->orderBy('tarih')
        ->get();

    $havaDurumu = $this->getWeather('Istanbul');

    $etkinlikHavaDurumlari = [];
    foreach ($etkinlikler as $etkinlik) {
        $etkinlikHavaDurumlari[$etkinlik->id] = $this->getWeatherForDate('Istanbul', $etkinlik->tarih);
    }

    $onerilenEtkinlikler = collect();
    if (Auth::check()) {
        $ilgiler = Auth::user()->interests ?? [];
        $onerilenEtkinlikler = Etkinlik::whereIn('kategori', $ilgiler)->take(6)->get();
    }

    $duyurular = Duyurular::all();

    return view('anasayfa', compact('etkinlikler', 'havaDurumu', 'duyurular', 'etkinlikHavaDurumlari', 'onerilenEtkinlikler'));
}


    public function getWeather($city = 'Istanbul')
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
            'lang' => 'tr'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['weather'][0]['description'] . ", " . $data['main']['temp'] . "°C (Nem: " . $data['main']['humidity'] . "%)";
        } else {
            return 'Hava durumu bilgisi alınamadı';
        }
    }

    public function getWeatherForDate($city, $date)
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
            'lang' => 'tr'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $targetDate = date('Y-m-d', strtotime($date));

            foreach ($data['list'] as $weather) {
                if (strpos($weather['dt_txt'], $targetDate) === 0) {
                    return $weather['weather'][0]['main'];
                }
            }
        }

        return null;
    }
}
