<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Holili Farm</title>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />        

    <!-- Bootstrap -->
  

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.1.2/dist/full.css" rel="stylesheet" />
    <style>
        html {
            scroll-behavior: smooth;
        }
        .pagination a {
            color: #16a34a;
            background-color: #ffffff;
        }
        .pagination a:hover {
            color: rgb(3, 70, 27);
        }
        .pagination span[aria-current="page"] {
            background-color: rgb(194, 198, 208);
            color: white;
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <header  data-aos="fade-down">
  <div class="navbar bg-white relative">
    <div class="navbar-start">
      <a class="btn btn-ghost text-xl" href="#">
        <img src="/images/holili-farm-logo.png" alt="Logo" class="h-10" />
      </a>
    </div>

    <div class="navbar-center absolute left-1/2 transform -translate-x-1/2 hidden lg:flex">
      <ul class="menu menu-horizontal text-black px-1">
        <li><a href="#home" class="hover:text-green-500">Beranda</a></li>
        <li><a href="#produk" class="hover:text-green-500">Produk</a></li>
        <li><a href="#maps" class="hover:text-green-500">Lokasi</a></li>
        <li><a href="#informasi" class="hover:text-green-500">Informasi</a></li>
        <li><a href="#tentangkami" class="hover:text-green-500">Tentang Kami</a></li>
      </ul>
    </div>

    <div class="navbar-end lg:hidden">
      <div class="dropdown">
        <div tabindex="0" role="button" class="btn btn-ghost">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
          </svg>
        </div>
        <ul class="menu menu-sm dropdown-content bg-white text-black rounded-box z-10 mt-3 w-52 p-2 shadow">
          <li><a href="#home">Beranda</a></li>
          <li><a href="#produk">Produk</a></li>
          <li><a href="#maps">Lokasi</a></li>
          <li><a href="#informasi">Informasi</a></li>
          <li><a href="#tentangkami">Tentang Kami</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>


    <section id="home" class="p-6" data-aos="fade-up">
        <div class="row_home flex items-start justify-center">
            <div class="hero-content max-w-screen-xl w-full mx-auto px-20 flex flex-col items-center text-center lg:flex-row lg:text-left lg:gap-10">
                <div>
                    <h1 class="text-6xl text-green-500 font-bold mb-4">Selamat Datang Di Holili Farm</h1>
                    <p class="text-xl text-black">
                        Merupakan Sistem Informasi Perkebunan Greenhouse yang berada di Desa Ajung-Jember. Kami menyediakan berbagai produk pertanian berkualitas tinggi dengan teknologi modern untuk mendukung pertanian berkelanjutan.                    </p>
                </div>
                <img src="/images/foto_model_petani.png" class="max-w-sm rounded-lg" />
            </div>
        </div>
    </section>

    <!-- Produk Section -->
    <!-- Produk Section -->
<section id="produk" class="p-6 bg-gray-100 min-h-screen shadow-lg flex flex-col items-center" data-aos="fade-up" data-aos-duration="700">
    <div class="max-w-xl pl-10 mb-6 text-center">
        <h2 class="text-4xl font-bold text-black">Produk Kami</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center">
        @foreach($products as $product)
        <div class="card bg-base-100 w-80 shadow-lg" data-produk-id="{{ $product->id }}" data-harga="{{ $product->price }}" data-stok="{{ $product->stok }}">
            <figure class="h-60 w-full overflow-hidden">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
            </figure>
            <div class="card-body bg-white shadow-xl">
                <div class="flex items-center">
                    <h2 class="card-title font-bold text-black">{{ $product->name }}</h2>
                    <span class="ml-4 text-red-500">Rp {{ number_format($product->price, 0, ',', '.') }}/Kg</span>
                </div>
                <p class="text-justify line-clamp-3">{{ $product->deskripsi }}</p>
                <span class="text-gray-500">Stok: {{ $product->stok }} Kg</span>

                <div class="card-actions justify-end">
                    <button type="button" class="btn btn-primary bg-green-500 btn-beli">Beli</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6 pagination">{{ $products->links()}}</div>
</section>

    <!-- MODAL -->
    <!-- MODAL -->
<div id="productModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black

 bg-opacity-50 backdrop-blur-sm">
    <div class="bg-white w-[90%] max-w-md rounded-xl shadow-2xl p-6 relative">
        <figure class="h-48 w-full overflow-hidden rounded-lg mb-4">
            <img id="modalImage" src="" alt="Produk" class="h-full w-full object-cover" />
        </figure>
        <h3 class="text-xl font-semibold mb-4 text-center" id="modalTitle">Pemesanan Produk</h3>

        <form method="POST" action="{{ route('pesan.store') }}" class="space-y-4" id="orderForm" onsubmit="return handlePesan(event)">
            @csrf

            <!-- Nama Pembeli -->
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nama Pembeli</span>
                </label>
                <input type="text" name="nama_pembeli" placeholder="Nama" class="input input-bordered w-full bg-white" required />
            </div>

            <!-- Alamat -->
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <input type="text" name="alamat" placeholder="Alamat lengkap" class="input input-bordered w-full bg-white" required />
            </div>

            <!-- Nomor WhatsApp -->
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nomor WhatsApp</span>
                </label>
                <input type="tel" pattern="08[0-9]{8,12}" name="nomor_wa" placeholder="08xxxxxxxxxx" class="input input-bordered w-full bg-white" title="Masukkan nomor WA yang valid" required />
            </div>

            <!-- Jumlah Produk -->
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Jumlah Produk</span>
                </label>
                <label class="input-group">
                    <input type="number" name="jumlah_produk" id="jumlah_produk" placeholder="Jumlah" class="input input-bordered w-full bg-white" required min="1" />
                    <span>Kg</span>
                </label>
                <div id="jumlahError" class="text-red-500 text-sm mt-2 hidden" data-aos="fade-up"></div>
            </div>

            <!-- Hidden Inputs -->
            <input type="hidden" name="produk_id" id="modalProdukId" />
            <input type="hidden" name="harga_total" id="modalHargaTotal" />
            <input type="hidden" name="status" value="pending" />

            <!-- Tombol -->
            <div class="flex justify-between pt-4">
                <button type="button" class="btn btn-outline text-white bg-red-500" onclick="closeModal()">Kembali</button>
                <button type="submit" class="btn btn-primary bg-green-600">Pesan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Buka modal dan isi data produk
   // Buka modal dan isi data produk
function openModal(imageSrc, title, produkId, harga, stok) {
    document.getElementById('productModal').classList.remove('hidden');
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').innerText = `Pemesanan Produk: ${title}`;
    document.getElementById('modalProdukId').value = produkId;
    document.getElementById('modalHargaTotal').dataset.hargaPerKg = harga;
    document.getElementById('jumlah_produk').dataset.stok = stok; // Simpan stok di input jumlah_produk
}

// Tutup modal
function closeModal() {
    document.getElementById('productModal').classList.add('hidden');
    document.getElementById('orderForm').reset();
}

// Pasang event click di tombol beli
document.querySelectorAll('.btn-beli').forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const card = e.target.closest('.card');
        const imgSrc = card.querySelector('img').src;
        const title = card.querySelector('h2').innerText;
        const produkId = card.getAttribute('data-produk-id');
        const harga = card.getAttribute('data-harga');
        const stok = card.getAttribute('data-stok'); // Ambil stok

        openModal(imgSrc, title, produkId, harga, stok);
    });
});

