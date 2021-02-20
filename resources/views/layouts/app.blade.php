<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Post App</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-200">
    <nav class="p-6 bg-white flex justify-between mb-6">
        <ul class="flex item-center">
            <li><a class="p-3" href="{{route('home')}}">Home</a></li>
            <li><a class="p-3" href="{{route('dashboard')}}">Dashboard</a></li>
        </ul>

        <ul class="flex item-center">
            @auth
            <li><a class="p-3" href="">{{auth()->user()->name}}</a></li>
                <li><a class="p-3" href="{{route('logout')}}">Logout</a></li>
            @endauth
            @guest
                <li><a class="p-3" href="{{route('login')}}">Login</a></li>
                <li><a class="p-3" href="{{route('register')}}">Register</a></li>
            @endguest
        </ul>
    </nav>    
    @yield('content')
</body>
</html>