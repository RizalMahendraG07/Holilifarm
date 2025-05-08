@extends('layouts.app')

@section('title', 'Tambah Riwayat')

@section('content')
<div class="card">
  <h2>TAMBAH RIWAYAT</h2>
  <form action="{{ route('riwayat.store') }}" method="POST">
    @csrf

    <label for="nama_pembeli">Nama Pembeli</label>
    <input type="text" name="nama_pembeli" id="nama_pembeli" value="{{ old('nama_pembeli') }}" required>

    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" required>

    <label for="produk_id">Produk</label>
    <select name="produk_id" id="produk_id" required>
        <option  value="" disabled selected>Pilih Produk</option>
      @foreach ($products as $product)
          <option value="{{ $product->id }}" data-price="{{ $product->price }}"
            {{ old('produk_id') == $product->id ? 'selected' : '' }}>
            {{ $product->name }}
        </option>
    @endforeach

</select>

    <label for="jumlah_produk">Jumlah Produk</label>
    <input type="number" name="jumlah_produk" id="jumlah_produk" value="{{ old('jumlah_produk') }}" required>

    <label for="harga_total">Total Harga</label>
    <input type="text" name="harga_total" id="harga_total" value="{{ old('harga_total') }}" readonly>
<label for="status">Status</label>
<select name="status" id="status" required>
    <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
    <option value="Cancel" {{ old('status') == 'Cancel' ? 'selected' : '' }}>Cancel</option>
</select>

    <div class="form-buttons">
      <a href="{{ route('riwayat.index') }}" class="btn-red">KEMBALI</a>
      <button type="submit" class="btn-green">TAMBAH</button>
    </div>
  </form>
</div>

<script>
  const produkSelect = document.getElementById('produk_id');
  const jumlahInput = document.getElementById('jumlah_produk');
  const totalHargaInput = document.getElementById('harga_total');

  function updateHargaTotal() {
    const selectedOption = produkSelect.options[produkSelect.selectedIndex];
    const hargaPerItem = parseInt(selectedOption.getAttribute('data-price')) || 0;
    const jumlah = parseInt(jumlahInput.value) || 0;
    const total = hargaPerItem * jumlah;
    totalHargaInput.value = total;
  }

  produkSelect.addEventListener('change', updateHargaTotal);
  jumlahInput.addEventListener('input', updateHargaTotal);
  window.addEventListener('DOMContentLoaded', updateHargaTotal); // Hitung otomatis saat halaman dimuat
</script>
@endsection
