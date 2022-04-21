<!DOCTYPE html>
<html lang="{{ config('app.lang', 'es') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset(mix('css/admin.css')) }}" rel="stylesheet">

</head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                {{ config('app.name') }}
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Acceso Admin</p>

                    <form method="post" action="{{ url('/login') }}">
                        @csrf

                <div class="input-group mb-3">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" class="form-control @error('email') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" placeholder="********" class="form-control @error('password') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Mantener sesión</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </div>

                </div>
            </form>

            <p class="mb-1">
                <a href="{{ route('admin.password.request') }}">Recuperar contraseña</a>
            </p>
        </div>
    </div>

</div>

<script src="{{ asset(mix('js/admin.js')) }}" defer></script>

</body>
</html>
