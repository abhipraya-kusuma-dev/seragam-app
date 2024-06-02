@extends('layout.main')

@section('content')
    <script>
        const orderItemList = []

        const changeUkuran = (ukuranDanStok, index) => {
            const stokElement = document.getElementById('stok' + index);
            const orderItemElement = document.getElementById('order-item-' + index);
            const QTYElement = document.getElementById('qty' + index);

            const [id, ukuran, stok, harga] = ukuranDanStok.split(':');

            stokElement.textContent = `Stok: ${stok}`

            const order = JSON.parse(orderItemElement.textContent)

            order.id = +id
            order.ukuran = ukuran
            order.harga = harga
            order.stok = +stok

            orderItemElement.textContent = JSON.stringify(order);
            QTYElement.textContent = '0'

        }

        const decrementQTY = (index) => {
            const QTYElement = document.getElementById('qty' + index);

            // NOTE: tanda +VariableName (tanpa spasi) itu sama kayak nge parse si VariableName ke int
            if (+QTYElement.textContent > 0) {
                QTYElement.textContent = +QTYElement.textContent - 1;
            }
        }

        const incrementQTY = (index) => {
            const QTYElement = document.getElementById('qty' + index);
            const stokElement = document.getElementById('stok' + index);

            const maxStok = stokElement.textContent.split(': ')[1];

            // NOTE: tanda +VariableName (tanpa spasi) itu sama kayak nge parse si VariableName ke int
            if (+QTYElement.textContent < +maxStok) {
                QTYElement.textContent = +QTYElement.textContent + 1;
            }
        }

        const addOrderItem = (button, index) => {
            const order = JSON.parse(button.children[0].textContent);
            order.QTY = +document.getElementById('qty' + index).textContent;

            if (order.QTY > 0 && order.QTY <= order.stok) {
                const orderIndexExists = orderItemList.findIndex(od => od.id === order.id);

                console.log('Index: ', orderIndexExists);
                console.log('Array exists: ', order[orderIndexExists]);
                console.log('Order: ', order);

                if (orderIndexExists !== undefined && orderIndexExists > -1) {
                    console.log('Aku di splice');
                    orderItemList.splice(orderIndexExists, 1, order);
                } else {
                    console.log('Aku di push');
                    orderItemList.push(order);
                }

                generateOrderItemList(orderItemList);
                generateTotalPrice(orderItemList);
            }
        }

        const deleteOrderItemList = (index) => {
            orderItemList.splice(index, 1);

            generateOrderItemList(orderItemList);
            generateTotalPrice(orderItemList);
        }

        const generateTotalPrice = (list) => {
            const totalHargaElement = document.getElementById('order-total-price');

            if (list.length < 1) {
                totalHargaElement.textContent = 'Total: Rp. 0';
            } else {
                const totalHarga = list.map(order => {
                    return +order.harga.substring(4).replace('.', '') * order.QTY;
                }).reduce((current, next) => current + next);


                totalHargaElement.textContent = `Total: Rp. ${totalHarga.toLocaleString('id-ID')}`;
            }

        }

        let reopenObject = {};

        const reopenGeneratedList = (index) => {
            const reopen = reopenObject;

            const seragamItem = document.getElementById('seragam-item')
            seragamItem.innerHTML = '';


            const returnOptionUkuran = (order) => {
                if (order.semua_ukuran) {

                    if (order.semua_ukuran.length > 0) {
                        let optionElements = ''
                        order.semua_ukuran.forEach((order) => {
                            optionElements +=
                                `<option value="${order.id}:${order.ukuran}:${order.stok}:${order.harga}" class="text-black">${order.ukuran}</option>`
                        })

                        return optionElements
                    }
                } else {
                    return;
                }
            }


            document.getElementById('seragam-item').innerHTML += `<div class=" h-max border-2 border border-black rounded-xl relative">
                    <div class="px-5 py-3 flex flex-col gap-3">
                        <div>
                            <h1 class="font-bold text-2xl">${reopen.nama_barang}</h1>
                            <p>${reopen.harga} / Pcs</p>
                        </div>
                        <div class="flex gap-3 items-center">
                            <div class="relative flex w-max items-center gap-1 rounded-3xl border border-black bg-green-500 py-1">
                                <label for="ukuran" class="absolute right-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="#ffff" class="size-4">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                  </svg>
                                </label>
                                <select onchange="changeUkuran(this.value, ${index})" id='ukuran${index}' name="ukuran${index}" class="option:text-black relative appearance-none bg-transparent px-6 text-xl font-semibold text-white outline-none">
                                    <option value="${reopen.id}:${reopen.ukuran}:${reopen.stok}:${reopen.harga}" class="text-black">${reopen.ukuran}</option>
                                    <!--${returnOptionUkuran(reopen)}-->
                                </select>
                            </div>
                            <div class="border border-black rounded-lg px-1 w-full py-1 flex justify-between">
                                <button onclick="decrementQTY(${index})">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z" clip-rule="evenodd" />
                                  </svg>
                                </button>
                                <span id="qty${index}">${reopen.QTY}</span>
                                <button onclick="incrementQTY(${index})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="pr-1 w-full">
                                <p id='stok${index}' class="font-semibold">Stok: ${reopen.stok}</p>
                            </div>
                        </div>
                    </div>
                    <button onclick="addOrderItem(this, ${index})" class="w-14 h-14 bg-green-500 flex justify-center items-center font-bold rounded-[2000px] absolute -right-5 -top-4">
                          <span class="hidden" id="order-item-${index}">${JSON.stringify({...reopen, QTY: 0})}</span>
                          <svg
                              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke-width="5" stroke="#ffff" class="size-9">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                          </svg>
                      </button>
                </div>`;


        }

        const generateOrderItemList = (list) => {
            const orderItemListContainer = document.getElementById('order-item-list-container');

            orderItemListContainer.innerHTML = '';


            list.forEach((order, index) => {

                const orderJsonString = JSON.stringify(order).replace(/"/g, '&quot;');

                orderItemListContainer.innerHTML += `
                  <div class="order-item">
                      <p  id="order-list-${index}"
                          class="border border-black rounded-lg bg-[#FF5656] font-semibold text-white px-2 relative pb-1">
                          ${order.nama_barang} (${order.ukuran})
                          <span onclick="
                            console.log(${orderJsonString})
                            reopenObject = ${orderJsonString}
                            reopenGeneratedList(${index});
                          " class="absolute cursor-pointer bg-green-400 rounded-xl w-5 h-5 text-sm text-center -right-2 -bottom-2">${order.QTY}</span>
                          <span onclick="deleteOrderItemList(${index})" class="absolute cursor-pointer border border-black bg-red-400 rounded-xl w-5 h-5 text-sm text-center -right-2 -top-2 mb-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" fill="currentColor" class="size-5">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                            </svg>
                          </span>
                      </p>
                      <p class="harga text-sm">${order.harga}</p>
                  </div>
              `
            });
        }

        const generateDataOnTable = (list) => {
            const orderDataTableContainer = document.getElementById('order-data-table');

            orderDataTableContainer.innerHTML = '';

            list.forEach(order => {
                const jumlahHargaPerSeragam = +order.harga.substring(4).replace('.', '') * order.QTY;

                orderDataTableContainer.innerHTML += `
                  <tr class="divide-x-2 divide-black border-b-2 border-black">
                    <td class="px-4">${order.nama_barang}</td>
                    <td class="px-4">${order.ukuran}</td>
                    <td class="px-4">${order.QTY}</td>
                    <td class="px-4">${order.harga}</td>
                    <td class="px-4">Rp. ${jumlahHargaPerSeragam.toLocaleString('id-ID')}</td>
                  </tr>
                `;
            });

            if (list.length > 0) {
                const totalHarga = list.map(order => {
                    return +order.harga.substring(4).replace('.', '') * order.QTY;
                }).reduce((current, next) => current + next);

                orderDataTableContainer.innerHTML += `
                  <tr class="divide-x-2 divide-black border-b-2 border-black">
                      <td class="px-4">Total</td>
                      <td colspan="3" class="bg-[#7886FF]"></td>
                      <td class="px-4 bg-[#7886FF] text-white">Rp. ${totalHarga.toLocaleString('id-ID')}</td>
                  </tr>
                `
            } else {
                orderDataTableContainer.innerHTML += `
                  <tr class="divide-x-2 divide-black border-b-2 border-black">
                      <td class="px-4">Total</td>
                      <td colspan="3" class="bg-[#7886FF]"></td>
                      <td class="px-4 bg-[#7886FF] text-white">Rp. 0</td>
                  </tr>
                `
            }
        }

        const generateNomorUrut = () => {
            document.querySelectorAll('input[name="jenjang"]').forEach(input => {
                input.addEventListener('change', function(e) {
                    console.log(e.target.value)
                    const jenjang = e.target.value;
                    const nomorUrut = document.getElementById('order-nomor-urut');

                    nomorUrut.value = jenjang[jenjang.length - 1].toUpperCase() +
                        {{ Js::from($nomorOrderTerakhir) }};
                });
            });
        }

        const generateInput = (list) => {
            const hiddenInput = document.getElementById('hidden-input');

            list.forEach(order => {
                hiddenInput.innerHTML += `
                  <input type="hidden" value="${order.id}" name="seragam_id[]" />
                  <input type="hidden" value="${order.QTY}" name="qty[]" />
                `
            });
        }

        const selesaiPilihItem = () => {
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

            generateDataOnTable(orderItemList);
            generateInput(orderItemList);

            console.log(orderItemList);
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
                    <button id="close-popup" class="rounded-full text-white p-2 text-xl bg-[#F95050] grid place-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex justify-between mt-4 gap-5 ">
                    <div id="seragam-item"
                        class=" no-scrollbar grid w-full grid-cols-2 gap-5 ml-1 h-[370px] overflow-y-auto overflow-hidden p-6">
                    </div>
                    <div class="">
                        <div class="flex mb-4 justify-end">
                            <div>
                                <form action="" id="cari-item-form"
                                    class="px-2 border-2 border-black rounded-lg w-72 mr-7 px-2 py-1 flex justify-between">
                                    <input id="cari-input" class="w-full mr-1 bg-transparent outline-none"
                                        placeholder="Cari item..." type="text" name="cari-item" />
                                    <button class="bg-white w-5" type="submit"><img class="w-14"
                                            src="{{ asset('images/search.png') }}" alt=""></button>
                                </form>
                            </div>
                        </div>
                        <div class="border-2 border-black rounded-lg w-72 h-64 mr-7 flex flex-col py-2 px-3">
                            <h1 class="font-bold text-2xl">List order</h1>
                            <p class="pb-2">Periksa kembali orderan anda:</p>
                            <div class="border-t border-b h-40 border-black pb-2 overflow-y-auto">
                                <!-- order list disini -->
                                <div class="grid grid-cols-2 gap-4 pr-2 pt-3 pb-2 overflow-y-auto"
                                    id="order-item-list-container">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="bg-[#2BCB4E] w-full rounded-bl-2xl rounded-br-2xl  py-4 flex justify-between items-center">
                    <h1 class="font-bold text-3xl text-white ml-7" id="order-total-price">Total: Rp. 0</h1>
                    <button class="bg-[#4071EE] w-36 h-11 rounded-xl border-white border text-white font-bold text-xl mr-7"
                        style="box-shadow: 2px 4px 6px 0px gray" onclick="selesaiPilihItem()">Selesai</button>
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

    <div class="px-[46px]">
        @if (session('create-success'))
            <script>
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        alert('{{ session('create-success') }}');
                    }, 100); // Adjust the delay as needed
                });
            </script>
        @endif
        @if (session('create-error'))
            <script>
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        alert('{{ session('create-error') }}');
                    }, 100); // Adjust the delay as needed
                });
            </script>
        @endif

        @if ($errors->any())
            <div class="bg-red-600 text-white">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <section class="flex justify-between py-10 px-[46px]">

        <div class="flex flex-col gap-5">
            <div class="border rounded-xl border-black px-4 py-2" style="box-shadow: 2px 4px 6px rgb(177, 177, 177)">
                <form id="create-and-edit-form" action="/ukur/bikin" class="flex flex-col gap-4" method="POST">
                    @csrf
                    <div id="hidden-input" class="hidden">

                    </div>
                    <div>
                        <h1 class="font-bold">Nomor Urut</h1>
                        <input class="font-semibold bg-transparent cursor-not-allowed pointer-events-none"
                            id="order-nomor-urut" name="nomor_urut" value="{{ $nomorOrderTerakhir }}" />
                    </div>
                    <h1 class="font-bold">Jenjang</h1>
                    <div class="flex items-center gap-4">
                        <label for="sd"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#FF5656] has-[:checked]:bg-white has-[:checked]:text-[#FF5656] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-8 bg-[#FF5656] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SD
                            <input tabindex="1" type="radio" name="jenjang" id="sd" value="sd"
                                class="hidden" />
                        </label>

                        <label for="smp"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#3485FF] has-[:checked]:bg-white has-[:checked]:text-[#3485FF] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#3485FF] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMP
                            <input type="radio" name="jenjang" id="smp" value="smp" class="hidden" />
                        </label>

                        <label for="sma"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#2BCB4E] has-[:checked]:bg-white has-[:checked]:text-[#2BCB4E] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#2BCB4E] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMA
                            <input type="radio" name="jenjang" id="sma" value="sma" class="hidden" />
                        </label>

                        <label for="smk"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#DC6B19] has-[:checked]:bg-white has-[:checked]:text-[#DC6B19] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#DC6B19] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMK
                            <input type="radio" name="jenjang" id="smk" value="smk" class="hidden" />
                        </label>
                    </div>

                    <h1 class="font-bold">Jenis Kelamin</h1>
                    <div class="flex items-center gap-4">
                        <label for="cowo"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#3485FF] has-[:checked]:bg-white has-[:checked]:text-[#3485FF] border-2 border-transparent select-none rounded-[8px] py-1 px-7 bg-[#3485FF] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            Pria
                            <input type="radio" name="jenis_kelamin" id="cowo" value="cowo" class="hidden" />
                        </label>

                        <label for="cewe"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#FF34C6] has-[:checked]:bg-white has-[:checked]:text-[#FF34C6] border-2 border-2 border-transparent select-none rounded-[8px] py-1 px-5 bg-[#FF34C6] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            Wanita
                            <input type="radio" name="jenis_kelamin" id="cewe" value="cewe" class="hidden" />
                        </label>
                    </div>
                    <div>
                        <label for="nama_lengkap" class="font-bold">Nama Lengkap</label><br>
                        <input list="list_nama_barang" id="nama_lengkap" name="nama_lengkap"
                            class="outline-none border rounded border-black px-2 font-bold mt-2 mb-2"
                            placeholder="Tuliskan nama..." />
                    </div>
                    <div class="flex gap-5">
                        <button type="submit" name="action" value="complete" id="submit-button"
                            class="w-[181px] h-[59px] bg-[#6F19DC] text-xl font-bold text-white rounded-xl border-white border"
                            style="box-shadow: 2px 4px 6px 0 gray">Kirim</button>
                        <button type="submit" name="action" value="draft" id="submit-button"
                            class="w-[181px] h-[59px] bg-[#2BCB4E] text-xl font-bold text-white rounded-xl border-white border"
                            style="box-shadow: 2px 4px 6px 0 gray">Simpan</button>
                    </div>
                </form>
            </div>
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
                    <tbody id="order-data-table">
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        setTimeout(function() {
            document.getElementById("popupContainer").classList.remove("hidden")
        }, 700)

        generateNomorUrut();

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

            const cariVal = document.getElementById('cari-input').value;

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
                    order.semua_ukuran.forEach((order) => {
                        optionElements +=
                            `<option value="${order.id}:${order.ukuran}:${order.stok}:${order.harga}" class="text-black">${order.ukuran}</option>`
                    })

                    return optionElements
                }
            }

            fetchData().then((orders) => orders.forEach((order, index) => {
                document.getElementById('seragam-item').innerHTML += `<div class=" h-max border-2 border border-black rounded-xl relative">
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
                                <select onchange="changeUkuran(this.value, ${index})" id='ukuran${index}' name="ukuran${index}" class="option:text-black relative appearance-none bg-transparent px-6 text-xl font-semibold text-white outline-none">
                                    <option value="${order.id}:${order.ukuran}:${order.stok}:${order.harga}" class="text-black">${order.ukuran}</option>
                                    ${returnOptionUkuran(order)}
                                </select>
                            </div>
                            <div class="border border-black rounded-lg px-1 w-full py-1 flex justify-between">
                                <button onclick="decrementQTY(${index})">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z" clip-rule="evenodd" />
                                  </svg>
                                </button>
                                <span id="qty${index}">0</span>
                                <button onclick="incrementQTY(${index})">
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
                    <button onclick="addOrderItem(this, ${index})" class="w-14 h-14 bg-green-500 flex justify-center items-center font-bold rounded-[2000px] absolute -right-5 -top-4">
                          <span class="hidden" id="order-item-${index}">${JSON.stringify({...order, QTY: 0})}</span>
                          <svg
                              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke-width="5" stroke="#ffff" class="size-9">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                          </svg>
                      </button>
                </div>`;
            }))
        })
    </script>
@endsection
