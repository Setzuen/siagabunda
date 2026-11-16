<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pregnancy_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('hpht')->nullable();
            $table->date('due_date')->nullable();
            $table->string('blood_type', 10)->nullable();
            $table->string('referral_hospital')->default('RSIA Kasih Bunda');
            $table->string('gravida_para', 20)->default('G1P0A0');
            $table->enum('risk_level', ['rendah', 'sedang', 'tinggi'])->default('rendah');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pregnancy_profiles');
    }
};
