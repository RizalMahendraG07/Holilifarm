@extends('layouts.app') <!-- Sesuaikan dengan nama file layout-mu -->

@section('title', 'Tambah Informasi')

@section('content')
<div class="card">
  <h2>Tambah Informasi</h2>
  <form id="formTambahInformasi" action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="Judul">Judul</label>
    <input type="text" name="Judul" id="Judul">

    <label for="Deskripsi">Deskripsi</label>
    <input type="text" name="Deskripsi" id="Deskripsi">

    <label for="Tanggal">Tanggal</label>
    <input type="date" name="Tanggal" id="Tanggal">

    <label for="foto">Foto</label>
    <input type="file" name="foto" id="foto" accept="image/*">

    <label for="link">Link Artikel</label>
    <input type="text" name="link" id="link">

    <div class="form-buttons">
      <a href="{{ route('informasi.index') }}" class="btn-red">KEMBALI</a>
      <button type="submit" class="btn-green">TAMBAH</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('formTambahInformasi').addEventListener('submit', function(e) {
    const judul = document.getElementById('Judul').value.trim();
    const deskripsi = document.getElementById('Deskripsi').value.trim();
    const tanggal = document.getElementById('Tanggal').value.trim();
    const link = document.getElementById('link').value.trim();

    // Foto tidak wajib diisi, jadi tidak divalidasi kosong
    if (!judul || !deskripsi || !tanggal || !link) {
      e.preventDefault(); // hentikan submit
      Swal.fire({
        icon: 'warning',
        title: 'Form Belum Lengkap!',
        text: 'Harap isi semua field wajib terlebih dahulu.',
        confirmButtonColor: '#ffc107'
      });
    }
  });
</script>
@endsection
