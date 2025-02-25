<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="login">Login</h1>
                <div class="input-box">
                    <x-text-input id="email" type="email" name="email" placeholder="Email" :value="old('email')" required autofocus autocomplete="username" />
                    <i class='bx bxs-envelope'></i>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="input-box">
                    <x-text-input id="password" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                    <i class='bx bxs-lock-alt'></i>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password</a>
                    @endif
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="register-link">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </form>
    </div>
    
</body>
</html>
