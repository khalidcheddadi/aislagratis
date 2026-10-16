<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->restrictOnDelete();
            $table->date('installation_date')->index();
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('subsidy_amount', 12, 2)->default(0);
            $table->string('status', 30)->default('programada')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'installation_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installations');
    }
};
