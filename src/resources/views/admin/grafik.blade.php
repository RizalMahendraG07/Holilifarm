@extends('layouts.app')

@section('title', 'Dashboard - Holili Farm')

@section('content')
<div class="header">
  <h1>DASHBOARD</h1>
  
</div>
<div class="container mt-4">


    <div class="row mt-4 custom-card-container">
        <!-- Total Produk -->
        <div class="col-md-3 mb-4">
            <a href="{{ route('products.index') }}" class="custom-card-link">
                <div class="custom-card custom-card-product custom-hover-shadow">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Jumlah Produk</h5>
                        <p class="custom-card-text">{{ $productCount }} Produk</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Total Riwayat -->
       

        <!-- Penghasilan Harian -->
        <div class="col-md-3 mb-4">
        <a href="{{ route('riwayat.index', ['filter' => 'harian']) }}" class="custom-card-link">

                <div class="custom-card custom-card-daily-income custom-hover-shadow">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Penghasilan Harian</h5>
                        <p class="custom-card-text">Rp{{ number_format($dailyIncome, 0, ',', '.') }}</p>
                    </div>
                </div>
            </a>
        </div>

 <div class="col-md-3 mb-4">
            <a href="{{ route('informasi.index') }}" class="custom-card-link">
                <div class="custom-card custom-card-informasi custom-hover-shadow">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Jumlah Informasi</h5>
                        <p class="custom-card-text">{{ $informasiCount }} Artikel</p>
                    </div>
                </div>
            </a>
        </div>
        <!-- Penghasilan Mingguan -->
        <div class="col-md-3 mb-4">
        <a href="{{ route('riwayat.index', ['filter' => 'mingguan']) }}" class="custom-card-link">
                <div class="custom-card custom-card-weekly-income custom-hover-shadow">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Penghasilan Mingguan</h5>
                        <p class="custom-card-text">Rp{{ number_format($weeklyIncome, 0, ',', '.') }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-4 custom-card-container">
        <!-- Penghasilan Bulanan -->
        <div class="col-md-3 mb-4">
        <a href="{{ route('riwayat.index', ['filter' => 'bulanan']) }}" class="custom-card-link">

                <div class="custom-card custom-card-monthly-income custom-hover-shadow">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Penghasilan Bulanan</h5>
                        <p class="custom-card-text">Rp{{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Penghasilan Tahunan -->
        <div class="col-md-3 mb-4">
        <a href="{{ route('riwayat.index', ['filter' => 'tahunan']) }}" class="custom-card-link">

                <div class="custom-card custom-card-yearly-income custom-hover-shadow">
                    <div class="custom-card-body">
                        <h5 class="custom-card-title">Penghasilan Tahunan</h5>
                        <p class="custom-card-text">Rp{{ number_format($yearlyIncome, 0, ',', '.') }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Menambahkan efek hover pada card */
  


    .custom-hover-shadow {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .custom-hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .custom-card-link {
        text-decoration: none;
        color: inherit;
    }

    .custom-card-link:hover {
        color: inherit;
        text-decoration: none;
    }

    /* Styling untuk Card */
    .custom-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 15px;
        min-width: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 180px;  /* Mengatur tinggi card */
    }

    .custom-card-title {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .custom-card-text {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-top: 10px;
    }

    /* Card Background Colors */
    .custom-card-product {
        background-color: #f1c40f;
        color: #fff;
    }

    .custom-card-informasi {
        background-color: #3498db;
        color: #fff;
    }

    .custom-card-daily-income {
        background-color: #2ecc71;
        color: #fff;
    }

    .custom-card-weekly-income {
        background-color: #e74c3c;
        color: #fff;
    }

    .custom-card-monthly-income {
        background-color: #9b59b6;
        color: #fff;
    }

    .custom-card-yearly-income {
        background-color: #f39c12;
        color: #fff;
    }

    /* Flexbox layout untuk custom-card-container */
    .custom-card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
        
    }

    .custom-card-container .col-md-3 {
        padding: 0 15px; /* Menambahkan padding horizontal untuk merapikan */
    }

    /* Responsiveness untuk tampilan lebih kecil */
    @media (max-width: 768px) {
        .custom-card {
            width: 48%; /* Membuat card lebih kecil pada layar sedang */
        }
    }

    @media (max-width: 480px) {
        .custom-card {
            width: 100%; /* Membuat card satu kolom pada layar kecil */
        }
    }
</style>
@endpush
