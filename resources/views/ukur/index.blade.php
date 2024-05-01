@extends('layout.main')

@section('content')
    <h1>Ini halaman daftar ukuran yang di order (Admin Ukur)</h1>
    <form action="/logout" method="POST">
        @csrf
        <button>logout</button>
    </form>
@endsection
