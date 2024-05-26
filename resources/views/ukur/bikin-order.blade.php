@extends('layout.main')

@section('content')
    <script>
        const changeUkuran = () => {
            console.log('Aku ke trigger');
        }
    </script>
    <x-navbar />
    <div class="flex justify-center">
        <div id="popupContainer"
            class="hidden fixed inset-0 w-full h-full flex justify-center items-center pointer-events-none duration-700">
            <div id="popupBackground" class="fixed inset-0 bg-black opacity-0 transition-opacity duration-700"></div>
            <div id="popupContentContainer"
                class="relative bg-white rounded-2xl h-[525px] w-[1050px] flex flex-col justify-between transform translate-x-[100vw] transition-transform duration-700"
                style="box-shadow: 4px 8px 10px 0px rgb(15, 15, 15, 0.5)">

                <div class="py-4 px-4 flex justify-end">
                    <button id="close-popup"
                        class="rounded-full text-white w-[35px] h-[35px] text-xl bg-[#F95050] pb-1">🗙</button>
                </div>

                <div class="flex justify-between mt-4 gap-5 ">
                    <div id="seragam-item"
                        class=" no-scrollbar grid w-full grid-cols-2 gap-5 ml-1 h-[370px] overflow-y-auto overflow-hidden p-6">

                    </div>
                    <div class="">
                        <div class="flex justify-end">
                            <div>
                                <form action="" id="cari-item-form"
                                    class="px-2 border-2 border-black rounded-lg w-72 mr-7 px-2 py-1 flex justify-between">
                                    <input id="cari-input" class=" bg-transparent outline-none" placeholder="Cari item..."
                                        type="text" name="cari-item" />
                                    <button class="bg-white w-5" type="submit"><img class="w-14"
                                            src="{{ asset('images/search.png') }}" alt=""></button>
                                </form>
                            </div>
                        </div>
                        <div class="border-2 border-black rounded-lg w-72 h-64 mr-7 flex flex-col py-2 px-3">
                            <h1 class="font-bold text-2xl">List order</h1>
                            <p class="pb-2">Periksa kembali orderan anda:</p>
                            <div class="border-t border-b h-40 border-black pb-2">
                                <div class="grid grid-cols-2 gap-4 p-1">
                                    <div class="">
                                        <p
                                            class="border border-black rounded-lg bg-[#FF5656] font-semibold text-white px-2 relative">
                                            Hai <span
                                                class="absolute bg-green-400 rounded-xl w-5 h-5 text-sm text-center -right-2 -bottom-2">0</span>
                                        </p>
                                        <p class="harga text-sm">Rp. 20.000</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="bg-[#2BCB4E] w-full rounded-bl-2xl rounded-br-2xl py-4 flex justify-between items-center">
                    <h1 class="font-bold text-3xl text-white ml-7">Total: Rp. 190.000</h1>
                    <button class="bg-[#4071EE] w-36 h-11 rounded-xl border-white border text-white font-bold text-xl mr-7"
                        style="box-shadow: 2px 4px 6px 0px gray">Selesai</button>
                </div>
            </div>
        </div>
    </div>
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-4 px-4 bg-[#6C0345] text-white font-semibold rounded-b-lg border-black border" href="">Buat
                Orderan</a>
            <a class=" py-2 px-8  bg-[#6675F7]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6675F7] transition duration-500"
                href="/ukur/order">List
                Order</a>
        </div>
    </div>
    <section class="flex justify-between py-10 px-[46px]">
        <div class="flex flex-col gap-5">
            <div class="border rounded-xl border-black px-4 py-2" style="box-shadow: 2px 4px 6px rgb(177, 177, 177)">
                <form id="create-and-edit-form" action="" class="flex flex-col gap-4" method="POST">
                    @csrf
                    <div>
                        <h1 class="font-bold">Nomor Urut</h1>
                        <input disabled class="font-semibold disabled:bg-transparent" value="H4L0" />
                    </div>
                    <h1 class="font-bold">Jenjang</h1>
                    <div class="flex items-center gap-4">
                        <label for="sd"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#FF5656] has-[:checked]:bg-white has-[:checked]:text-[#FF5656] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-8 bg-[#FF5656] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SD
                            <input tabindex="1" type="radio" name="jenjang[]" id="sd" value="sd"
                                class="hidden" />
                        </label>

                        <label for="smp"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#3485FF] has-[:checked]:bg-white has-[:checked]:text-[#3485FF] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#3485FF] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMP
                            <input type="radio" name="jenjang[]" id="smp" value="smp" class="hidden" />
                        </label>

                        <label for="sma"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#2BCB4E] has-[:checked]:bg-white has-[:checked]:text-[#2BCB4E] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#2BCB4E] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMA
                            <input type="radio" name="jenjang[]" id="sma" value="sma" class="hidden" />
                        </label>

                        <label for="smk"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#DC6B19] has-[:checked]:bg-white has-[:checked]:text-[#DC6B19] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#DC6B19] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMK
                            <input type="radio" name="jenjang[]" id="smk" value="smk" class="hidden" />
                        </label>
                    </div>

                    <h1 class="font-bold">Jenis Kelamin</h1>
                    <div class="flex items-center gap-4">
                        <label for="cowo"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#3485FF] has-[:checked]:bg-white has-[:checked]:text-[#3485FF] border-2 border-transparent select-none rounded-[8px] py-1 px-7 bg-[#3485FF] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            Pria
                            <input type="radio" name="jenis_kelamin[]" id="cowo" value="cowo" class="hidden" />
                        </label>

                        <label for="cewe"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#FF34C6] has-[:checked]:bg-white has-[:checked]:text-[#FF34C6] border-2 border-2 border-transparent select-none rounded-[8px] py-1 px-5 bg-[#FF34C6] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            Wanita
                            <input type="radio" name="jenis_kelamin[]" id="cewe" value="cewe"
                                class="hidden" />
                        </label>
                    </div>
                    <div>
                        <label for="nama_barang" class="font-bold">Nama Lengkap</label><br>
                        <input list="list_nama_barang" id="nama_barang" name="nama_barang"
                            class="outline-none border rounded border-black px-2 font-bold mt-2"
                            placeholder="Tuliskan nama..." />
                    </div>
            </div>
            <div class="flex gap-5">
                <button type="submit" id="submit-button"
                    class="w-[181px] h-[59px] bg-[#6F19DC] text-xl font-bold text-white rounded-xl border-white border"
                    style="box-shadow: 2px 4px 6px 0 gray">Kirim</button>
                <button type="submit" id="submit-button"
                    class="w-[181px] h-[59px] bg-[#2BCB4E] text-xl font-bold text-white rounded-xl border-white border"
                    style="box-shadow: 2px 4px 6px 0 gray">Simpan</button>
            </div>
            </form>
        </div>
        <div class="flex flex-col gap-4 items-end">
            <div>
                <button id="pilih-item"
                    class="w-[171px] h-[45px] bg-[#2BCB4E] text-lg font-bold text-white rounded-xl border-white border"
                    style="box-shadow: 2px 4px 6px 0 gray">Pilih Item</button>
            </div>
            <div>
                <table class="border border-black border-2">
                    <thead>
                        <tr class="divide-x-2 divide-black border-b-2 border-black">
                            <th class="px-4">Nama Barang</th>
                            <th class="px-4">Ukuran</th>
                            <th class="px-4">QTY</th>
                            <th class="px-4">Harga</th>
                            <th class="px-4">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach
                            <tr>
                            
                            </tr>
                        @endforeach --}}

                        <tr class="divide-x-2 divide-black border-b-2 border-black">
                            <td class="px-4">Total</td>
                            <td colspan="3" class="bg-[#7886FF]"></td>
                            <td class="px-4 bg-[#7886FF] text-white">190.000</td>

                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </section>

    <script>
        // document.getElementById("pilih-item").addEventListener("click", function(){
        //     document.getElementById("popupContainer").classList.remove("hidden");
        // })

        // document.getElementById("close-popup").addEventListener("click", function(){
        //     document.getElementById("popupContainer").classList.add("hidden");
        // })

        setTimeout(function() {
            document.getElementById("popupContainer").classList.remove("hidden")
        }, 700)

        document.getElementById("pilih-item").addEventListener("click", function() {

            const popupContainer = document.getElementById("popupContainer");
            const popupBackground = document.getElementById("popupBackground");
            const popupContentContainer = document.getElementById("popupContentContainer");

            popupContainer.classList.remove("opacity-0", "pointer-events-none");
            popupBackground.classList.remove("opacity-0");
            popupBackground.classList.add("opacity-50");
            popupContentContainer.classList.remove("translate-x-[100vw]");
            popupContentContainer.classList.add("translate-x-0");


        });

        document.getElementById("close-popup").addEventListener("click", function() {
            const popupContainer = document.getElementById("popupContainer");
            const popupBackground = document.getElementById("popupBackground");
            const popupContentContainer = document.getElementById("popupContentContainer");

            // Apply the opacity and transform transitions to hide the popup
            popupBackground.classList.add("opacity-0");
            popupContentContainer.classList.add("translate-x-[100vw]");
            popupContentContainer.classList.remove("translate-x-0");

            // Hide the container after the transitions are complete
            setTimeout(function() {
                popupContainer.classList.add("opacity-0", "pointer-events-none");
            }, 300); // Match this duration to the transition duration
        });

        document.getElementById('cari-item-form').addEventListener('submit', (e) => {
            e.preventDefault();

            console.log('hai')

            const cariVal = document.getElementById('cari-input').value;

            console.log(cariVal)

            const fetchData = async () => {
                const res = await fetch(`/api/seragam?search=${cariVal}`)
                const data = await res.json()
                const orders = data.orders;

                document.getElementById('seragam-item').innerHTML = ""

                return orders;
            }

            const returnOptionUkuran = (order) => {
                if (order.semua_ukuran.length > 0) {
                    let optionElements = ''
                    order.semua_ukuran.forEach((orders) => {
                        optionElements +=
                            `<option value="${orders.ukuran}" class="text-black">${orders.ukuran}</option>`
                    })

                    return optionElements
                }
            }




            fetchData().then((order) => order.forEach((order, index) => {
                document.getElementById('seragam-item').innerHTML += `<div class=" h-max border-2 border border-black rounded-xl">
                            <div class="relative"><button
                                    class=" w-14 h-14 bg-green-500 flex justify-center items-center font-bold rounded-[2000px] absolute -right-5 -top-4"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="5" stroke="#ffff" class="size-9">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </div>
                            <div class="px-5 py-3 flex flex-col gap-3">
                                <div>
                                    <h1 class="font-bold text-2xl">${order.nama_barang}</h1>
                                    <p>${order.harga} / Pcs</p>
                                </div>
                                <div class="flex gap-3 items-center">
                                    <div class="relative flex w-max items-center gap-1 rounded-3xl border border-black bg-green-500 py-1">
                                        <label for="ukuran" class="absolute right-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="#ffff" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                        </label>
                                        <select onchange="changeUkuran()" id='ukuran${index}' name="ukuran${index}" class="option:text-black relative appearance-none bg-transparent px-6 text-xl font-semibold text-white outline-none">
                                            <option value="${order.ukuran}" class="text-black">${order.ukuran}</option>
                                            ${returnOptionUkuran(order)}
                                        </select>
                                    </div>
                                    <div class="border border-black rounded-lg px-1 w-full py-1 flex justify-between">
                                        <button id="kurang${order.kurang}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                            <path fill-rule="evenodd" d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z" clip-rule="evenodd" />
                                          </svg>
                                        </button>
                                        <span id="qty"> 0</span>
                                        <button id="tambah${order.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                              </svg>                                              
                                          </button>
                                    </div>
                                    <div class="pr-1 w-full">
                                        <p id='stok${index}' class="font-semibold">Stok: ${order.stok}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                const elemenUkuran = document.getElementById('ukuran' + index);
                const elemenStok = document.getElementById('stok' + index);

                elemenUkuran.onchange = function() {
                    console.log('on change ke trigger')
                }

            }))
        })
    </script>
