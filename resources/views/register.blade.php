<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol</title>
</head>
<body>
    <h2>Kayıt Ol</h2>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <label>İsim:</label>
        <input type="text" name="isim" required><br>
        <label>Soyisim:</label>
        <input type="text" name="soyisim" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Şifre:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Kayıt Ol</button>
    </form>
    <p><a href="{{ route('login.post') }}">Giriş Yap</a></p>
</body>
</html>
