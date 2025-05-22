<!DOCTYPE html>
<html>
<head>
    <title>Giriş Yap</title>
</head>
<body>
    <h2>Giriş Yap</h2>
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Şifre:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Giriş Yap</button>
    </form>
    <p><a href="{{ route('register.post') }}">Kayıt Ol</a></p>
</body>
</html>
