<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Kolom primary key
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->string('name'); // Nama produk
            $table->string('image_url')->nullable(); // URL gambar produk
            $table->decimal('price', 10, 2); // Harga produk
            $table->integer('quantity')->default(1); // Jumlah produk
            $table->timestamps(); // Kolom created_at dan updated_at

            // Tambahkan foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
