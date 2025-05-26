@extends('layouts.admin')

@section('content')
    <h1>Duyuru Düzenle</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.duyurular.update', $duyuru->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="baslik" class="form-label">Başlık</label>
            <input type="text" class="form-control" id="baslik" name="baslik" 
                   value="{{ old('baslik', $duyuru->baslik) }}" required>
        </div>

        <div class="mb-3">
            <label for="icerik" class="form-label">İçerik</label>
            <textarea class="form-control" id="icerik" name="icerik" rows="5" required>{{ old('icerik', $duyuru->icerik) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tarih" class="form-label">Tarih</label>
            <input type="date" class="form-control" id="tarih" name="tarih" 
                   value="{{ old('tarih', \Carbon\Carbon::parse($duyuru->tarih)->format('Y-m-d')) }}" required>
        </div>

        <small class="text-muted">
            Oluşturulma: {{ $duyuru->created_at ? $duyuru->created_at->diffForHumans() : 'Tarih yok' }}
        </small>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('admin.duyurular.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
@endsection
