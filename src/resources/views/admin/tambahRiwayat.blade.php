@extends('layouts.app')

@section('title', 'Tambah Riwayat')

@section('content')
<div class="card">
  <h2>TAMBAH RIWAYAT</h2>
  <form id="formTambahRiwayat" action="{{ route('riwayat.store') }}" method="POST">
    @csrf

    <label for="nama_pembeli">Nama Pembeli</label>
    <input type="text" name="nama_pembeli" id="nama_pembeli" value="{{ old('nama_pembeli') }}">

    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}">

    <label for="produk_id">Produk</label>
    <select name="produk_id" id="produk_id">
        <option value="" disabled selected>Pilih Produk</option>
        @foreach ($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
              {{ old('produk_id') == $product->id ? 'selected' : '' }}>
              {{ $product->name }}
            </option>
        @endforeach
    </select>

    <label for="jumlah_produk">Jumlah Produk</label>
    <input type="number" name="jumlah_produk" id="jumlah_produk" value="{{ old('jumlah_produk') }}">

    <label for="harga_total">Total Harga</label>
    <input type="text" name="harga_total" id="harga_total" value="{{ old('harga_total') }}" readonly>

    <label for="status">Status</label>
    <select name="status" id="status">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const produkSelect = document.getElementById('produk_id');
  const jumlahInput = document.getElementById('jumlah_produk');
  const totalHargaInput = document.getElementById('harga_total');

  function updateHargaTotal() {
    const selectedOption = produkSelect.options[produkSelect.selectedIndex];
    const hargaPerItem = parseInt(selectedOption?.getAttribute('data-price')) || 0;
    const jumlah = parseInt(jumlahInput.value) || 0;
    const total = hargaPerItem * jumlah;
    totalHargaInput.value = total;
  }

  produkSelect.addEventListener('change', updateHargaTotal);
  jumlahInput.addEventListener('input', updateHargaTotal);
  window.addEventListener('DOMContentLoaded', updateHargaTotal);

  document.getElementById('formTambahRiwayat').addEventListener('submit', function(e) {
    const namaPembeli = document.getElementById('nama_pembeli').value.trim();
    const alamat = document.getElementById('alamat').value.trim();
    const produk = produkSelect.value;
    const jumlah = jumlahInput.value.trim();
    const status = document.getElementById('status').value.trim();

    if (!namaPembeli || !alamat || !produk || !jumlah || !status) {
      e.preventDefault(); // hentikan form submit
      Swal.fire({
        icon: 'warning',
        title: 'Form Belum Lengkap!',
        text: 'Harap isi semua field terlebih dahulu.',
        confirmButtonColor: '#ffc107'
      });
    }
  });
</script>
@endsection
