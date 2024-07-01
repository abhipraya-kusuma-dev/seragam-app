@extends('layout.main')

@section('content')
    <x-navbar />
    @if (session('update-success'))
        @push('js')
            <script>
                socket.on('connect', () => {
                    socket.emit('gudang-data-change');
                    socket.emit('ukur-data-change');
                });
            </script>
        @endpush
    @endif
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-2 px-4 bg-[#6C0345]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6C0345] transition duration-500"
                href="/gudang/seragam/bikin">Input
                Stok</a>
            <a class=" py-4 px-8  bg-[#6675F7] text-white font-semibold rounded-b-lg border-black border" href="">List
                Order</a>
            <a class=" py-2 px-8  bg-[#6F19DC]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6F19DC] transition duration-500"
                href="/laporan/lihat-stok">Laporan Stok</a>
            <a class=" py-2 px-8  bg-[#FF6FE8]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#FF6FE8] transition duration-500"
                href="/laporan/lihat-keuangan">Laporan Keuangan</a>
            <marquee class="select-none w-[495px]">Pekerjaan seberat apapun akan lebih terasa ringan jika kita tidak
                mengerjakannya🤗🤗</marquee>
        </div>
    </div>
    <section>
        <div class="content-container px-[76px] w-full mt-[92px] mb-4 flex justify-between">
            <form action="" id="status-form">
                <select class="select-condition font-bold text-3xl focus:outline-none bg-transparent" name="status">
                    <option class="text-base" value="on-process"
                        {{ request()->query('status') === 'on-process' ? 'selected' : '' }}>On-Process</option>
                    <option class="text-base" value="draft" {{ request()->query('status') === 'draft' ? 'selected' : '' }}>
                        Draft</option>
                    <option class="text-base" value="siap" {{ request()->query('status') === 'siap' ? 'selected' : '' }}>
                        Siap</option>
                    <option class="text-base" value="selesai"
                        {{ request()->query('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
            <form class="mt-4 py-1 px-2 border border-black rounded" method="GET">
                <input type="text" class="hidden" name="status" value="{{ request()->query('status', 'on-process') }}">
                <input class="outline-none" name="search" type="text" placeholder="Cari">
                <button type="submit"><img class="w-4" src="{{ asset('images/search.png') }}" alt=""></button>
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
                        @if (request()->query('status') === 'selesai')
                            <th class="px-2 text-left">Order Keluar</th>
                        @endif
                        <th class="px-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody id="gudang-data">
                    @foreach ($orders as $order)
                        <tr class="divide-x-2 divide-black  border-black border-2">
                            <td class="px-2 text-left">{{ $order->nomor_urut }}</td>
                            <td class="px-2 text-left">{{ $order->nama_lengkap }}</td>
                            <td class="px-2 text-left">{{ strtoupper($order->jenjang) }}</td>
                            <td class="px-2 text-left">{{ $order->order_masuk }}</td>
                            @if (request()->query('status') === 'selesai')
                                <td class="px-2 text-left">Order Keluar</td>
                            @endif
                            <td class="px-2 text-left">
                                <a href="/gudang/order/{{ $order->nomor_urut }}"
                                    class="hover:underline text-blue-500">Lihat Order</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.querySelector(".select-condition").addEventListener("change", () => {
            document.getElementById("status-form").submit()
            console.log("change")
        });
    </script>
    @push('js')
        <script>
            const tbodyGudangData = document.getElementById('gudang-data');

            const isStatusSelesai = `{{ request()->query('status') === 'selesai' }}`;

            const generateTableData = (orders) => {
                let listTableData = '';

                if (orders.length > 0) {
                    orders.forEach(order => {
                        listTableData += `
                          <tr class="divide-x-2 divide-black  border-black border-2">
                              <td class="px-2 text-left">${order.nomor_urut}</td>
                              <td class="px-2 text-left">${order.nama_lengkap}</td>
                              <td class="px-2 text-left">${order.jenjang.toUpperCase()}</td>
                              <td class="px-2 text-left">${order.order_masuk}</td>
                              ${isStatusSelesai ? '<td class="px-2 text-left">Order Keluar</td>' : ''}
                              <td class="px-2 text-left">
                                  <a href="/gudang/order/${order.nomor_urut}"
                                      class="hover:underline text-blue-500">Lihat Order</a>
                              </td>
                          </tr>
                        `
                    });
                }

                return listTableData;
            }
            const refetchGudangData = async () => {
                const req = await fetch(
                    `{{ route('api-gudang.list-order') }}?search={{ request()->query('search') }}&status={{ request()->query('status', 'on-process') }}`
                );

                const res = await req.json();

                return res;
            }

            socket.on('connect', () => {
                socket.on('gudang-data-change', async function() {
                    console.log('gudang data change');
                    const gudangData = await refetchGudangData();

                    tbodyGudangData.innerHTML = generateTableData(gudangData.orders);
                });
            })
        </script>
    @endpush
@endsection
