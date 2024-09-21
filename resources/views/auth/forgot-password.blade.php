<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="guest-layout">
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div id="session-status" class="mb-4">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="input-label">Email</label>
                <input id="email" class="text-input" type="email" name="email" value="{{ old('email') }}" required
                    autofocus />
                @error('email')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="primary-button">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>
</body>

</html>
