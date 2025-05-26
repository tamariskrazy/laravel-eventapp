<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 60px auto;
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
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            text-align: center;
        }
        p.text-center {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Giriş Yap</h2>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Giriş Yap</button>
        </form>

        <p class="text-center">
            Hesabın yok mu? <a href="{{ route('register.form') }}">Kayıt Ol</a>
        </p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
