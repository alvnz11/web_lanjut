<?php // tag php

use Illuminate\Database\Migrations\Migration; // import class Migration
use Illuminate\Database\Schema\Blueprint; // import class Blueprint
use Illuminate\Support\Facades\Schema; // import class Schema

return new class extends Migration // create class yang meng-extend class Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // membuat fungsi up untuk membuat table
    {
        Schema::create('items', function (Blueprint $table) { // membuat table items
            $table->id(); // membuat kolom id
            $table->string('name'); // membuat kolom name dengan tipe data string
            $table->text('description'); // membuat kolom deskripsi dengan tipe data text
            $table->timestamps(); // membuat kolom timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
