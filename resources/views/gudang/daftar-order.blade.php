@extends('layout.main')

@section('content')
    <h1>Halaman Daftar Order</h1>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script>
        const socket = io(`{{ env('SOCKET_IO_SERVER') }}`);

        socket.on('connect', () => {
            console.log("socket connected to the client")
        })
    </script>
@endsection
