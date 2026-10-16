<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();

             
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->index();
            $table->string('phone', 30)->nullable();

             
            $table->string('postal_code', 10)->index();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();

             
            $table->string('property_type', 50);
            $table->decimal('area_m2', 8, 2)->nullable();
            $table->year('year_built')->nullable();
            $table->boolean('has_attic')->default(false);
            $table->boolean('has_basement')->default(false);
            $table->string('access_type', 30)->nullable();

             
            $table->text('message')->nullable();
            $table->string('status', 30)->default('nuevo')->index();
            $table->string('source', 50)->default('web');
            $table->boolean('is_covered')->default(true);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();

            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index(['email', 'postal_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
