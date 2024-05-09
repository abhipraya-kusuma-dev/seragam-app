@extends('layout.main')

@section('content')
    <x-navbar />
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">

            <a class=" py-2 px-8  bg-[#6675F7]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6675F7] transition duration-500"
                href="/gudang/order">List
                Order</a>
        </div>
    </div>
    <div class="content-container px-[46px] w-full mt-[31px] mb-4 flex justify-between">
        <div>
            @if (session('update-success'))
                <p class="text-green-600">{{ session('update-success') }}</p>
            @endif
            @if (session('update-error'))
                <p class="text-red-600">{{ session('update-error') }}</p>
            @endif
            <h3 class="font-bold mb-4">Jenjang</h3>
            <div class="pin-jenjang  mb-4">
                @if ($order->jenjang === 'sd')
                    <h1 class="font-semibold text-white bg-[#FF5656] text-center rounded-[8px] py-1 w-[81px]"
                        style="box-shadow: 2px 4px 6px 0 rgb(148, 148, 148)">SD</h1>
                @endif
                @if ($order->jenjang === 'smp')
                    <h1 class="font-semibold text-white bg-[#3485FF] text-center rounded-[8px] py-1 w-[81px]"
                        style="box-shadow: 2px 4px 6px 0 rgb(148, 148, 148)">SMP</h1>
                @endif
                @if ($order->jenjang === 'sma')
                    <h1 class="font-semibold text-white bg-[#2BCB4E] text-center rounded-[8px] py-1 w-[81px]"
                        style="box-shadow: 2px 4px 6px 0 rgb(148, 148, 148)">SMA</h1>
                @endif
                @if ($order->jenjang === 'smk')
                    <h1 class="font-semibold text-white bg-[#DC6B19] text-center rounded-[8px] py-1 w-[81px]"
                        style="box-shadow: 2px 4px 6px 0 rgb(148, 148, 148)">SMK</h1>
                @endif
            </div>
            <h3 class="font-bold ">No. Urut</h3>
            <h3 class="font-semibold mb-4">{{ $order->nomor_urut }}</h3>
            <h3 class="font-bold ">Nama Lengkap</h3>
            <h3 class="font-semibold mb-16">{{ $order->nama_lengkap }}</h3>

        </div>
        <div>
            <form action="/gudang/order/{{ $nomor_urut }}/update" method="POST">
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

                <div class="flex flex-col gap-5">
                    <button type="submit" name="action" value="complete"
                        class="w-[181px] h-[59px] bg-[#6F19DC] text-xl font-bold text-white rounded-xl border-white border"
                        style="box-shadow: 2px 4px 6px 0 #7b39d2">Siap</button>
                    <button type="submit" name="action" value="draft"
                        class="w-[181px] h-[59px] bg-[#2BCB4E] text-xl font-bold text-white rounded-xl border-white border"
                        style="box-shadow: 2px 4px 6px 0 #4ef171">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
