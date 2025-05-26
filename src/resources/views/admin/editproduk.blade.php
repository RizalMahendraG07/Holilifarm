@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="card">
  <h2>EDIT PRODUK</h2>
  <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Nama</label>
    <input type="text" name="name" id="name" value="{{ $product->name }}" required>

    <label for="price">Harga</label>
    <input type="number" name="price" id="price" value="{{ $product->price }}" required>

    <label for="deskripsi">Deskripsi</label>
    <input type="text" name="deskripsi" id="deskripsi" value="{{ $product->deskripsi }}" required>
    <label for="stok">Stok</label>
    <input type="number" name="stok" id="stok" value="{{ $product->stok }}" required>

   

    <label>Foto Saat Ini</label><br>
    @if($product->image)
      <img src="{{ asset($product->image) }}" alt="Foto Produk" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
    @else
      <p><i>Tidak ada foto</i></p>
    @endif

    <label for="image">Ganti Foto (Opsional)</label>
    <input type="file" name="image" id="image" accept="image/*">

    <div class="form-buttons">
      <a href="{{ route('products.index') }}" class="btn-red">KEMBALI</a>
      <button type="submit" class="btn-green">SIMPAN</button>
    </div>
  </form>
</div>
@endsection
