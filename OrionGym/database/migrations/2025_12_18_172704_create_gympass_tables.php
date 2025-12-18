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
        Schema::create('gympass_checkins', function (Blueprint $table) {
            $table->id();
            $table->string('gympass_id')->unique(); // ID do check-in no Gympass
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->json('response_data')->nullable(); // Dados completos do webhook
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('gympass_id')->nullable()->unique()->after('email'); // ID do usuário no Gympass
            $table->boolean('is_gympass')->default(false)->after('gympass_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gympass_id', 'is_gympass']);
        });

        Schema::dropIfExists('gympass_checkins');
    }
};
