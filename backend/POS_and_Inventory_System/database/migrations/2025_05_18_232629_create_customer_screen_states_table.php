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
        Schema::create('customer_screen_states', function (Blueprint $table) {
            $table->id();
            $table->string('screen_key')->unique(); // e.g. 'main'
            $table->decimal('amount_given', 10, 2)->default(0);
            $table->decimal('cart_total', 10, 2)->default(0);
            $table->boolean('show_change')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_screen_states');
    }
};
