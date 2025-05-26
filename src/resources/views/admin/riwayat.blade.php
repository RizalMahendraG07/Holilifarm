@extends('layouts.app')

@section('title', 'Riwayat - Holili Farm')

@section('content')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form-riwayat').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const buyer = form.getAttribute('data-buyer');
        Swal.fire({
          title: 'Hapus riwayat ' + buyer + '?',
          text: 'Data riwayat akan dihapus permanen!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then(result => {
          if (result.isConfirmed) form.submit();
        });
      });
    });
    @if(session('success'))
      Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}" });
    @endif
  });
</script>
@endpush

<div class="header">
  <h1>RIWAYAT</h1>
  <a href="{{ route('riwayat.create') }}" class="add-btn">+</a>
</div>

<form method="GET" action="{{ route('riwayat.index') }}" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
  <div>
    <label for="filter">Filter Waktu:</label><br>
    <select name="filter" id="filter" onchange="this.form.submit()">
      <option value="">Semua</option>
      <option value="harian" {{ request('filter')=='harian'?'selected':'' }}>Hari Ini</option>
      <option value="mingguan" {{ request('filter')=='mingguan'?'selected':'' }}>Minggu Ini</option>
      <option value="bulanan" {{ request('filter')=='bulanan'?'selected':'' }}>Bulan Ini</option>
      <option value="tahunan" {{ request('filter')=='tahunan'?'selected':'' }}>Tahun Ini</option>
    </select>
  </div>

  <div>
    <label for="status">Filter Status:</label><br>
    <select name="status" id="status" onchange="this.form.submit()">
      <option value="">Semua</option>
      <option value="Proses" {{ request('status')=='Proses'?'selected':'' }}>Diproses</option>
      <option value="Selesai" {{ request('status')=='Selesai'?'selected':'' }}>Selesai</option>
      <option value="Cancel" {{ request('status')=='Cancel'?'selected':'' }}>Dibatalkan</option>
    </select>
  </div>
</form>


<ul class="product-list">
  @foreach ($riwayat as $index => $item)
    <li>
      <div style="flex: 2;">
        <h3>Nama</h3>
        <p class="deskripsi">{{ $item->nama_pembeli }}</p>
      </div>

      <div style="flex: 2; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        <h3>Alamat</h3>
        <p class="deskripsi">{{ $item->alamat }}</p>
      </div>

      <div style="flex: 2;">
        <h3>Produk</h3>
        <p class="deskripsi">{{ optional($item->product)->name ?? 'Produk Tidak Ditemukan' }}</p>
      </div>

      <div style="flex: 2;">
        <h3>Jumlah</h3>
        <p class="deskripsi">{{ $item->jumlah_produk }} Kg</p>
      </div>

      <div style="flex: 2;">
        <h3>Total Harga</h3>
        <p class="deskripsi">Rp{{ number_format($item->harga_total, 0, ',', '.') }}</p>
      </div>

      <div style="flex: 2;">
        <h3>Tanggal</h3>
        <p class="deskripsi">{{ $item->created_at->format('d-m-Y') }}</p>
      </div>

      <div style="flex: 2;">
        <h3>Status</h3>
        <p class="deskripsi">{{ $item->status }}</p>
      </div>

      <div class="actions">
        <a href="{{ route('riwayat.edit', $item->id) }}" class="edit">✏️</a>
        <form action="{{ route('riwayat.destroy', $item->id) }}" method="POST" class="delete-form-riwayat" data-buyer="{{ $item->nama_pembeli }}">
          @csrf
          @method('DELETE')
          <button class="delete">🗑️</button>
        </form>
      </div>
    </li>
  @endforeach
</ul>

@endsection