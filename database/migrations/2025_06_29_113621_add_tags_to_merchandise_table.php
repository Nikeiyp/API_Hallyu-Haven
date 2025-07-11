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
            $table->string('tags')->nullable()->after('type');
        });
    }

    public function down()
    {
        Schema::table('merchandise', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
};
