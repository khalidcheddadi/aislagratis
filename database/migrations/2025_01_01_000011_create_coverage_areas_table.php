<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coverage_areas', function (Blueprint $table) {
            $table->id();
            $table->string('postal_code', 10)->index();
            $table->string('city', 100);
            $table->string('province', 100)->index();
            $table->boolean('is_covered')->default(true)->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['postal_code', 'city']);
            $table->index(['province', 'is_covered']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coverage_areas');
    }
};
