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

<body class="no-scrollbar h-screen">
    @yield('content')

    <x-footer />
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script>
        const socket = io(`{{ env('SOCKET_IO_SERVER') }}`);

        if (!window.socket) {
            window.socket = socket
        }
    </script>
    @stack('js')
</body>

</html>
