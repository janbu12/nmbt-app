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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('pickup_date');
            $table->date('return_date');
            $table->integer('days')->nullable();
            $table->enum('status_rent', ['unpaid','process', 'ready_pickup', 'renting', 'done', 'cancelled']);
            $table->double('total_price');
            $table->string('payment_method')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
