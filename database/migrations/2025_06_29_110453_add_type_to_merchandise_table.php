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
        Schema::table('merchandise', function (Blueprint $table) {
            $table->string('type')->nullable()->after('description'); // tambahkan di posisi yang diinginkan
        });
    }

    public function down()
    {
        Schema::table('merchandise', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
