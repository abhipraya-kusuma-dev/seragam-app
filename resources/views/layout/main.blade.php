<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('icon.svg') }}">
    @vite('resources/css/app.css')
</head>

<body class="no-scrollbar">
    @yield('content')

</body>

</html>
