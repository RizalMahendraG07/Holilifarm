<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'deskripsi', 'image', 'stok']; 

    public function riwayats()
{
    return $this->hasMany(Riwayat::class, 'produk_id');
}

}