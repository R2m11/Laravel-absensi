<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PT.Yutaka Karawang Indonesia</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="icon" href="{{ asset('template/img/yutaka logo.jpg') }}" type="image/x-icon"/>

    <style>
        body{
            background-image: url('{{ asset("img/bg-01.jpg") }}');
            background-size: cover;
            background-attachment: fixed;
        }
        .card {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .logo {
            border-radius: 8%; /* Membuat gambar menjadi lingkaran */
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
        }

    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
