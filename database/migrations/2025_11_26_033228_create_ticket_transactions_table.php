<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_category_id')->constrained('ticket_categories');
            $table->string('transaction_code')->unique(); // KODE BOOKING
            $table->date('visit_date');
            $table->integer('total_ticket');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending'); // pending, paid, used
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable(); // Bukti TF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_transactions');
    }
};
