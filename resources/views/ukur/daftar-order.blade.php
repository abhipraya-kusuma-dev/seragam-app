@extends('layout.main')

@section('content')
    <x-navbar />
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-2 px-4 bg-[#6C0345]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6C0345] transition duration-500"
                href="/ukur/bikin">Buat Orderan
            </a>
            <a class=" py-4 px-8  bg-[#6675F7] text-white font-semibold rounded-b-lg border-black border" href="">List
                Order</a>
            <marquee class="select-none w-[495px]">Cantik itu relatif, tergantung letak kamera dan intensitas cahaya..🤗🤗
            </marquee>
        </div>
    </div>
    <div class="content-container px-[76px] w-full mt-[92px] mb-4 flex justify-between">
        <form action="" id="status-form">
            <select class="select-condition font-bold text-3xl focus:outline-none bg-transparent" name="status">
                <option class="text-base" value="on-process"
                    {{ request()->query('status') === 'on-process' ? 'selected' : '' }}>On-Process</option>
                <option class="text-base" value="draft" {{ request()->query('status') === 'draft' ? 'selected' : '' }}>
                    Draft
                </option>
                <option class="text-base" value="siap" {{ request()->query('status') === 'siap' ? 'selected' : '' }}>
                    Siap
                </option>
                <option class="text-base" value="selesai" {{ request()->query('status') === 'selesai' ? 'selected' : '' }}>
                    Selesai</option>
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
            <tbody id="ukur-data">
                @foreach ($orders as $order)
                    <tr class="divide-x-2 divide-black  border-black border-2">
                        <td class="px-2 text-left">{{ $order->nomor_urut }}</td>
                        <td class="px-2 text-left">{{ $order->nama_lengkap }}</td>
                        <td class="px-2 text-left">{{ strtoupper($order->jenjang) }}</td>
                        <td class="px-2 text-left">{{ $order->order_masuk }}</td>
                        @if (request()->query('status') === 'selesai')
                            <td class="px-2 text-left">Order Keluar</td>
                        @endif
                        <td>
                            <div class="px-2 text-left bg-[#fff] flex space-x-2">
                                @if (request()->query('status') != 'selesai')
                                    <a href="/ukur/{{ $order->nomor_urut }}/edit" class="text-yellow-500 hover:underline">Edit
                                        Order</a> <span>|</span>
                                @endif
                                <a href="/ukur/{{ $order->nomor_urut }}" class="text-sky-600 hover:underline">Lihat
                                    Order</a>
                                <span>|</span>
                                @if (request()->query('status') === 'siap')
                                    <form action="/ukur/confirm/{{ $order->id }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <button class="text-green-600 hover:underline"
                                            onclick="return confirm('Apakah orderan sudah selesai?')">Orderan
                                            Selesai</button>
                                    </form> <span>|</span>
                                @endif
                                <form action="/ukur/delete/{{ $order->id }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="text-red-600 hover:underline"
                                        onclick="return confirm('Yakin ingin menghapus orderan?')">Hapus Order</button>
                                </form>
                            </div>
                        </td>
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
    @push('js')
        <script>
            const tbodyUkurData = document.getElementById('ukur-data');

            const isStatusSelesai = `{{ request()->query('status') === 'selesai' }}`;
            const isStatusSiap = `{{ request()->query('status') === 'siap' }}`;

            const formSelesai = (order) => `
              <form action="/ukur/confirm/${order.id}" method="post">
                  @method('POST')
                  @csrf
                  <button class="text-green-600 hover:underline"
                      onclick="return confirm('Apakah orderan sudah selesai?')">Orderan
                      Selesai
                  </button>
              </form>
              <span>|</span>
            `

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
                          <td>
                              <div class="px-2 text-left bg-[#fff] flex space-x-2">
                                  <a href="/ukur/${order.nomor_urut}/edit" class="text-yellow-500 hover:underline">Edit
                                      Order</a> <span>|</span>
                                  <a href="/ukur/${order.nomor_urut}" class="text-sky-600 hover:underline">Lihat
                                      Order</a>
                                  <span>|</span>
                                  ${isStatusSiap ? formSelesai(order) : ''}
                                  <form action="/ukur/delete/${order.id}" method="post">
                                      @method('DELETE')
                                      @csrf
                                      <button class="text-red-600 hover:underline"
                                          onclick="return confirm('Yakin ingin menghapus orderan?')">Hapus Order</button>
                                  </form>
                              </div>
                          </td>
                      </tr>
                    `
                    })
                }

                return listTableData;
            }

            const refetchUkurData = async () => {
                const req = await fetch(
                    `{{ route('api-ukur.list-order') }}?search={{ request()->query('search') }}&status={{ request()->query('status', 'on-process') }}`
                );

                const res = await req.json();

                return res;
            }

            socket.on('connect', () => {
                socket.on('ukur-data-change', async function() {
                    console.log('ukur data change');
                    console.log(`{{ request()->query('search') }}`);
                    console.log(`{{ request()->query('status') }}`);

                    const ukurData = await refetchUkurData();

                    console.log(ukurData)
                    tbodyUkurData.innerHTML = generateTableData(ukurData.orders);
                });
            })
        </script>
    @endpush
@endsection
