<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
        }
        h2 {
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
            color: #343a40;
        }
        label {
            font-weight: 600;
        }
        .btn-primary {
            width: 100%;
        }
        p.text-center {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Kayıt Ol</h2>
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label for="isim" class="form-label">İsim:</label>
                <input type="text" class="form-control" id="isim" name="isim" required>
            </div>
            <div class="mb-3">
                <label for="soyisim" class="form-label">Soyisim:</label>
                <input type="text" class="form-control" id="soyisim" name="soyisim" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        </form>
        <p class="text-center">Zaten hesabın var mı? <a href="{{ route('login.form') }}">Giriş Yap</a></p>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
