<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Two Factor Enable</title>
</head>

<body>
    <!-- 2FA confirmed, we show a 'disable' button to disable it : -->
    @if($admin->two_factor_confirmed_at)
    <form action="{{route('admin.two-factor.disable')}}" method="post">
        @csrf
        @method('delete')
        <button type="submit">Disable 2FA</button>
    </form>

    <!-- 2FA enabled but not yet confirmed, we show the QRcode and ask for confirmation : -->
    @elseif($admin->two_factor_secret)
    <p>Validate 2FA by scanning the following QR code and entering the TOTP</p>
    {!! $admin->twoFactorQrCodeSvg() !!}

    <!-- Form for entering the 2FA code -->
    <form action="{{ route('admin.two-factor.confirm') }}" method="post">
        @csrf
        <input name="code" required placeholder="Enter 2FA code" />

        <!-- Display validation errors for the code input -->
        @error('code')
        <div style="color: red;">
            {{ $message }}
        </div>
        @enderror

        <button type="submit">Validate 2FA</button>
    </form>

    <!-- Show errors for the form -->
    @if ($errors->has('confirmTwoFactorAuthentication'))
    <div style="color: red;">
        <ul>
            @foreach ($errors->get('confirmTwoFactorAuthentication') as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- 2FA not enabled at all, we show an 'enable' button  : -->
    @else
    <form action="{{ route('admin.two-factor.enable') }}" method="post">
        @csrf
        <button type="submit">Activate 2FA</button>
    </form>
    @endif
</body>

</html>
{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Two Factor Enable</title>
</head>

<body>
    <!-- 2FA confirmed, we show a 'disable' button to disable it : -->
    @if($admin->two_factor_confirmed)
    <form action="/user/two-factor-authentication" method="post">
        @csrf
        @method('delete')
        <button type="submit">Disable 2FA</button>
    </form>
    <!-- 2FA enabled but not yet confirmed, we show the QRcode and ask for confirmation : -->
    @elseif($admin->two_factor_secret)
    <p>Validate 2FA by scanning the floowing QRcode and entering the TOTP</p>
    {!! $admin->twoFactorQrCodeSvg() !!}
    <form action="{{route('admin.two-factor.confirm')}}" method="post">
        @csrf
        <input name="code" required />
        <button type="submit">Validate 2FA</button>
    </form>
    </div>
    <!-- 2FA not enabled at all, we show an 'enable' button  : -->
    @else
    <form action="/user/two-factor-authentication" method="post">
        @csrf
        <button type="submit">Activate 2FA</button>
    </form>
    @endif
    {{-- @if (session('status') == 'two-factor-authentication-enabled')
    <div class="mb-4 font-medium text-sm">
        Please finish configuring two-factor authentication by scanning the QR code below and entering the generated
        code.
    </div>

    <!-- Show QR code for Google Authenticator or other apps -->
    <div>
        {!! $admin->twoFactorQrCodeSvg() !!}
    </div>

    <form method="POST" action="{{ route('admin.two-factor.confirm') }}">
        @csrf
        <div>
            <label for="code">Authentication Code</label>
            <input type="text" name="code" id="code" required>
        </div>
        <button type="submit">Confirm Two-Factor Authentication</button>
    </form>
    @endif

    <!-- Check if two-factor authentication is already enabled -->
    @if ($admin->two_factor_secret)
    <div>
        <form method="POST" action="{{ route('admin.two-factor.disable') }}">
            @csrf
            @method('DELETE')
            <button type="submit">Disable Two Factor</button>
        </form>
    </div>
    @else
    <div>
        <form method="POST" action="{{ route('admin.two-factor.enable') }}">
            @csrf
            <button type="submit">Enable Two Factor</button>
        </form>
    </div>
    @endif --}}