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
            $table->enum('status', ['Selesai', 'Proses', 'Cancel'])->default('Proses');
        });
    }
    
    public function down()
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
