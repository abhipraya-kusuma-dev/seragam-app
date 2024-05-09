@extends('layout.main')

@section('content')
    @if (session('update-success'))
        <p class="text-green-600">{{ session('update-success') }}</p>
    @endif

    @if (session('update-error'))
        <p class="text-red-600">{{ session('update-error') }}</p>
    @endif

    <h1>Ini halaman detail orderan</h1>
    <form action="/gudang/{{ $nomor_urut }}/update" method="POST">
        @method('PUT')
        @csrf

        <div class="grid grid-cols-1 gap-2">
            @foreach ($order->seragams as $seragam)
                <div class="p-2 border">
                    <label for="{{ $seragam->id }}">{{ $seragam->nama_barang }}</label>
                    <input type="checkbox" id="{{ $seragam->id }}" value="{{ $seragam->id }}" name="seragam_ids[]"
                        {{ $seragam->tersedia ? 'checked' : '' }} />
                </div>
            @endforeach
        </div>

        <button type="submit" name="action" value="draft">Update Data Order (Draft)</button>
        <button type="submit" name="action" value="complete">Update Data Order (Siap)</button>
    </form>
@endsection
