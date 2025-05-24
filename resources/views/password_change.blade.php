<form method="POST" action="{{ route('password.change') }}">
    @csrf
    <label>Yeni Şifre:</label>
    <input type="password" name="new_password" required>

    <label>Yeni Şifre (Tekrar):</label>
    <input type="password" name="new_password_confirmation" required>

    <button type="submit">Şifreyi Değiştir</button>
</form>
