@extends('layout.main')

@section('content')
    <x-navbar />
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-2 px-4 bg-[#6C0345]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6C0345] transition duration-500" href="/gudang/seragam/bikin">Input
                Stok</a>
            <a class=" py-4 px-8  bg-[#6675F7] text-white font-semibold rounded-b-lg border-black border" href="">List
                Order</a>
        </div>
    </div>
    <div class="content-container px-[76px] w-full mt-[92px] mb-4 flex justify-between">
        <form action="" id="status-form">
            <select class="select-condition font-bold text-3xl focus:outline-none bg-transparent" name="status">
                <option class="text-base" value="on-process" {{ request()->query('status') === 'on-process'? 'selected' : ''}}>On-Porcess</option>
                <option class="text-base" value="draft" {{ request()->query('status') === 'draft'? 'selected' : ''}}>Draft</option>
                <option class="text-base" value="selesai" {{ request()->query('status') === 'selesai'? 'selected' : ''}}>Selesai</option>
            </select>
        </form>
        <form class="mt-4 ">
            <input class="py-1 px-2 border border-black rounded" type="text" placeholder="Cari">
        </form>
    </div>
    <div class="table-container px-[76px]">
        <table class="border-2 border-black w-full">
            <thead>
                <tr class="divide-x-2 divide-black  border-black border-2">
                    <th class="px-2 text-left">No.</th>
                    <th class="px-2 text-left">Nama</th>
                    <th class="px-2 text-left">Jenjang</th>
                    <th class="px-2 text-left">Order Masuk</th>
                    @if( request()->query('status') === 'selesai')
                    <th class="px-2 text-left">Order Keluar</th>
                    @endif
                    <th class="px-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="divide-x-2 divide-black  border-black border-2">
                        <td class="px-2 text-left">{{ $order->nomor_urut  }}</td>
                        <td class="px-2 text-left">{{ $order->nama_lengkap }}</td>
                        <td class="px-2 text-left">{{ strtoupper($order->jenjang) }}</td>
                        <td class="px-2 text-left bg-[#FF7878]">{{ $order->order_masuk }}</td>
                        @if( request()->query('status') === 'selesai')
                        <td class="px-2 text-left bg-[#FF7878]">Order Keluar</td>
                        @endif
                        <td class="px-2 text-left bg-[#78BEFF]"><a href="/gudang/order/{{ $order->nomor_urut }}" class="text-white hover:underline">Lihat Order</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.querySelector(".select-condition").addEventListener("change", () => {
            document.getElementById("status-form").submit()
            console.log("change")
        });
    </script>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script>
        const socket = io(`{{ env('SOCKET_IO_SERVER') }}`);

        socket.on('connect', () => {
            console.log("socket connected to the client")
        })
    </script>
    
@endsection