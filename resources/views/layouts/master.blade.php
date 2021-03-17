<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste CloudFox - @yield('page-title')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>
    
    <nav class="navbar navbar-light bg-white shadow-sm">
        <a class="navbar-brand" href="{{ route('index.page') }}">
            <img src="{{ url(asset('assets/img/mercado-pago-logo.png')) }}" alt="">
        </a>
    </nav>
    
    @yield('page-content')

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('scripts')

</body>
</html>