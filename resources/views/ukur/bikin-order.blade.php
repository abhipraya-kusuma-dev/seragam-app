@extends('layout.main')

@section('content')
    <x-navbar />
    <div class="flex justify-center">
        <div id="popupContainer" class="hidden fixed inset-0 w-full h-full flex justify-center items-center pointer-events-none duration-700">
            <div id="popupBackground" class="fixed inset-0 bg-black opacity-0 transition-opacity duration-700"></div>
            <div id="popupContentContainer" class="relative bg-white rounded-2xl h-[525px] w-[1050px] flex flex-col justify-between transform translate-x-[100vw] transition-transform duration-700" style="box-shadow: 4px 8px 10px 0px rgb(15, 15, 15, 0.5)">
                
                    <div class="py-4 px-4 flex justify-end">
                        <button id="close-popup" class="rounded-full text-white w-[35px] h-[35px] text-xl bg-[#F95050] pb-1">🗙</button>
                    </div>
                    <div class="flex justify-end">
                        <div class=" px-2 border-2 border-black rounded-lg w-64 mr-7 mt-4 px-2 py-1 flex justify-between">
                            <input class=" bg-transparent outline-none" placeholder="Cari item..." type="text" name="cari-item"/>
                            <button class="bg-white w-5"><img class="w-14" src="{{ asset('images/search.png') }}" alt=""></button>
                        </div>
                    </div>
                    <div class="mb-[270px] flex justify-between mt-4">
                        <div class="">
                            <h1 class="font-bold text-5xl ml-3">FUNGSIONAL MINGGU DEPAN CUI</h1>
                        </div>
                        <div class="">

                        </div>
                    </div>
                    <div class="bg-[#2BCB4E] w-full rounded-bl-2xl rounded-br-2xl h-32 flex justify-between items-center">
                        <h1 class="font-bold text-3xl text-white ml-7">Total: Rp. 190.000</h1>
                        <button class="bg-[#4071EE] w-36 h-11 rounded-xl border-white border text-white font-bold text-xl mr-7" style="box-shadow: 2px 4px 6px 0px gray">Selesai</button>
                    </div>
            </div>
        </div>
    </div>
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-4 px-4 bg-[#6C0345] text-white font-semibold rounded-b-lg border-black border"
                href="">Buat
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
                            <input type="radio" name="jenis_kelamin[]" id="cewe" value="cewe" class="hidden" />
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

        setTimeout(function(){
            document.getElementById("popupContainer").classList.remove("hidden")
        }, 700)

        document.getElementById("pilih-item").addEventListener("click", function(){
    
            const popupContainer = document.getElementById("popupContainer");
            const popupBackground = document.getElementById("popupBackground");
            const popupContentContainer = document.getElementById("popupContentContainer");

            popupContainer.classList.remove("opacity-0", "pointer-events-none");
            popupBackground.classList.remove("opacity-0");
            popupBackground.classList.add("opacity-50");
            popupContentContainer.classList.remove("translate-x-[100vw]");
            popupContentContainer.classList.add("translate-x-0");

            
        });

        document.getElementById("close-popup").addEventListener("click", function(){
            const popupContainer = document.getElementById("popupContainer");
            const popupBackground = document.getElementById("popupBackground");
            const popupContentContainer = document.getElementById("popupContentContainer");

            // Apply the opacity and transform transitions to hide the popup
            popupBackground.classList.add("opacity-0");
            popupContentContainer.classList.add("translate-x-[100vw]");
            popupContentContainer.classList.remove("translate-x-0");

            // Hide the container after the transitions are complete
            setTimeout(function(){
                popupContainer.classList.add("opacity-0", "pointer-events-none");
            }, 300); // Match this duration to the transition duration
        });
    </script>
