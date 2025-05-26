@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Profilim</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <p><strong>İsim:</strong> {{ $user->name ?? $user->isim ?? 'İsim yok' }}</p>
        <p><strong>E-posta:</strong> {{ $user->email }}</p>

        <form action="{{ route('profil.interests.update') }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')

            <label for="interests" class="block font-medium mb-2">İlgi Alanları (virgül ile ayırarak giriniz):</label>
            <input 
                type="text" 
                id="interests" 
                name="interests" 
                class="border rounded px-3 py-2 w-full" 
                value="{{ old('interests', is_array($user->interests) ? implode(', ', $user->interests) : '') }}"
            >

            @error('interests')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Güncelle</button>
        </form>
    </div>
@endsection
