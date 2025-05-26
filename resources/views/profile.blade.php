@extends('layouts.app')

@section('content')
<div class="container">
    <h2>İlgi Alanlarınızı Seçin</h2>
    
    <form method="POST" action="{{ route('profil.interests.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="interests">İlgi Alanları:</label><br>
            
            @php
                $tumu = ['Müzik', 'Spor', 'Teknoloji', 'Sanat', 'Sinema', 'Yemek', 'Tiyatro'];
                $secili = old('interests', auth()->user()->interests ?? []);
            @endphp

            @foreach ($tumu as $alan)
                <label>
                    <input type="checkbox" name="interests[]" value="{{ $alan }}"
                        {{ in_array($alan, $secili) ? 'checked' : '' }}>
                    {{ $alan }}
                </label><br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>

    <h2>Önerilen Etkinlikler</h2>

    @if ($etkinlikler->isEmpty())
        <p>İlgi alanlarınıza uygun etkinlik bulunamadı.</p>
    @else
        <ul class="list-group">
            @foreach ($etkinlikler as $etkinlik)
                <li class="list-group-item">
                    <strong>{{ $etkinlik->ad }}</strong> <br>
                    Kategori: {{ $etkinlik->kategori }} <br>
                    Açıklama: {{ $etkinlik->aciklama }} <br>
                    Tarih: {{ \Carbon\Carbon::parse($etkinlik->tarih)->format('d.m.Y H:i') }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
