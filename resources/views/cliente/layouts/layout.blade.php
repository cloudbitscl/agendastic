
<!doctype html>
<html lang="{{ config('app.lang','es') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset(mix('css/cliente.css')) }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="py-5 text-center">
                <h2>Agendamiento</h2>
                <p class="lead">
                    Agenda una cita.
                </p>
            </div>
        </div>
    </header>
    
    <main class="site-main">
        <div class="container">
            @yield('content')
        </div>
    </main>
        
        
    <footer class="my-5 pt-5 text-muted text-center text-small">
        <div class="container">
            <p class="mb-1">&copy; 2021 - {{ date('Y') }} {{ config('app.name') }}</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Políticas de Privacidad</a></li>
                <li class="list-inline-item"><a href="#">Términos y Condiciones</a></li>
                <li class="list-inline-item"><a href="#">Contacto</a></li>
            </ul>
        </div>
    </footer>
    
    <script src="{{ asset(mix('js/cliente.js')) }}"></script>
    @stack('javascript')
</body>
</html>
