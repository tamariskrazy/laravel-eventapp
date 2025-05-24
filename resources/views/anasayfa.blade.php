<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventApp - Etkinlik Yönetim Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand-icon {
            font-size: 1.5rem;
            margin-right: 8px;
        }
        .menu-icon {
            font-size: 1.8rem;
            cursor: pointer;
        }
        .search-input {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-light">

    {{-- Üst Menü --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3 mb-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            
            {{-- Sol: Logo ve Başlık --}}
            <div class="d-flex align-items-center">
                <span class="navbar-brand-icon">🔷</span>
                <a class="navbar-brand fw-bold" href="#">EventApp</a>
            </div>

            {{-- Orta: Arama --}}
            <form class="d-flex flex-grow-1 justify-content-center mx-4" style="max-width: 600px;">
                <div class="input-group w-100">
                    <input type="text" class="form-control" placeholder="Etkinlik ara..." aria-label="Etkinlik ara">
                    <button class="btn btn-outline-secondary" type="submit">🔍</button>
                </div>
            </form>

            {{-- Sağ: Sepet ve Giriş --}}
            <div class="d-flex align-items-center gap-3">
                <a href="/sepet" class="text-dark fs-4 text-decoration-none" title="Sepet">🛒</a>

                <a href="{{ route('login.form') }}" class="btn btn-outline-primary btn-sm">Giriş Yap</a>
                <a href="{{ route('register.form') }}" class="btn btn-primary btn-sm">Kayıt Ol</a>

                <span class="menu-icon" title="Menü">&#9776;</span>
            </div>
        </div>
    </nav>

    {{-- Ana İçerik --}}
    <div class="container py-3">

        {{-- Hava Durumu ve Öneriler --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <h5 class="mb-2">🌤️ Hava Durumu</h5>
                    <p id="weather-info" class="mb-0 text-muted">Yükleniyor...</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <h5 class="mb-2">🎯 Önerilen Etkinlikler</h5>
                    <ul class="mb-0">
                        <li>Yazılım Atölyesi</li>
                        <li>Müzik Festivali</li>
                        <li>Startup Konferansı</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Etkinlikler --}}
        <div class="mb-5">
            <h3 class="mb-3">Yaklaşan Etkinlikler</h3>
            <div class="row">
                @forelse ($etkinlikler as $etkinlik)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $etkinlik->etkinlik_adi }}</h5>
                                <p class="card-text">{{ $etkinlik->description ?? 'Açıklama yok.' }}</p>
                                <p><strong>Tarih:</strong> {{ \Carbon\Carbon::parse($etkinlik->tarih)->format('d F Y') }}</p>
                                <a href="{{ route('etkinlik.detay', $etkinlik->id) }}" class="btn btn-primary mb-2">Detaylar</a>

                                {{-- Sepete Ekleme Formu --}}
                                <form method="POST" action="{{ route('sepet.ekle') }}">
                                    @csrf
                                    <input type="hidden" name="etkinlik_id" value="{{ $etkinlik->id }}">

                                    <div class="mb-2">
                                        <label for="bilet_turu_{{ $etkinlik->id }}">Bilet Türü:</label>
                                        <select id="bilet_turu_{{ $etkinlik->id }}" name="bilet_turu" class="form-select" required>
                                            <option value="normal">Normal</option>
                                            <option value="vip">VIP</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label for="adet_{{ $etkinlik->id }}">Adet:</label>
                                        <input id="adet_{{ $etkinlik->id }}" type="number" name="adet" value="1" min="1" class="form-control" required>
                                    </div>

                                    <input type="hidden" name="fiyat" value="100"> <!-- Dinamik fiyat için backend'e entegre edebilirsin -->

                                    <button type="submit" class="btn btn-success btn-sm">Sepete Ekle</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Henüz yaklaşan etkinlik bulunmamaktadır.</p>
                @endforelse
            </div>
        </div>

        {{-- Duyurular --}}
        <div class="mb-4">
            <h3 class="mb-3">📢 Duyurular</h3>
            <ul class="list-group">
                <li class="list-group-item">Kayıt onay süreci 1-2 iş günü sürebilir.</li>
                <li class="list-group-item">Hava durumuna göre bazı etkinlikler ertelenebilir.</li>
                <li class="list-group-item">Yeni etkinlikler her hafta eklenmektedir.</li>
            </ul>
        </div>
    </div>

    {{-- Hava Durumu Scripti --}}
    <script>
        fetch('https://api.openweathermap.org/data/2.5/weather?q=Istanbul&appid=SCRXK5FYYDBP5B7V7HM2&units=metric&lang=tr')
            .then(response => response.json())
            .then(data => {
                const temp = data.main.temp;
                const description = data.weather[0].description;
                document.getElementById('weather-info').innerText = `İstanbul'da şu an ${temp}°C, ${description}`;
            })
            .catch(() => {
                document.getElementById('weather-info').innerText = 'Hava durumu bilgisi alınamadı.';
            });
    </script>

</body>
</html>
