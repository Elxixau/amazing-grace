<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{config('app.name') }}</title>

    

    <!-- FAVICON -->
    <link href="{{ asset('images/LOGO. REV2.png') }}" rel="shortcut icon" />
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card {
            width: 100%;
            max-width: 420px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4a148c;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .position-relative input {
            padding-right: 2.5rem;
        }

        .forgot {
            font-size: 14px;
            color: #4A148C;
            text-decoration: none;
        }
        .forgot:hover {
            color: #6b18d0;
        }

        .btn-primary {
            background-color: #4A148C;
            border-color: #4A148C;
        }

        .btn-primary:hover {
            background-color: #6b18d0;
            border-color: #6b18d0;
        }
    </style>
</head>
<body>

<div class="card p-3">
    @include('includes.notification')

    <div class="text-center mb-4">
        <img src="{{ asset('images/uNiv4bD.png') }}" width="170" class="mb-2">
        <h5 class="mb-0">Log In</h5>
        <small class="text-muted">Login dengan akun admin yang terdaftar, belum memiliki akun? hubungi panitia inti untuk mendapatkan akun</small>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <input type="email" name="email" class="form-control" required placeholder="Email : you@example.com">
        </div>

        <div class="mb-3 position-relative">
            <input id="password" type="password" name="password" class="form-control" required placeholder="Password">
            <i class="bi bi-eye-slash toggle-password" data-target="password"></i>
        </div>

        <div class="d-flex justify-content-end align-items-end mb-3">
           
            <a href="{{ route('password.request') }}" class="forgot">Lupa Password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100">Log In</button>
    </form>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function(toggleIcon) {
        toggleIcon.addEventListener('click', function () {
            const target = document.getElementById(this.dataset.target);
            const type = target.getAttribute('type') === 'password' ? 'text' : 'password';
            target.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    });
</script>
</body>
</html>
