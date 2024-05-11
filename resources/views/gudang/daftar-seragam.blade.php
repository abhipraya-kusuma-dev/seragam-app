@extends('layout.main')

@section('content')
<section class="flex justify-between p-10">
  <div>
    <form class="flex flex-col gap-4">
      <div>
        <label for="sd"
          class="has-[:checked]:border-2 has-[:checked]:border-yellow-600 py-2 select-none px-4 bg-red-600 text-white">
          SD
          <input tabindex="1" type="checkbox" name="jenjang[]" id="sd" value="sd" class="hidden" />
        </label>

        <label for="smp"
          class="has-[:checked]:border-2 has-[:checked]:border-yellow-600 py-2 select-none px-4 bg-blue-600 text-white">
          SMP
          <input type="checkbox" name="jenjang[]" id="smp" value="smp" class="hidden" />
        </label>

        <label for="sma"
          class="has-[:checked]:border-2 has-[:checked]:border-yellow-600 py-2 select-none px-4 bg-cyan-200 text-green-600">
          SMA
          <input type="checkbox" name="jenjang[]" id="sma" value="sma" class="hidden" />
        </label>

        <label for="smk"
          class="has-[:checked]:border-2 has-[:checked]:border-yellow-600 py-2 select-none px-4 bg-purple-600 text-white">
          SMK
          <input type="checkbox" name="jenjang[]" id="smk" value="smk" class="hidden" />
        </label>
      </div>

      <div>
        <label for="cowo"
          class="has-[:checked]:border-2 has-[:checked]:border-yellow-600 py-2 select-none px-4 bg-cyan-200 text-green-600">
          Laki Laki
          <input type="checkbox" name="jenis_kelamin[]" id="cowo" value="cowo" class="hidden" />
        </label>

        <label for="cewe"
          class="has-[:checked]:border-2 has-[:checked]:border-yellow-600 py-2 select-none px-4 bg-purple-600 text-white">
          Perempuan
          <input type="checkbox" name="jenis_kelamin[]" id="cewe" value="cewe" class="hidden" />
        </label>
      </div>

      <div>
        <label for="nama_barang">Nama Barang</label>
        <input list="list_nama_barang" id="nama_barang" name="nama_barang" class="outline-none border" />

        <datalist id="list_nama_barang">
          @foreach ($data as $seragam)
          <option value="{{ $seragam['nama_barang'] }}"></option>
          @endforeach
        </datalist>
      </div>

      <div>
        <label for="ukuran">Ukuran</label>
        <select id="ukuran" name="ukuran">
          @foreach ($list_ukuran_fix as $ukuran)
          <option value="{{ $ukuran }}">{{ $ukuran }}</option>
          @endforeach
        </select>
      </div>

    </form>
  </div>

  <div>
    <table class="border">
      <thead>
        <tr class="divide-x-2 border-b-2">
          <th class="px-4">Nama Barang</th>
          <th class="px-4">Ukuran</th>
          <th class="px-4">Stok</th>
          <th class="px-4">Harga</th>
          <th class="px-4">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y-2">
        @foreach ($data as $seragam)
        <tr class="divide-x-2">
          <td class="px-4"
            rowspan="{{ count($seragam['semua_ukuran']) > 0 ? count($seragam['semua_ukuran']) + 1 : 1 }}">
            {{ $seragam['nama_barang'] }}</td>
          <td class="px-4">{{ $seragam['ukuran'] }}</td>
          <td class="px-4">{{ $seragam['stok'] }}</td>
          <td class="px-4">{{ $seragam['harga'] }}</td>
          <td class="px-4">
            <button>Edit</button>
            <form action="/gudang/seragam/hapus/{{ $seragam['id'] }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit">Hapus</button>
            </form>
          </td>
        </tr>
        @if (count($seragam['semua_ukuran']) > 0)
        @foreach ($seragam['semua_ukuran'] as $ukuran)
        <tr class="divide-x-2">
          <td class="px-4">{{ $ukuran['ukuran'] }}</td>
          <td class="px-4">{{ $ukuran['stok'] }}</td>
          <td class="px-4">{{ $ukuran['harga'] }}</td>
          <td class="px-4">
            <button>Edit</button>
            <form action="/gudang/seragam/hapus/{{ $ukuran['id'] }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</section>
@endsection
