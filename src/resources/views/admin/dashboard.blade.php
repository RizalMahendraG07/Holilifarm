@extends('layouts.app')

@section('title', 'Produk - Holili Farm')

@section('content')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah submit langsung

        const productName = form.getAttribute('data-nama');

        Swal.fire({
          title: 'Apakah kamu yakin?',
          text: "Produk \"" + productName + "\" akan dihapus permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });
</script>
@endpush

@if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasill!',
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

<div class="header">
  <h1>PRODUK</h1>
  <a href="{{ route('products.create') }}" class="add-btn">+</a>
</div>

<ul class="product-list">
  @foreach ($products as $index => $product)
    <li>
      <div class="product-info">
        @if($product->image)
        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image">
        @else
          <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="product-image">
        @endif
        <div class="product-details">
          <span>{{ $product->name }}</span>
          <span>Rp. {{ number_format($product->price, 0, ',', '.') }} /Kg</span>
          <span class="deskripsi">{{ $product->deskripsi }}</span>
          <span class="stok">Stok: {{ $product->stok }} Kg</span>
        </div>
      </div>
      <div class="actions">
        <a href="{{ route('products.edit', $product->id) }}" class="edit">✏️</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" data-nama="{{ $product->name }}">
          @csrf
          @method('DELETE')
          <button class="delete">🗑️</button>
        </form>
      </div>
    </li>
  @endforeach
</ul>

@endsection
