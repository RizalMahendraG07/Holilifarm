<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('riwayats', function (Blueprint $table) {
        $table->unsignedBigInteger('produk_id')->nullable()->after('alamat');
        $table->foreign('produk_id')->references('id')->on('products')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('riwayats', function (Blueprint $table) {
        if (Schema::hasColumn('riwayats', 'produk_id')) {
            $table->dropForeign(['produk_id']);
            $table->dropColumn('produk_id');
        }
    });
}


};
