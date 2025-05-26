<!-- resources/views/admin/informasi.blade.php -->
@extends('layouts.app')

@section('title', 'Informasi - Holili Farm')

@section('content')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Delete confirmation for informasi
    document.querySelectorAll('.delete-form-info').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const title = form.getAttribute('data-judul');

        Swal.fire({
          title: 'Apakah kamu yakin?',
          text: "Informasi '" + title + "' akan dihapus permanen!",
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

    // Session alerts
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#28a745'
      });
    @endif

    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        confirmButtonColor: '#dc3545'
      });
    @endif
  });
</script>
@endpush

<div class="header">
  <h1>INFORMASI</h1>
  <a href="{{ route('informasi.create') }}" class="add-btn">+</a>
</div>

<ul class="product-list">
  @foreach ($informasi as $index => $info)
    <li style="display: flex; align-items: center; gap: 20px;">
      @if ($info->foto)
        <img src="{{ asset('storage/' . $info->foto) }}" alt="Foto Informasi" class="product-image">
      @else
        <img src="{{ asset('images/default.jpg') }}" alt="Default" class="product-image placeholder">
      @endif

      <div class="product-details">
        <span>{{ $index + 1 }}. {{ $info->JUDUL }}</span>
        <span class="deskripsi">{{ $info->Deskripsi }}</span>
      </div>

      <div class="actions">
        <a href="{{ route('informasi.edit', $info->id) }}" class="edit">✏️</a>
        <form action="{{ route('informasi.destroy', $info->id) }}" method="POST" class="delete-form-info" data-judul="{{ $info->Judul }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="delete">🗑️</button>
        </form>
      </div>
    </li>
  @endforeach
</ul>

@endsection
