@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sepetiniz</h2>

    @if(session('sepet') && count(session('sepet')) > 0)
        <form action="{{ route('sepet.guncelle') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Etkinlik Adı</th>
                        <th>Tarih</th>
                        <th>Bilet Türü</th>
                        <th>Adet</th>
                        <th>Fiyat (Birim)</th>
                        <th>Ara Toplam</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    @php $toplam = 0; @endphp
                    @foreach(session('sepet') as $index => $item)
                        <tr>
                            <td>{{ $item['etkinlik_adi'] }}</td>
                            <td>{{ $item['tarih'] }}</td>
                            <td>{{ $item['bilet_turu'] }}</td>
                            <td>
                                <input type="number" name="adet[{{ $index }}]" value="{{ $item['adet'] }}" min="1" class="form-control" style="width: 70px;">
                            </td>
                            <td>{{ $item['fiyat'] }} TL</td>
                            <td>{{ $item['fiyat'] * $item['adet'] }} TL</td>
                            <td>
                                <form action="{{ route('sepet.sil', $index) }}" method="POST" onsubmit="return confirm('Bu ürünü sepetten silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Sil</button>
                                </form>
                            </td>
                        </tr>
                        @php $toplam += $item['fiyat'] * $item['adet']; @endphp
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Adetleri Güncelle</button>
        </form>

        <div class="mt-3">
            <h4>Toplam Tutar: {{ $toplam }} TL</h4>

            <form action="{{ route('odeme.yap') }}" method="POST">
                @csrf
                <label for="odeme_yontemi">Ödeme Yöntemi:</label>
                <select name="odeme_yontemi" id="odeme_yontemi" class="form-control mb-3" required>
                    <option value="">Seçiniz</option>
                    <option value="kredi_karti">Kredi Kartı</option>
                    <option value="havale">Havale / EFT</option>
                    <option value="kapida_odeme">Kapıda Ödeme</option>
                </select>

                <button type="submit" class="btn btn-primary">Satın Al</button>
            </form>
        </div>
    @else
        <p>Sepetiniz boş.</p>
    @endif
</div>
@endsection
