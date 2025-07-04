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
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchandise_id');
            $table->string('image'); // nama file atau path
            $table->timestamps();

            $table->foreign('merchandise_id')->references('id')->on('merchandise')->onDelete('cascade');
        });
    }

};
