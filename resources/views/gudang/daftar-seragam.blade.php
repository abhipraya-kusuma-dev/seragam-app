@extends('layout.main')

@section('content')
    <x-navbar />
    <div class="current-page-bar-container px-[46px] mx-auto flex flex-col">
        <div class="current-page-bar flex gap-[13px] items-start">
            <a class=" py-4 px-4 bg-[#6C0345] text-white font-semibold rounded-b-lg border-black border"
                href="/gudang/seragam/bikin">Input
                Stok</a>
            <a class=" py-2 px-8  bg-[#6675F7]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6675F7] transition duration-500"
                href="/gudang/order">List
                Order</a>
            <a class=" py-2 px-8  bg-[#6F19DC]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#6F19DC] transition duration-500"
                href="/laporan/lihat-stok">Laporan Stok</a>
            <a class=" py-2 px-8  bg-[#FF6FE8]/80 text-white/60 font-semibold rounded-b-lg border-black border hover:text-white hover:bg-[#FF6FE8] transition duration-500"
                href="/laporan/lihat">Laporan Keuangan</a>
                <marquee class="select-none w-[495px]">Pekerjaan seberat apapun akan lebih terasa ringan jika kita tidak mengerjakannya🤗🤗</marquee>
        </div>
    </div>
    <section class="flex justify-between py-10 px-[46px]">
        <div class="flex flex-col gap-5">

        
            <div class="border rounded-xl border-black px-4 py-2" style="box-shadow: 2px 4px 6px rgb(177, 177, 177)">
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


                    @if (session('update-success'))
                        <script>
                            window.addEventListener('load', function() {
                                setTimeout(function() {
                                    alert('{{ session('update-success') }}');
                                }, 100); // Adjust the delay as needed
                            });
                        </script>
                    @endif
                    @if (session('update-error'))
                        <script>
                            window.addEventListener('load', function() {
                                setTimeout(function() {
                                    alert('{{ session('update-error') }}');
                                }, 100); // Adjust the delay as needed
                            });
                        </script>
                    @endif


                    @if (session('delete-success'))
                        <script>
                            window.addEventListener('load', function() {
                                setTimeout(function() {
                                    alert('{{ session('delete-success') }}');
                                }, 100); // Adjust the delay as needed
                            });
                        </script>
                    @endif
                    @if (session('delete-error'))
                        <script>
                            window.addEventListener('load', function() {
                                setTimeout(function() {
                                    alert('{{ session('delete-error') }}');
                                }, 100); // Adjust the delay as needed
                            });
                        </script>
                    @endif
            
                    @if ($errors->any())
                        <script>
                            window.addEventListener('load', function() {
                                let errors = @json($errors->all());
                                

                                function capitalizeFirstLetter(string){
                                    return string.charAt(0).toUpperCase() + string.slice(1);
                                }

                                let modifiedErrors = errors.map((error) => {
                                    return error.replace(/The (.+?) field is required\./, function(match, p1){
                                        return capitalizeFirstLetter(p1) + ' harus diisi'
                                    });
                                });

                                let errorMessages = modifiedErrors.join('\n'); // Join all errors into a single string separated by new lines
                                setTimeout(function() {
                                    alert(errorMessages);
                                }, 100);
                            });
                        </script>

                        {{-- <script>
                            document.querySelectorAll('.need-mandatory').innerHTML += `
                                <span class="text-red-600">*</span>
                            `
                        </script> --}}
                        
                    @endif
                </div>
                <form id="create-and-edit-form" action="/gudang/seragam/bikin" class="flex flex-col gap-4" method="POST">
                    <div id="method-field">

                    </div>
                    @csrf
                    <h1 class="font-bold">Jenjang</h1>
                    <div class="flex items-center gap-4">
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

                        <label for="sma"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#2BCB4E] has-[:checked]:bg-white has-[:checked]:text-[#2BCB4E] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#2BCB4E] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMA
                            <input type="checkbox" name="jenjang[]" id="sma" value="sma" class="hidden" />
                        </label>

                        <label for="smk"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#DC6B19] has-[:checked]:bg-white has-[:checked]:text-[#DC6B19] border-2 border-transparent select-none text-center rounded-[8px] py-1 px-7 bg-[#DC6B19] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            SMK
                            <input type="checkbox" name="jenjang[]" id="smk" value="smk" class="hidden" />
                        </label>
                    </div>

                    <h1 class="font-bold">Jenis Kelamin</h1>
                    <div class="flex items-center gap-4">
                        <label for="cowo"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#3485FF] has-[:checked]:bg-white has-[:checked]:text-[#3485FF] border-2 border-transparent select-none rounded-[8px] py-1 px-7 bg-[#3485FF] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            Pria
                            <input type="checkbox" name="jenis_kelamin[]" id="cowo" value="cowo" class="hidden" />
                        </label>

                        <label for="cewe"
                            class="has-[:checked]:border-2 has-[:checked]:border-[#FF34C6] has-[:checked]:bg-white has-[:checked]:text-[#FF34C6] border-2 border-2 border-transparent select-none rounded-[8px] py-1 px-5 bg-[#FF34C6] text-white font-semibold"
                            style="box-shadow: 2px 4px 5px rgb(177, 177, 177)">
                            Wanita
                            <input type="checkbox" name="jenis_kelamin[]" id="cewe" value="cewe" class="hidden" />
                        </label>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <label for="nama_barang" class="font-bold">Nama Barang</label><br>
                            <input list="list_nama_barang" id="nama_barang" name="nama_barang"
                                class="outline-none border rounded border-black px-2" />

                            <datalist id="list_nama_barang">
                                @foreach ($data as $seragam)
                                    <option value="{{ $seragam['nama_barang'] }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div>
                            <label for="ukuran" class="font-bold">Ukuran</label><br>
                            <select id="ukuran" name="ukuran"
                                class="outline-none border rounded border-black px-2 bg-transparent">
                                @foreach ($list_ukuran_fix as $ukuran)
                                    <option value="{{ $ukuran }}">{{ $ukuran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="stok" class="font-bold">Stok Awal</label><br>
                            <input id="stok" name="stok" class="outline-none border rounded border-black px-2 w-24"
                                type="number" />
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <label for="harga" class="font-bold">Harga</label><br>
                            <input id="harga" name="harga"
                                class="outline-none border rounded border-black mb-3 px-2 w-57" type="number" />
                        </div>
                    </div>

            </div>
            <div class="flex gap-5">
                <button type="submit" id="submit-button"
                    class="w-[181px] h-[59px] bg-[#2BCB4E] text-xl font-bold text-white rounded-xl border-white border"
                    style="box-shadow: 2px 4px 6px 0 gray">Simpan</button>
                <button type="button" id="cancel-button"
                    class="w-[181px] h-[59px] bg-red-600 text-xl font-bold text-white rounded-xl border-white border hidden"
                    style="box-shadow: 2px 4px 6px 0 gray">Cancel Edit</button>
            </div>
            </form>
        </div>

        <div>
            <table class="border-2 border-black">
                <thead>
                    <tr class="divide-x-2 divide-black border-b-2 border-black">
                        <th class="px-4">Nama Barang</th>
                        <th class="px-4">Ukuran</th>
                        <th class="px-4">Stok</th>
                        <th class="px-4">Harga</th>
                        <th class="px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-black">
                    @foreach ($data as $seragam)
                        <tr data-seragam="{{ $seragam['id'] }}" class="seragam-row divide-x-2 divide-black">
                            <td id="nama-barang-{{ $seragam['id'] }}" class="px-4"
                                rowspan="{{ count($seragam['semua_ukuran']) > 0 ? count($seragam['semua_ukuran']) + 1 : 1 }}">
                                {{ $seragam['nama_barang'] }}</td>
                            <td id="ukuran-{{ $seragam['id'] }}" class="px-4" align="center">{{ $seragam['ukuran'] }}</td>
                            <td id="jenjang-{{ $seragam['id'] }}" class="hidden">{{ $seragam['jenjang'] }}</td>
                            <td id="jenis-kelamin-{{ $seragam['id'] }}" class="hidden">{{ $seragam['jenis_kelamin'] }}
                            </td>
                            <td id="stok-{{ $seragam['id'] }}" class="px-4" align="center">{{ $seragam['stok'] }}</td>
                            <td id="harga-{{ $seragam['id'] }}" class="px-4">{{ $seragam['harga'] }}</td>
                            <td class="px-4 ">
                                <div class="flex gap-2">
                                    <div>
                                        <button class=" text-blue-500 hover:underline"
                                            id="edit-button-{{ $seragam['id'] }}">Edit</button>
                                    </div>
                                    <div>
                                        <h1>/</h1>
                                    </div>
                                    <div>
                                        <form action="/gudang/seragam/delete/{{ $seragam['id'] }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500 hover:underline" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @if (count($seragam['semua_ukuran']) > 0)
                            @foreach ($seragam['semua_ukuran'] as $ukuran)
                                <tr data-seragam="{{ $ukuran['id'] }}" class="seragam-row divide-x-2 divide-black">
                                    <td id="nama-barang-{{ $ukuran['id'] }}" class="hidden">{{ $ukuran['nama_barang'] }}
                                    </td>
                                    <td id="ukuran-{{ $ukuran['id'] }}" class="px-4 border-2 border-black" align="center">
                                        {{ $ukuran['ukuran'] }}</td>
                                    <td id="jenjang-{{ $ukuran['id'] }}" class="hidden">{{ $ukuran['jenjang'] }}</td>
                                    <td id="jenis-kelamin-{{ $ukuran['id'] }}" class="hidden">
                                        {{ $ukuran['jenis_kelamin'] }}</td>
                                    <td id="stok-{{ $ukuran['id'] }}" class="px-4" align="center">{{ $ukuran['stok'] }}</td>
                                    <td id="harga-{{ $ukuran['id'] }}" class="px-4">{{ $ukuran['harga'] }}</td>
                                    <td class="px-4">
                                        <div class="flex gap-2">
                                            <div>
                                                <button class="edit-button text-blue-500 hover:underline"
                                                    id="edit-button-{{ $ukuran['id'] }}">Edit</button>
                                            </div>
                                            <div>
                                                <h1>/</h1>
                                            </div>
                                            <div>
                                                <form action="/gudang/seragam/delete/{{ $ukuran['id'] }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-500 hover:underline"
                                                        type="submit">Hapus</button>
                                                </form>
                                            </div>
                                            <div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </section>
    

    <script>
        const methodField = document.getElementById("method-field");
        const createAndEditForm = document.getElementById("create-and-edit-form");
        const submitButton = document.getElementById("submit-button");
        const cancelButton = document.getElementById("cancel-button");
        const sd = document.getElementById("sd");
        const smp = document.getElementById("smp");
        const sma = document.getElementById("sma");
        const smk = document.getElementById("smk");
        const cowo = document.getElementById("cowo");
        const cewe = document.getElementById("cewe");

        const jenjang = document.querySelectorAll('input[name="jenjang[]"]');
        const jenkel = document.querySelectorAll('input[name="jenis_kelamin[]"]')

        submitButton.addEventListener('click', function(e){
            let jenjangCheck = false;

            jenjang.forEach( (checkbox) => {
                if(checkbox.checked){
                    jenjangCheck = true;
                }
            });

            let jenkelCheck = false;

            jenkel.forEach( (checkbox) => {
                if(checkbox.checked){
                    jenkelCheck = true;
                }
            });

            if(!jenjangCheck && !jenkelCheck){
                alert('Dimohon untuk mengisi Jenjang dan Jenis Kelamin');
                e.preventDefault();
            } else
            if(!jenjangCheck){
                alert('Tolong pilih setidaknya satu jenjang');
                e.preventDefault();
            } else
            if(!jenkelCheck){
                alert('Jenis kelamin belum dipilih')
                e.preventDefault();
            }

            
        });
        

        document.querySelectorAll(".seragam-row").forEach(function(row) {

            const seragamId = row.dataset.seragam
            console.log(seragamId);
            const button = document.querySelector(`#edit-button-${seragamId}`)
            console.log(button);
            button.addEventListener("click", function() {

                createAndEditForm.setAttribute('action', `/gudang/seragam/update/${seragamId}`);
                methodField.innerHTML = '<input type="hidden" name="_method" value="PATCH">'
                cancelButton.classList.remove('hidden');


                function getVal(value) {
                    return document.querySelector(value).textContent
                }

                const jenjang = getVal(`#jenjang-${seragamId}`).split(',')
                const jenisKelamin = getVal(`#jenis-kelamin-${seragamId}`).split(',')

                console.log(cowo)
                console.log(cewe)

                console.log(getVal(`#nama-barang-${seragamId}`))
                document.querySelector("input[name='nama_barang']").value = getVal(
                    `#nama-barang-${seragamId}`).trim()
                document.querySelector("select[name='ukuran']").value = getVal(`#ukuran-${seragamId}`)
                    .trim()
                document.querySelector("input[name='stok']").value = getVal(`#stok-${seragamId}`).trim()
                const hargaVal = getVal(`#harga-${seragamId}`).slice(3).split('.').join('');
                document.querySelector("input[name='harga']").value = parseInt(hargaVal)


                sd.checked = false
                smp.checked = false
                sma.checked = false
                smk.checked = false

                cowo.checked = false
                cewe.checked = false

                jenjang.forEach(function(jenjang) {
                    if (jenjang === "sd") {
                        sd.checked = true;
                    }
                    if (jenjang === "smp") {
                        smp.checked = true;
                    }
                    if (jenjang === "sma") {
                        sma.checked = true;
                    }
                    if (jenjang === "smk") {
                        smk.checked = true;
                    }
                })

                jenisKelamin.forEach(function(jenkel) {
                    if (jenkel.trim() === "cowo") {
                        cowo.checked = true
                    }
                    if (jenkel.trim() === "cewe") {
                        cewe.checked = true
                    }
                })

            })

        })


        cancelButton.addEventListener("click", function() {
            cancelButton.classList.add('hidden');
            createAndEditForm.setAttribute('action', '/gudang/seragam/bikin');
            methodField.innerHTML = '';

            document.querySelector("input[name='nama_barang']").value = ''
            document.querySelector("select[name='ukuran']").value = 'S'
            document.querySelector("input[name='stok']").value = ''
            document.querySelector("input[name='harga']").value = ''

            sd.checked = false
            smp.checked = false
            sma.checked = false
            smk.checked = false

            cowo.checked = false
            cewe.checked = false


        })
    </script>
    
@endsection
