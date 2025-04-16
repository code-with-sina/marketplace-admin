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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('super', ['superadmin', 'admin'])->default('admin');
            $table->enum('authority', ['boss', 'hr', 'director', 'senior', 'junior', 'newbie'])->default('newbie');
            $table->string('mobile')->nullable();
            $table->string('alias')->nullable();
            $table->enum('status', ['active', 'queried', 'suspended', 'revoked', 'sacked', 'intern', 'nysc', 'training', 'contract'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
