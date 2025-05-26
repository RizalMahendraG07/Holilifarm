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
        $table->dropColumn('produk');
    });
}

public function down()
{
    Schema::table('riwayats', function (Blueprint $table) {
        $table->string('produk')->nullable();
    });
}

};
