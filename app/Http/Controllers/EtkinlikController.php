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
        $token = env('EVENTBRITE_API_KEY');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('https://www.eventbriteapi.com/v3/events/search/', [
                'location.address' => 'Istanbul',
                'sort_by' => 'date',
                'start_date.range_start' => now()->toIso8601String(), // sadece ileri tarihli etkinlikler
            ]);
        } catch (\Exception $e) {
            return view('anasayfa')->withErrors('Etkinlik verisi alınamadı.');
        }

        if ($response->successful()) {
            $etkinliklerApi = $response->json()['events'] ?? [];

            foreach ($etkinliklerApi as $apiEtkinlik) {
                Etkinlik::updateOrCreate(
                    ['eventbrite_id' => $apiEtkinlik['id']],
                    [
                        'etkinlik_adi' => $apiEtkinlik['name']['text'] ?? 'İsimsiz Etkinlik',
                        'description' => $apiEtkinlik['description']['text'] ?? null,
                        'tarih' => $apiEtkinlik['start']['local'] ?? null,
                        'fiyat' => rand(0, 500),
                        'url' => $apiEtkinlik['url'] ?? null,
                    ]
                );
            }
        }

        $etkinlikler = Etkinlik::where('tarih', '>', now())
            ->orderBy('tarih')
            ->get();

        $havaDurumu = $this->getWeather('Istanbul'); // Genel hava durumu (istiyorsan kullanabilirsin)

        // Her etkinlik için tarih bazlı hava durumu bilgisi
        $etkinlikHavaDurumlari = [];
        foreach ($etkinlikler as $etkinlik) {
            $etkinlikHavaDurumlari[$etkinlik->id] = $this->getWeatherForDate('Istanbul', $etkinlik->tarih);
        }

         // Kullanıcıya özel öneri
        $onerilenEtkinlikler = collect();
        if (Auth::check()) {
            $ilgiler = Auth::user()->interests ?? [];
            $onerilenEtkinlikler = Etkinlik::whereIn('kategori', $ilgiler)->take(6)->get();
        }

        

        $duyurular = Duyurular::all();

        return view('anasayfa', compact('etkinlikler', 'havaDurumu', 'duyurular', 'etkinlikHavaDurumlari' , 'onerilenEtkinlikler'));
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
        // 5 günlük hava tahmin API'si
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
                    return $weather['weather'][0]['main']; // Örnek: 'Rain', 'Clear', 'Snow'
                }
            }
        }

        return null;
    }
    

    
}
