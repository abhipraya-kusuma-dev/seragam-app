@extends('layout.main')

@section('content')
    <h1>Ini halaman daftar orderan (Admin Gudang)</h1>
    <form action="/logout" method="POST">
        @csrf
        <button>logout</button>
    </form>
@endsection
