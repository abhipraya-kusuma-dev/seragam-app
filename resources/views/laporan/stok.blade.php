@extends('layout.main')

@section('content')
    <x-navbar />
    <style>
        #tanggal{
            position: absolute;
            padding: 0; 
            margin: -1px; 
            overflow: hidden; 
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-2 px-4 bg-[#6C0345]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6C0345] transition duration-500" href="/gudang/seragam/bikin">Input
                Stok</a>
            <a class=" py-2 px-8  bg-[#6675F7]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6675F7] transition duration-500"
                href="/gudang/order">List
                Order</a>
            <a class=" py-4 px-8  bg-[#6F19DC] text-white font-semibold rounded-b-lg border-black border"
                href="/laporan/lihat-stok">Laporan Stok</a>
            <a class=" py-2 px-8  bg-[#FF6FE8]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#FF6FE8] transition duration-500"
                href="/laporan/lihat-keuangan">Laporan Keuangan</a>
            <marquee class="select-none w-[495px]">Pekerjaan seberat apapun akan lebih terasa ringan jika kita tidak mengerjakannya🤗🤗</marquee>
        </div>
    </div>

    <section class="flex justify-between py-10 px-[46px]">
        <div id="data-stok-container">
            <table class="border border-black border-2 w-[646px]" id='table-data'>
                
            </table>
        </div>
        <div id="form-stok-container">
            <form action="/laporan/export" class="flex flex-col gap-6 items-end"  onchange="filterOrderan()">
                @csrf
                <div class="flex flex-col gap-4 border rounded-2xl border-black p-4">
                    <h1 class="font-bold">Jenjang</h1>
                    <div id="button-container" class="flex gap-4">
                        <label for="sd"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#FF5656] has-[:checked]:bg-white has-[:checked]:text-[#FF5656] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-8 bg-[#FF5656] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SD
                            <input tabindex="1" type="checkbox" name="jenjang[]" id="sd" value="sd"
                                class="hidden" />
                        </label>

                        <label for="smp"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#3485FF] has-[:checked]:bg-white has-[:checked]:text-[#3485FF] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#3485FF] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMP
                            <input type="checkbox" name="jenjang[]" id="smp" value="smp" class="hidden" />
                        </label>

                        <label for="smk"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#DC6B19] has-[:checked]:bg-white has-[:checked]:text-[#DC6B19] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#DC6B19] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMK
                            <input type="checkbox" name="jenjang[]" id="smk" value="smk" class="hidden" />
                        </label>

                        <label for="sma"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#2BCB4E] has-[:checked]:bg-white has-[:checked]:text-[#2BCB4E] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#2BCB4E] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMA
                            <input type="checkbox" name="jenjang[]" id="sma" value="sma" class="hidden" />
                        </label>
                    </div>
                </div>
                <div class="border border-black rounded-lg flex w-80 h-12">
                    {{-- <span class="calendar-icon text-purple-500 text-xl mr-2"></span> --}}
                    {{--  --}}
                    <label for="tanggal" class="flex w-full items-center justify-center select-none " onclick="triggerDatePicker()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 text-purple-500 p-1 ml-2 hover:text-white hover:bg-purple-500 rounded-md">
                            <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                        </svg>
                        <span id="tanggal-span" class="w-full ml-2 hover:underline">Pilih tanggal</span>
                        <input type="date" name="tanggal" id="tanggal" onchange="console.log(this.value)">
                    </label>                    
                    
                    <div class="flex ml-2 space-x-1 pr-3">
                        <span class="left-arrow text-purple-500 text-3xl place-self-center select-none mb-2 cursor-pointer hover:font-bold">&lt;</span>
                        <span class="right-arrow text-purple-500 text-3xl place-self-center select-none mb-2 cursor-pointer hover:font-bold">&gt;</span>
                    </div>
                </div>
                <button type="submit" name="action" value="unduh" id="unduh-button"
                        class="w-72 h-[59px] bg-[#6F19DC] text-xl font-bold text-white rounded-xl border-white border"
                        style="box-shadow: 2px 4px 6px 0 gray">Unduh</button>
            </form>
        </div>
    </section>
    <script>
        const leftArrow = document.querySelector('.left-arrow');
        const rightArrow = document.querySelector('.right-arrow');
        const datePicker = document.getElementById('tanggal');
        const tanggalSpan = document.getElementById('tanggal-span');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const tableData = document.getElementById('table-data');

        function triggerDatePicker() {
            datePicker.showPicker();
        }

        datePicker.addEventListener('change', function(){
            
            let formattedDate = new Date(datePicker.value);
            formattedDate = formattedDate.toLocaleDateString("id-ID", options);
            tanggalSpan.innerHTML = formattedDate;
        });
        
        leftArrow.addEventListener('click', function(){
            let formattedDate = new Date(datePicker.value);
            let previousDate = new Date(formattedDate.getTime() - 86400000);

            let year = previousDate.getFullYear();
            let month = (previousDate.getMonth() + 1).toString().padStart(2, '0');
            let day = previousDate.getDate().toString().padStart(2, '0');

            datePicker.value = `${year}-${month}-${day}`;

            previousDate = previousDate.toLocaleDateString("id-ID", options)
            tanggalSpan.innerHTML = previousDate;

            filterOrderan()
        });

        rightArrow.addEventListener('click', function(){
            let formattedDate = new Date(datePicker.value);
            let nextDate = new Date(formattedDate.getTime() + 86400000);

            let year = nextDate.getFullYear();
            let month = (nextDate.getMonth() + 1).toString().padStart(2, '0');
            let day = nextDate.getDate().toString().padStart(2, '0');

            datePicker.value = `${year}-${month}-${day}`;

            nextDate = nextDate.toLocaleDateString("id-ID", options)
            tanggalSpan.innerHTML = nextDate;

            filterOrderan()
        });

        function getOrderan(){
            const fetchData = async () => {
                const res = await fetch(`/api/laporan/lihat`)
                const data = await res.json();
                // console.log(data);
                // console.log(jenjangValue.join(','))
                const orders = data.orders;

                return orders;
            }

            tableData.innerHTML = `
                <tr class="divide-x-2 divide-black">
                    <th class="px-2 text-center">Nama Barang</th>
                    <th class="px-2 text-center">Ukuran</th>
                    <th class="px-2 text-center">QTY</th>
                    <th class="px-2 text-center">Jenjang</th>
                </tr>
            `;

            fetchData().then((orders) => orders.forEach((order) => {
                tableData.innerHTML += `
                    <tr class="divide-x-2 divide-black border-bottom border-2 border-black">
                        <td class="px-2 text-left">${order.nama_barang}</td>
                        <td class="px-2 text-center">${order.ukuran}</td>
                        <td class="px-2 text-center">${order.QTY}</td>
                        <td class="px-2 text-center">${order.jenjang.split(',').join(', ').toUpperCase()}</td>
                    </tr>
                `
            }))
        }

        getOrderan()

        function filterOrderan(){

            let jenjangValue = [];

            document.querySelectorAll('input[name="jenjang[]"]').forEach((radio) => {
                if(radio.checked){
                    // if(jenjangValue.includes(radio.value)){
                    //     console.log('value sudah ada')
                    // }
                    // if(!jenjangValue.includes(radio.value)){
                    //     jenjangValue.push(radio.value);
                    // }
                    jenjangValue.push(radio.value);
                }
            });
            
            const fetchData = async () => {
                const res = await fetch(`/api/laporan/lihat?jenjang=${jenjangValue.join(',')}&tanggal=${datePicker.value}`)
                const data = await res.json();
                console.log(data);
                console.log(jenjangValue.join(','))
                const orders = data.orders;

                return orders;
            }

            tableData.innerHTML = `
                <tr class="divide-x-2 divide-black">
                    <th class="px-2 text-center">Nama Barang</th>
                    <th class="px-2 text-center">Ukuran</th>
                    <th class="px-2 text-center">QTY</th>
                    <th class="px-2 text-center">Jenjang</th>
                </tr>
            `;

            fetchData().then((orders) => orders.forEach((order) => {
                tableData.innerHTML += `
                    <tr class="divide-x-2 divide-black border-bottom border-2 border-black">
                        <td class="px-2 text-left">${order.nama_barang}</td>
                        <td class="px-2 text-center">${order.ukuran}</td>
                        <td class="px-2 text-center">${order.QTY}</td>
                        <td class="px-2 text-center">${order.jenjang.split(',').join(', ').toUpperCase()}</td>
                    </tr>
                `
            }))

        }
        
    </script>
    @endsection