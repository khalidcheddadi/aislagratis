<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->boolean('is_owner')->nullable();
            $table->string('eligibility_property_kind', 30)->nullable();
            $table->string('eligibility_zone', 100)->nullable();
            $table->string('eligibility_access', 100)->nullable();
            $table->string('eligibility_habitable', 100)->nullable();
            $table->string('eligibility_age', 40)->nullable();
            $table->string('eligibility_prior_aid', 20)->nullable();
            $table->string('contact_preference', 50)->nullable();
            $table->string('cadastral_reference', 30)->nullable();
            $table->timestamp('privacy_accepted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'is_owner',
                'eligibility_property_kind',
                'eligibility_zone',
                'eligibility_access',
                'eligibility_habitable',
                'eligibility_age',
                'eligibility_prior_aid',
                'contact_preference',
                'cadastral_reference',
                'privacy_accepted_at',
            ]);
        });
    }
};
