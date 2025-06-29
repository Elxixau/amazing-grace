<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | {{config('app.name') }}</title>
    

    <!-- FAVICON -->
    <link href="{{ asset('images/LOGO. REV2.png') }}" rel="shortcut icon" />
    @include('includes.script')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .card {
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }

        .position-relative input {
            padding-right: 2.5rem;
        }

        .form-label {
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .btn-primary {
             color: #fff; background-color: #4A148C; border-color: #4A148C;
        }
        .btn-primary:hover {
            background-color: #6b18d0;
            border-color: #6b18d0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h4 class="mb-4 text-center">Reset Password</h4>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password Baru</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                <i class="bi bi-eye-slash toggle-password" data-target="password"></i>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 position-relative">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control" required>
                <i class="bi bi-eye-slash toggle-password" data-target="password_confirmation"></i>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Reset Password</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(toggleIcon) {
            toggleIcon.addEventListener('click', function () {
                const inputId = this.getAttribute('data-target');
                const input = document.getElementById(inputId);
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>
