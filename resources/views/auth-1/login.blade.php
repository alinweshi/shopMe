<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="guest-layout">
        <div id="session-status" class="mb-4"></div>

        <form method="POST" action="{{ request()->is('admin/*') ? route('admin.login') : route('login') }}">
            @csrf
            @method('POST')

            <!-- Phone Number -->
            <div>
                <label for="phone" class="input-label">Phone</label>
                <input id="phone" class="text-input" type="tel" name="phone" required autofocus autocomplete="tel" />
                @error('phone')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="input-label">Password</label>
                <input id="password" class="text-input" type="password" name="password" required
                    autocomplete="current-password" />
                @error('password')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="checkbox" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="forgot-password" href="{{ route('password.request') }}">Forgot your password?</a>
                <button type="submit" class="primary-button ms-3">Log in</button>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="forgot-password" href="{{ route('register') }}">Create New Account</a>
            </div>
        </form>
    </div>
</body>

</html>