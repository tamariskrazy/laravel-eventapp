<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EventApp - Etkinlik Yönetim Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            <div class="d-flex align-items-center">
                <span class="navbar-brand-icon">🔷</span>
                <a class="navbar-brand fw-bold" href="/">EventApp</a>
            </div>

            {{-- Arama --}}
            <form class="d-flex flex-grow-1 justify-content-center mx-4" style="max-width: 600px;" method="GET" action="{{ route('etkinlikler.arama') }}">
                <div class="input-group w-100">
                    <input type="text" name="q" class="form-control" placeholder="Etkinlik ara..." aria-label="Etkinlik ara" value="{{ request('q') }}" />
                    <button class="btn btn-outline-secondary" type="submit">🔍</button>
                </div>
            </form>

            {{-- Sağ Menü --}}
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('sepet') }}" class="text-dark fs-4 text-decoration-none" title="Sepet">🛒</a>

                @auth
                    <a href="{{ route('profilim') }}" class="btn btn-outline-secondary btn-sm">Profilim</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Çıkış Yap</button>
                    </form>
                @else
                    <a href="{{ route('login.form') }}" class="btn btn-outline-primary btn-sm">Giriş Yap</a>
                    <a href="{{ route('register.form') }}" class="btn btn-primary btn-sm">Kayıt Ol</a>
                @endauth

                <span class="menu-icon" title="Menü">&#9776;</span>
            </div>
        </div>
    </nav>

    <div class="container mt-5">

        {{-- 🌤 Hava Durumu --}}
        <div class="mb-4">
            <h3 class="mb-2">🌤 Güncel Hava Durumu</h3>
            @if ($havaDurumu)
                <div class="alert alert-info" id="weather-info">
                    {{ $havaDurumu }}
                </div>
            @else
                <div class="alert alert-danger">Hava durumu bilgisi alınamadı.</div>
            @endif
        </div>

        {{-- 🎫 Etkinlikler --}}
        <div class="mb-5">
            <h3 class="mb-3">🎫 Etkinlikler</h3>
            <div class="row">
                @forelse ($etkinlikler as $etkinlik)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $etkinlik->etkinlik_adi }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($etkinlik->description, 100) }}</p>
                                <p class="card-text"><strong>Tarih:</strong> {{ $etkinlik->tarih }}</p>
                                <p class="card-text"><strong>Fiyat:</strong> ₺{{ $etkinlik->fiyat }}</p>
                                <a href="{{ $etkinlik->url }}" target="_blank" class="btn btn-primary btn-sm mb-2">Etkinliği Gör</a>
                                <form action="{{ route('sepet.ekle', $etkinlik->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm w-100">Sepete Ekle</button>
                                </form>

                                {{-- Hava durumu uyarısı --}}
                                @php
                                    $havaDurumuEtkinlik = $etkinlikHavaDurumlari[$etkinlik->id] ?? null;
                                    $kotuHavaDurumlari = ['Rain', 'Thunderstorm', 'Snow', 'Drizzle', 'Mist', 'Fog'];
                                @endphp

                                @if ($havaDurumuEtkinlik && in_array($havaDurumuEtkinlik, $kotuHavaDurumlari))
                                    <div class="alert alert-warning mt-2">
                                        ⚠️ Bu etkinlik sırasında hava <strong>{{ $havaDurumuEtkinlik }}</strong> olabilir. Lütfen dikkatli olun.
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @empty
                    <p>Henüz etkinlik bulunmamaktadır.</p>
                @endforelse
            </div>
        </div>

        {{-- 👤 Kullanıcıya Özel Öneriler --}}
        @auth
            @if ($onerilenEtkinlikler->isNotEmpty())
                <div class="mb-5">
                    <h3 class="mb-3">👤 Sizin İçin Önerilen Etkinlikler</h3>
                    <div class="row">
                        @foreach ($onerilenEtkinlikler as $etkinlik)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-primary">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $etkinlik->etkinlik_adi }}</h5>
                                        <p class="card-text">{{ \Illuminate\Support\Str::limit($etkinlik->description, 100) }}</p>
                                        <p class="card-text"><strong>Kategori:</strong> {{ $etkinlik->kategori }}</p>
                                        <p class="card-text"><strong>Tarih:</strong> {{ $etkinlik->tarih }}</p>
                                        <a href="{{ $etkinlik->url }}" target="_blank" class="btn btn-outline-primary btn-sm mt-auto">Detaylar</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endauth

        {{-- 📢 Duyurular --}}
        <div class="mb-5">
            <h3 class="mb-3">📢 Duyurular</h3>
            <div class="list-group">
                @forelse ($duyurular as $duyuru)
                    <div class="list-group-item">
                        <h5 class="mb-1">{{ $duyuru->baslik }}</h5>
                        <p class="mb-1">{{ $duyuru->icerik }}</p>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($duyuru->tarih)->diffForHumans() }}
                        </small>
                    </div>
                @empty
                    <p>Henüz duyuru yok.</p>
                @endforelse
            </div>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
