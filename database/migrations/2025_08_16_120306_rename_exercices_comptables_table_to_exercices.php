<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('exercices', 'exercices');
    }
    public function down(): void
    {
        Schema::rename('exercices', 'exercices');
    }
};
