<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('property_type', 40);
            $table->string('address');
            $table->string('city', 100);
            $table->string('province', 100);
            $table->string('postal_code', 10);
            $table->decimal('area_m2', 8, 2)->nullable();
            $table->unsignedSmallInteger('year_built')->nullable();
            $table->boolean('has_attic')->default(false);
            $table->boolean('has_basement')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'property_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};