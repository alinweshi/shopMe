<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="guest-layout">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="input-label">Email</label>
                <input id="email" class="text-input" type="email" name="email"
                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                @error('email')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="input-label">Password</label>
                <input id="password" class="text-input" type="password" name="password" required
                    autocomplete="new-password" />
                @error('password')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="input-label">Confirm Password</label>
                <input id="password_confirmation" class="text-input" type="password" name="password_confirmation"
                    required autocomplete="new-password" />
                @error('password_confirmation')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="primary-button">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</body>

</html>
