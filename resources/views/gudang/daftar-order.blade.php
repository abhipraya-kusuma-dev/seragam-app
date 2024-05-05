@extends('layout.main')

@section('content')
    <x-navbar />
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-2 px-4 bg-[#6C0345] text-white font-semibold rounded-b-lg border-black border" href="">Buat Orderan</a>
            <a class=" py-4 px-8  bg-[#6675F7] text-white font-semibold rounded-b-lg border-black border" href="">List Order</a>
        </div>
    </div>
    <div class="content-container px-[76px] w-full mt-[92px] mb-4 flex justify-between">
        <select class="font-bold text-3xl focus:outline-none">
            <option class="text-base">On-Porcess</option> 
            <option class="text-base">Draft</option>
        </select>
        <form class="mt-4 ">
            <input class="py-1 px-2 border border-black rounded" type="text" placeholder="Cari">
        </form>
    </div>
    <div class="table-container px-[76px]">
        <table class="border-2 border-black w-full">
            <tr class="divide-x-2 divide-black">
                <th class="px-2 text-left">No.</th>
                <th class="px-2 text-left">Nama</th>
                <th class="px-2 text-left">Jenjang</th>
                <th class="px-2 text-left">Order Masuk</th>
                <th class="px-2 text-left">Order Keluar</th>
                <th class="px-2 text-left">Aksi</th>
            </tr>
        </table>
    </div>
@endsection
