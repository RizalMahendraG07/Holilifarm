@extends('layouts.app')

@section('title', 'Edit Informasi')

@section('content')
<div class="card">
  <h2>EDIT INFORMASI</h2>
  <form action="{{ route('informasi.update', $informasi->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="Judul">Judul</label>
    <input type="text" name="Judul" id="Judul" value="{{ $informasi->JUDUL }}" required>

    <label for="Deskripsi">Deskripsi</label>
    <input type="text" name="Deskripsi" id="Deskripsi" value="{{ $informasi->Deskripsi }}" required>

    <label for="Tanggal">Tanggal</label>
    <input type="date" name="Tanggal" id="Tanggal" value="{{ $informasi->Tanggal }}" required>

    {{-- Tampilkan foto lama jika ada --}}
    @if($informasi->foto)
      <p>Foto Saat Ini:</p>
      <img src="{{ asset('storage/' . $informasi->foto) }}" alt="Foto Informasi" width="150">
    @endif

    <label for="foto">Ganti Foto (OPSIONAL)</label>
    <input type="file" name="foto" id="foto" accept="image/*">

    <label for="link">Link Artikel</label>
  <input type="text" name="link" id="link" value="{{ $informasi->link }}"required>

    <div class="form-buttons">
      <a href="{{ route('informasi.index') }}" class="btn-red">KEMBALI</a>
      <button type="submit" class="btn-green">SIMPAN</button>
    </div>
  </form>
</div>
@endsection
