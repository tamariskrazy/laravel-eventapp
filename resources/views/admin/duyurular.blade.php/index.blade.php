@extends('layouts.admin') {{-- Admin genel şablonu --}}

@section('content')
    <h1 class="mb-4">Duyurular</h1>

    {{-- Başarı mesajı --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Yeni duyuru ekleme butonu --}}
    <a href="{{ route('admin.duyurular.create') }}" class="btn btn-primary mb-3">+ Yeni Duyuru Ekle</a>

    {{-- Duyurular tablosu --}}
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Başlık</th>
                <th>İçerik</th>
                <th>Tarih</th>
                <th style="width: 150px;">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @forelse($duyurular as $duyuru)
                <tr>
                    <td>{{ $duyuru->baslik }}</td>
                    <td>{{ Str::limit($duyuru->icerik, 50) }}</td>
                    <td>{{ \Carbon\Carbon::parse($duyuru->tarih)->format('d.m.Y') }}</td>
                    <td>
                        <a href="{{ route('admin.duyurular.edit', $duyuru->id) }}" class="btn btn-sm btn-warning">Düzenle</a>

                        <form action="{{ route('admin.duyurular.destroy', $duyuru->id) }}" method="POST"
                              style="display:inline-block;" 
                              onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Hiç duyuru bulunamadı.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
