@extends('layouts.app') <!-- Sesuaikan dengan nama file layout-mu -->

@section('title', 'Tambah Produk')

@section('content')
@if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: "{{ session('success') }}",
      confirmButtonColor: '#28a745'
    });
  </script>
@endif

@if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: "{{ session('error') }}",
      confirmButtonColor: '#dc3545'
    });
  </script>
@endif

<div class="card">
  <h2>TAMBAH PRODUK</h2>
  <form id="formTambahProduk" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">Nama</label>
    <input type="text" name="name" id="name">

    <label for="price">Harga</label>
    <input type="number" name="price" id="price">

    <label for="image">Foto Produk</label>
    <input type="file" name="image" id="image" accept="image/*">

    <label for="deskripsi">Deskripsi</label>
    <input type="text" name="deskripsi" id="deskripsi">

    <label for="stok">Stok</label>
    <input type="number" name="stok" id="stok">

    <div class="form-buttons">
      <a href="{{ route('dashboard') }}" class="btn-red">KEMBALI</a>
      <button type="submit" class="btn-green">TAMBAH</button>
    </div>
  </form>
</div>

<script>
  document.getElementById('formTambahProduk').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const price = document.getElementById('price').value.trim();
    const image = document.getElementById('image').files.length;
    const deskripsi = document.getElementById('deskripsi').value.trim();
    const stok = document.getElementById('stok').value.trim();

    if (!name || !price || !image || !deskripsi || !stok) {
      e.preventDefault(); // menghentikan form dari submit
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
