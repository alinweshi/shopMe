<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> <!-- Link to your CSS file -->
</head>

<body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @auth('admin')
                <!-- Ensures you're checking the 'admin' guard -->
                <div class="p-6 text-gray-900">
                    You're logged in! Hello, {{ Auth::guard('admin')->user()->username }}
                </div>
                <div class="p-6">
                    <button type="submit" class="text-red-600 hover:text-red-800"
                        onclick="event.preventDefault(); document.getElementById('logout').submit()">Logout</button>
                    {{--
                    onclick="event.preventDefault(); document.querySelector('form').submit()">Logout</button> --}}
                    <form method="POST" action="{{ route('admin.logout') }}" id='logout'>
                        @csrf
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </main>
</body>

</html>