// Validasi jumlah produk saat input berubah
document.getElementById('jumlah_produk').addEventListener('input', function () {
    const jumlah = Number(this.value);
    const stok = Number(this.dataset.stok);
    const errorMessage = document.getElementById('jumlahError');
    
    if (!errorMessage) {
        const errorDiv = document.createElement('div');
        errorDiv.id = 'jumlahError';
        errorDiv.className = 'text-red-500 text-sm mt-1';
        this.parentElement.appendChild(errorDiv);
    }
    
    if (jumlah > stok) {
        document.getElementById('jumlahError').innerText = 'Stok tidak mencukupi!';
        this.setCustomValidity('Stok tidak mencukupi!');
    } else {
        document.getElementById('jumlahError').innerText = '';
        this.setCustomValidity('');
    }
});

// Handle form submit (AJAX + redirect ke WhatsApp)
async function handlePesan(event) {
    event.preventDefault();

    const form = document.getElementById('orderForm');
    const formData = new FormData(form);

    const nama = formData.get('nama_pembeli');
    const alamat = formData.get('alamat');
    const nomor = formData.get('nomor_wa');
    const jumlah = Number(formData.get('jumlah_produk'));
    const produk = document.getElementById('modalTitle').innerText.replace('Pemesanan Produk: ', '');
    const hargaPerKg = Number(document.getElementById('modalHargaTotal').dataset.hargaPerKg);
    const stok = Number(document.getElementById('jumlah_produk').dataset.stok);
    const hargaTotal = jumlah * hargaPerKg; // Hitung total harga
    const adminWA = '6285737134160';

    // Validasi stok di frontend
    if (jumlah > stok) {
        alert('Stok tidak mencukupi!');
        return false;
    }

    // Update harga_total di form sebelum kirim
    document.getElementById('modalHargaTotal').value = hargaTotal;

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData,
        });

        const result = await response.json();

        if (!response.ok) {
            alert(result.message || 'Gagal menyimpan data!');
            return false;
        }

        const message = `Halo, saya ingin memesan produk: ${produk}\n` +
            `Nama: ${nama}\n` +
            `Alamat: ${alamat}\n` +
            `Jumlah: ${jumlah} Kg\n` +
            `Total Harga: Rp ${Number(hargaTotal).toLocaleString('id-ID')}\n` +
            `No WA: ${nomor}`;
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${adminWA}?text=${encodedMessage}`;

        showPopup(); // Tampilkan popup
        setTimeout(() => {
            window.open(whatsappUrl, '_blank');
            window.location.href = '/'; // Redirect setelah 3 detik
        }, 3000);
    } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan saat mengirim pesanan.');
    }

    return false;
}

// Tampilkan popup
function showPopup() {
    document.getElementById('popupBerhasil').classList.remove('hidden');
}

// Sembunyikan popup
function closePopup() {
    document.getElementById('popupBerhasil').classList.add('hidden');
}

</script>



</div>

<section id="informasi" class="p-6 bg-white text-black">
  <div class="text-center mb-12">
    <h2 class="text-4xl font-bold mb-2">Artikel Informasi</h2>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
      Artikel seputar budidaya anggur dan kisah inspiratif petani
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($articles as $article)
      <div class="card bg-white shadow-lg p-4">
        <img 
          src="{{ asset('storage/' . $article->foto) }}" 
          alt="{{ $article->JUDUL }}" 
          class="w-full h-48 object-cover rounded mb-4"
        />

        <h3 class="text-xl font-semibold mb-2">{{ $article->JUDUL }}</h3>
        <p class="text-justify text-gray-700 line-clamp-4">{{ $article->Deskripsi }}</p>
        <a href="{{ $article->link }}" target="_blank" class="text-green-500 hover:underline mt-2 inline-block">Baca selengkapnya</a>
      </div>
    @endforeach
  </div>
  <div class="mt-6">{{ $articles->links()}}</div>
</section>


<!-- Section Maps -->
<section id="maps" class="p-6 bg-gray-100 min-h-[400px]">
  <div class="max-w-4xl mx-auto text-center mb-6">
    <h2 class="text-4xl font-bold text-black">Lokasi</h2>
    <p class="text-gray-600 mt-2">Kunjungi kebun Holili Farm yang berada di Desa Ajung, Jember.</p>
  </div>
  <div class="flex justify-center">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3249.5852428878993!2d113.71735997401359!3d-8.216521791815875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6978becfbfbb9%3A0xe0ee078b0e9aea76!2sPembibitan%20anggur%20import%20Rowo%20indah!5e1!3m2!1sid!2sid!4v1747172404830!5m2!1sid!2sid" width="1000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</section>
<!-- Section Tentang Kami -->
<section id="tentangkami" class="p-6 bg-gray-100 text-black">
  <div class="flex flex-col md:flex-row items-center max-w-5xl mx-auto">
    <!-- Gambar -->
    <div class="md:w-1/2 mb-6 md:mb-0 md:mr-8">
      <img src="/images/green house.jpg" alt="Tentang Kami" class="w-full rounded-lg shadow-lg" />
    </div>

    <!-- Deskripsi -->
    <div class="md:w-1/2">
      <h2 class="text-4xl font-bold mb-4">Tentang Kami</h2>
      <p class="text-justify text-gray-700 leading-relaxed">
        Holili Farm adalah sistem informasi perkebunan modern yang berbasis Greenhouse dan berlokasi di Desa Ajung, Jember. Kami berkomitmen menyediakan produk pertanian berkualitas tinggi serta teknologi pemantauan yang memudahkan petani dalam merawat tanaman mereka. Dengan semangat inovasi dan keberlanjutan, kami ingin menjadi pelopor pertanian cerdas di Indonesia.
      </p>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-green-600 text-white py-8">
  <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
    <!-- Logo -->
    <div>
      <h3 class="text-2xl font-bold mb-2">Holili Farm</h3>
      <p class="text-sm">Pertanian ramah lingkungan berbasis teknologi di Jember.</p>
    </div>
    
    <!-- Sosial Media -->
    <div>
      <h4 class="font-semibold mb-2">Ikuti Kami</h4>
      <ul class="space-y-1">
        <li><a href="#" class="hover:underline">Instagram: @holilifarm</a></li>
        <li><a href="#" class="hover:underline">Facebook: Holili Farm</a></li>
        <li><a href="#" class="hover:underline">YouTube: Holili Farm Channel</a></li>
      </ul>
    </div>

    <!-- Kontak -->
    <div>
      <h4 class="font-semibold mb-2">Kontak</h4>
      <p>Belakang Balai Desa, RT.1/RW.3, Rowo, Rowo Indah, Kec. Ajung, Kabupaten Jember, Jawa Timur 68175</p>
      <p>WA: 0812-3456-7890</p>
      <p>Email: info@holilifarm.com</p>
    </div>
  </div>

  <div class="text-center text-sm mt-8 text-gray-200">
    &copy; 2025 Holili Farm. All rights reserved.
  </div>
</footer>
<div id="popupBerhasil" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm text-center">
        <h2 class="text-2xl font-bold text-green-600 mb-4">Pesanan Berhasil!</h2>
        <p class="text-gray-700 mb-4">Anda akan diarahkan ke WhatsApp untuk konfirmasi.</p>
        <button onclick="closePopup()" class="btn bg-green-500 text-white hover:bg-green-700">Oke</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800, // durasi animasi
    once: true,    // animasi cuma sekali
  });
</script>

</body>
</html>