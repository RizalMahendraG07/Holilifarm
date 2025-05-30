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
        Schema::table('informasis', function (Blueprint $table) {
            $table->text('link')->nullable()->after('foto');
        });
    }

    public function down()
    {
        Schema::table('informasis', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }

    /**
     * Reverse the migrations.
     */

};
