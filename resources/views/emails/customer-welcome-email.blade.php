<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
    <h1>Bienvenido a VitalGym {{ $customer->full_name }}</h1>
    <p>
        Por favor activa tu cuenta visitando el siguiente Link
    </p>
    <a href="{{ route('auth.activate.account', $customer->user->token) }}">Activar Cuenta</a>
</body>
</html>