@extends('layouts.admin')

@section('content')
    <h1>Yeni Duyuru Ekle</h1>

    {{-- Hata mesajları --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.duyurular.store') }}" method="POST">
        @csrf

        {{-- Başlık --}}
        <div class="mb-3">
            <label for="baslik" class="form-label">Başlık</label>
            <input type="text" class="form-control" id="baslik" name="baslik" value="{{ old('baslik') }}" required>
        </div>

        {{-- İçerik --}}
        <div class="mb-3">
            <label for="icerik" class="form-label">İçerik</label>
            <textarea class="form-control" id="icerik" name="icerik" rows="5" required>{{ old('icerik') }}</textarea>
        </div>

        {{-- Tarih --}}
        <div class="mb-3">
            <label for="tarih" class="form-label">Tarih</label>
            <input type="date" class="form-control" id="tarih" name="tarih" value="{{ old('tarih', date('Y-m-d')) }}" required>
        </div>

        {{-- Ekstra Bilgi (eğer düzenleme sayfasında kullanılacaksa) --}}
        @isset($duyuru)
            <small class="text-muted">
                {{ $duyuru->created_at ? $duyuru->created_at-
