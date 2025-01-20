<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link rel="stylesheet" href="{{ asset('css/confirm-password.css') }}"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="guest-layout">
        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form method="POST" action="{{ route('admin.password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <label for="password" class="input-label">Password</label>
                <input id="password" class="text-input" type="password" name="password" required
                    autocomplete="current-password" />
                @error('password')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="primary-button">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</body>

</html>