<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="guest-layout">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="first_name" class="input-label">First_Name</label>
                <input id="first_name" class="text-input" type="text" name="first_name" value="{{ old('first_name') }}"
                    required autofocus autocomplete="first_name" />
                @error('first_name')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="last_name" class="input-label">Last_Name</label>
                <input id="last_name" class="text-input" type="text" name="last_name" value="{{ old('last_name') }}"
                    required autofocus autocomplete="last_name" />
                @error('last_name')
                <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="input-label">Email</label>
                <input id="email" class="text-input" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="username" />
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
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    Already registered?
                </a>

                <button type="submit" class="primary-button ms-4">
                    Register
                </button>
            </div>
        </form>
    </div>
</body>

</html>