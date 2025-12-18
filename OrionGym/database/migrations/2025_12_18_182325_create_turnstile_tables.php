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
        Schema::create('turnstile_commands', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->text('data');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->text('result_message')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('turnstile_events', function (Blueprint $table) {
            $table->id();
            $table->enum('event_type', ['entry', 'exit', 'denied', 'error']);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->string('card_number')->nullable();
            $table->enum('direction', ['entry', 'exit']);
            $table->timestamp('timestamp');
            $table->boolean('success');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->index('timestamp');
            $table->index('event_type');
        });

        Schema::table('users', function (Blueprint $table) {
            // card_number already exists from previous migration
            if (!Schema::hasColumn('users', 'turnstile_password')) {
                $table->string('turnstile_password', 20)->nullable();
            }
            if (!Schema::hasColumn('users', 'sync_status')) {
                $table->enum('sync_status', ['pending', 'synced', 'error'])->default('pending');
            }
            if (!Schema::hasColumn('users', 'last_sync_at')) {
                $table->timestamp('last_sync_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'gympass_external_id')) {
                $table->string('gympass_external_id', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnstile_events');
        Schema::dropIfExists('turnstile_commands');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['turnstile_password', 'sync_status', 'last_sync_at', 'gympass_external_id']);
        });
    }
};
