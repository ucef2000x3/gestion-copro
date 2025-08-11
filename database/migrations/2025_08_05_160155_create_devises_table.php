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
        Schema::create('devises', function (Blueprint $table) {
            $table->id('id_devise');
            $table->string('nom'); // Ex: "Euro", "US Dollar", "Swiss Franc"
            $table->string('code', 3)->unique(); // Ex: "EUR", "USD", "CHF"
            $table->string('symbole', 5); // Ex: "€", "$", "CHF"
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devises');
    }
};
